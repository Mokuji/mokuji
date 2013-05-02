<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  protected
    $default_permission = 2,
    $permissions = array(
      'update_password' => 1
    );
  
  protected function update_password($data, $parameters)
  {
    
    //See if a password should have been given.
    if(!tx('Component')->helpers('account')->should_claim())
      throw new \exception\Validation('You have already claimed this account.');
    
    //Validate.
    $data = $data->having('password', 'password_check')
      ->password->validate('Password', array('required', 'string', 'not_empty', 'password'))->back()
      ->password_check->validate('Confirm password', array('required', 'string', 'not_empty'))->back()
    ;
    
    //If passwords are not equal, throw exception.
    $data->password->eq($data->password_check)->failure(function(){
      throw new \exception\Validation('Passwords are not the same.');
    });
    
    //Get salt and algorithm.
    $data->salt = tx('Security')->random_string();
    $data->hashing_algorithm = tx('Security')->pref_hash_algo();
    
    //Hash using above information.
    $data->password = tx('Security')->hash(
      $data->salt->get() . $data->password->get(),
      $data->hashing_algorithm
    );
    
    //Get the old user model from the database.
    $user = tx('Sql')->table('account', 'Accounts')->pk(tx('Account')->user->id)->execute_single()
    
    //If it's empty, throw an exception.
    ->is('empty', function(){
      throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
    })
    
    //Merge the fields from the given data.
    ->merge($data->having('password', 'salt', 'hashing_algorithm'))
    
    //Save to database.
    ->save();
    
    //See if we should claim the user.
    $user_info = $user->user_info;
    $user_info
      ->check_status('claimable', function($user_info){
        
        //Set status and unset claim key.
        $user_info
          ->set_status('claimed')
          ->claim_key->set('NULL')->back()
          ->save();
        
      });
    
    return $user->having('id', 'email', 'username', 'level');
    
  }
  
  protected function get_mail_autocomplete($data, $parameters)
  {
    
    $resultset = Data();
    
    tx('Sql')
      ->table('account', 'Accounts')
      ->join('UserInfo', $ui)
      ->where("(`$ui.status` & (1|4))", '>', 0)
      ->where(tx('Sql')->conditions()
        ->add('1', array('email', '|', "'%{$parameters->{0}}%'"))
        ->add('2', array("$ui.name", '|', "'%{$parameters->{0}}%'"))
        ->add('3', array("$ui.family_name", '|', "'%{$parameters->{0}}%'"))
        ->combine('4', array('1', '2', '3'), 'OR')
        ->utilize('4')
      )
      ->execute()
      ->each(function($user)use($resultset){
        $resultset->push(array(
          'is_user' => true,
          'id' => $user->id,
          'label' => $user->user_info->full_name->not('empty', function($full_name)use($user){ return $full_name->get().' <'.$user->email->get().'>'; })->otherwise($user->email),
          'value' => $user->email
        ));
      });
    
    tx('Sql')
      ->table('account', 'UserGroups')
      ->where('title', '|', "'%{$parameters->{0}}%'")
      ->execute()
      ->each(function($group)use($resultset){
        $resultset->push(array(
          'is_group' => true,
          'id' => $group->id,
          'label' => __('Group', 1).': '.$group->title->get().' ('.$group->users->size().')',
          'value' => $group->title
        ));
      });
    
    return $resultset->as_array();
    
  }
  
  //Send mail might have been a better name. But that's the current REST convention for you.
  //                                         ^ Stop your whining.
  protected function create_mail($data, $parameters)
  {
    
    $recievers = Data();
    
    //Add groups.
    tx('Sql')
      ->table('account', 'AccountsToUserGroups')
      ->where('user_group_id', $data->group)
      ->join('Accounts', $A)
      ->workwith($A)
      ->join('UserInfo', $UI)
      ->where("(`$UI.status` & (1|4))", '>', 0)
      ->execute($A)
      ->each(function($node)use($recievers){
        $recievers->merge(array($node->id->get() => $node->email));
      });
    
    //Add individual users.
    tx('Sql')
      ->table('account', 'Accounts')
      ->pk($data->user)
      ->join('UserInfo', $UI)
      ->where("(`$UI.status` & (1|4))", '>', 0)
      ->execute()
      ->each(function($node)use($recievers){
        $recievers->merge(array($node->id->get() => $node->email));
      });
    
    //Check if we have enough recievers.
    if($recievers->is_empty()){
      $ex = new \exception\Validation("You must provide at least one recipient.");
      $ex->key('recievers_input');
      $ex->errors(array('You must provide at least one recipient'));
      throw $ex;
    }
    
    //Mailers only validate, so store them for later.
    $mailers = Data();
    
    //Itterate over recievers.
    $recievers->each(function($reciever)use($data, $mailers){
      
      $message = $data->message->get();
      
      //If we have autologin component available.
      if(tx('Component')->available('autologin')){
        
        //Find all autologin links.
        preg_match_all('~<a[^>]+data-autologin="true"[^>]+>~', $data->message->get(), $autologinElements, PREG_SET_ORDER);
        
        //Go over each of them.
        foreach($autologinElements as $autologinElement)
        {
          
          //Gather autologin-link generation parameters.
          $linkParams = Data(array(
            'user_id' => $reciever->key(),
            'link_admins' => true
          ));
          
          //Find it's parameters.
          preg_match_all('~data-(failure_url|success_url)="([^"]*)"~', $autologinElement[0], $dataParams, PREG_SET_ORDER);
          
          //Merge each parameter into the link parameters.
          foreach($dataParams as $dataParam){
            $linkParams->merge(array($dataParam[1] => html_entity_decode($dataParam[2]))); //use html_entity_decode because of CKEDITOR bug.
          }
          
          //Replace the element with the resulting link.
          $link = tx('Component')->helpers('autologin')->call('generate_autologin_link', $linkParams);
          $message = str_replace($autologinElement[0], '<a class="autologin" data-autologin="true" href="'.$link->output.'">', $message);
          
        }
        
      }
      
      //Validate email through mail component.
      tx('Component')->helpers('mail')->send_fleeting_mail(array(
        'to' => $reciever,
        'subject' => $data->subject->get(),
        'html_message' => $message,
        'validate_only' => true
      ))
      
      ->failure(function($info){
        throw $info->exception;
      })
      
      //If it's ok, store the mailer.
      ->success(function($info)use($mailers){
        $mailers->push($info->return_value);
      });
      
    });
    
    //After all mail was validated, send it.
    $mailers->each(function($mailer){
      try{
        $mailer->get()->Send();
      }catch(\Exception $e){
        throw new \exception\Programmer('Fatal error sending email. Exception message: %s', $e->getMessage());
      }
    });
    
    tx('Logging')->log('Account', 'Mail sent', 'Sent '.$mailers->size().' email.');
    
  }
  
  //Create a new user.
  public function create_user($data, $parameters)
  {
    
    //Calculate user-level.
    $level = $data->admin->eq('on')->success(function(){return '2';})->otherwise('1');
    
    //If the user is to choose their own password.
    if($data->choose_password->get('boolean'))
    {
      
      //Invite the user.
      $user = tx('Component')->helpers('account')->call('invite_user', array(
        'email' => $data->email,
        'username' => $data->username,
        'level' => $data->level,
        'for_title' => url('/', true)->output,
        'for_link' => '/'
      ))
      
      //Pass the exception on to the REST handler.
      ->failure(function($info){        
        throw $info->exception;
      });

    }
    
    //If the user is merely to be added..
    else
    {

      //Create the user.
      $user = tx('Component')->helpers('account')->call('create_user', array(
        'email' => $data->email,
        'username' => $data->username,
        'password' => $data->password,
        'name' => $data->name,
        'preposition' => $data->preposition,
        'family_name' => $data->family_name,
        'level' => $level,
        'comments' => $data->comments
      ))
      
      //Pass on any exceptions to the REST hander.
      ->failure(function($info){
        throw $info->exception;
      });
      
      //If we need to notify the user.
      #TEMP: Disabled until improved.
      if(false && $data->notify_user->get('boolean'))
      {
        
        //Send email.
        tx('Component')->helpers('mail')->send_fleeting_mail(array(
          'to' => $data->username.' <'.$user->email.'>',
          'subject' => __('Account created', 1),
          'html_message' => tx('Component')->views('account')->get_html('email_user_created', $data->having('email', 'username', 'user_id', 'level'))
        ))
        
        ->failure(function($info){
          tx('Controller')->message(array(
            'error' => $info->get_user_message()
          ));
        }); 
        
      }
      
    }
    
    //Set the proper groups.
    $this->helper('set_user_group_memberships', Data(array(
      'user_group' => $data->user_group,
      'user_id' => $user->id
    )));
    
  }
  
  //Updates an existing user.
  public function update_user($data, $parameters)
  {
    
    //Check if the password was given and filled in..
    $data->password->is('set')->and_not('empty')
    
    //In case it was given.
    ->success(function()use(&$data){
      
      //Get salt and algorithm.
      $data->salt = tx('Security')->random_string();
      $data->hashing_algorithm = tx('Security')->pref_hash_algo();
      
      //Hash using above information.
      $data->password = tx('Security')->hash(
        $data->salt->get() . $data->password->get(),
        $data->hashing_algorithm
      );
      
    })
    
    //In case of no password, unset it from the data.
    ->failure(function()use(&$data){
      $data->password->un_set();
    });
    
    //Get the old user model from the database.
    $user = tx('Sql')->table('account', 'Accounts')->pk($data->id)->execute_single()
    
    //If it's empty, throw an exception.
    ->is('empty', function(){
      throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
    })
    
    //Merge the fields from the given data.
    ->merge($data->having('email','username', 'password', 'salt', 'hashing_algorithm'))
    
    //Calculate user-level.
    ->push('level', $data->admin->eq('on')->success(function(){return '2';})->otherwise('1'))
    
    //Save to database.
    ->save();
    
    //Get the old user information from the database.
    tx('Sql')->table('account', 'UserInfo')->pk($user->id)->execute_single()
    
    //Test if it's empty.
    ->is('empty')
    
    //If it was, en thus does not exist, create a new row.
    ->success(function($user_info)use($data, $user){
      tx('Sql')->model('account', 'UserInfo')->set($data->having('name', 'preposition', 'family_name', 'comments')->merge($user->having(array('user_id'=>'id'))))->save();
    })
    
    //If it already exists, merely update the row.
    ->failure(function($user_info)use($data){
      $user_info->merge($data->having('name', 'preposition', 'family_name', 'comments'))->save();
    });
    
    //Set the proper groups.
    $this->helper('set_user_group_memberships', Data(array(
      'user_group' => $data->user_group,
      'user_id' => $user->id
    )));
    
  }
  
}
