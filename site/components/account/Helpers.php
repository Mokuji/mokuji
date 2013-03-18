<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  /**
   * Force a reset of the password of the user.
   *
   * @author Beanow
   * @param Integer/Array(Integer) $user_id The user id's to reset the password for.
   * @return \dependencies\UserFunction The user function in which the password is reset.
   */
  public function reset_password($user_id)
  {
    
    $that = $this;
    
    return tx('Resetting password', function()use($user_id, $that){
      
      tx('Logging')->log('Account', 'Reset password', 'Called with: '.Data($user_id)->dump());
      
      //Validate input.
      $user_id = Data($user_id)
        ->each(function($node){
          tx('Logging')->log('Account', 'Reset password', 'Validating for: '.$node);
          return Data($node)->validate('User ID', array('required', 'number', 'gt'=>0));
        });
      
      //Get the users.
      tx('Sql')
        ->table('account', 'Accounts')
        ->pk($user_id)
        ->execute()
        
        //Check users were found.
        ->is('empty', function(){
          tx('Logging')->log('Account', 'Reset password', 'No users found.');
          throw new \exception\User('No User found for this User ID.');
        })
        
        ->each(function($user){
          
          tx('Logging')->log('Account', 'Reset password', 'Init for user: '.$user->email->get('string'));
          
          //Create claim key.
          $claim_key = tx('Security')->random_string(10);
          
          //Set database values.
          $user
            ->password->set(null)->back()
            ->save()
              ->user_info
              ->claim_key->set($claim_key)->back()
              ->set_status('claimable')
              ->save();
          
          //Create various links.
          $links = Data(array(
            'for_link' => url('/', true)->output,
            'claim_link' => url('/?action=account/claim_account/get&id='.$user->id.'&claim_key='.$claim_key, true)->output,
            'unsubscribe_link' => url('/?action=account/unsubscribe/get&email='.urlencode($user->email->get('string')), true)->output
          ));

          $username = $user->username->otherwise($user->user_info->email);
          
          //Send the invitation email.
          if(tx('Component')->available('mail')){

            tx('Component')->helpers('mail')->send_fleeting_mail(array(
              'to' => array('name'=>$user->user_info->username->otherwise(''), 'email'=>$user->email),
              'subject' => __('Klaar voor de start... AF!', 1),
              'html_message' => tx('Component')->views('account')->get_html('email_user_password_reset', $links->having('for_link', 'claim_link', 'unsubscribe_link')->merge(array('username' => $username)))
            ))
            
            ->failure(function($info){
              throw $info->exception;
            });
            
          }
          
          else{
            
            mail(
              $user->email,
              __('Invitation for', 1).': '.$data->for_title,
              tx('Component')->views('account')->get_html('email_user_invited', $data->having('for_link', 'for_title', 'claim_link', 'unsubscribe_link')->merge(array('username' => $username)))
            );
            
          }
          
          tx('Logging')->log('Account', 'Reset password', 'Succeeded for user '.$user->email->get('string').'.');

        });
      
    });
    
  }
  
  /**
   * Invite a new user to create an account.
   *
   * @author Beanow
   * @param String $data->username The username to give the user. Note: when claiming the user can change this.
   * @param Email $data->email The email address to send an invite to.
   * @param Int $data->level The user level to set the user.
   * @param String $data->for_title What to invite the user for. Example: 'Project Xtra Coolness'.
   * @param String $data->for_link The link to what to invite the user for. Example: '?page_id=1337'.
   * @return \dependencies\UserFunction The user function in which the invitation is sent.
   */
  public function invite_user($data)
  {
    
    return tx('Sending invitation', function()use($data){
      
      //Validate input.
      $data = Data(data_of($data))->having('username', 'email', 'level', 'for_title', 'for_link', 'name', 'preposition', 'family_name', 'comments')
        ->email->validate('Email', array('required', 'email'))->back()
        ->username->validate('Username', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->for_title->validate('For-title', array('required', 'string', 'no_html'))->back()
        ->for_link->validate('For-link', array('required', 'url'))->back()
        ->name->validate('Name', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->preposition->validate('Preposition', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->family_name->validate('Family name', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->comments->validate('Comments', array('string', 'no_html'))->back();
      
      //Check if the user is already created.
      $duplicates = tx('Sql')
        ->table('account', 'Accounts')
        ->where('email', $data->email)
        ->join('UserInfo', $UI)
        ->where("(`$UI.status` & (1 | 4))", '>', 0) //activated or claimable
      ;
      
      if($duplicates->count()->get('int') > 0){
        tx('Logging')->log('Duplicate invite for id '.$duplicates->execute_single()->id);
        return $duplicates->execute_single()->id;
        // throw new \exception\User('A user with this email address has already been created.');
      }
      
      //Create the user in the core tables.
      $user = tx('Sql')
        ->model('account', 'Accounts')
        ->email->set($data->email->get('string'))->back()
        ->username->set($data->username)->back()
        ->password->set(null)->back()
        ->level->set($data->level->otherwise(1))->back()
        ->save();
      
      //Create claim key.
      $data->claim_key = tx('Security')->random_string(10);
      
      //Store additional info in the account tables.
      tx('Sql')
        ->model('account', 'UserInfo')
        ->merge($data->having('name', 'preposition', 'family_name', 'comments'))
        ->user_id->set($user->id)->back()
        ->claim_key->set($data->claim_key)->back()
        ->set_status('reclaim')
        ->save();
      
      //Create various links.
      $data->for_link = url($data->for_link->get('string'), true)->output;
      $data->claim_link = url('/?action=account/claim_account/get&id='.$user->id.'&claim_key='.$data->claim_key, true)->output;
      $data->unsubscribe_link = url('/?action=account/unsubscribe/get&email='.urlencode($user->email->get('string')), true)->output;
      
      //Send the invitation email.
      if(tx('Component')->available('mail')){
        
        tx('Component')->helpers('mail')->send_fleeting_mail(array(
          'to' => array('name'=>$data->username->otherwise(''), 'email'=>$user->email),
          'subject' => __('Invitation for', 1).': '.$data->for_title,
          'html_message' => tx('Component')->views('account')->get_html('email_user_invited', $data->having('for_link', 'for_title', 'claim_link', 'unsubscribe_link'))
        ))
        
        ->failure(function($info){
          throw $info->exception;
        });
        
      }
      
      else{
        
        mail(
          $user->email,
          __('Invitation for', 1).': '.$data->for_title,
          tx('Component')->views('account')->get_html('email_user_invited', $data->having('for_link', 'for_title', 'claim_link', 'unsubscribe_link'))
        );
        
      }
      
      return $user->id;
      
    });
    
  }
  
  /**
   * Create a new user.
   *
   * @author Beanow
   * @param Email $data->email The email address for the new user.
   * @param String $data->username The username for the new user.
   * @param String $data->password The password for the new user.
   * @param int $data->level The user level to set for the new user (1 or 2).
   * @return \components\account\models\Accounts The account of the newly created user.
   */
  public function create_user($data)
  {
    
    //Validate input.
    $data = $data->having('email', 'username', 'password', 'level', 'name', 'preposition', 'family_name', 'comments')
      ->email->validate('Email address', array('required', 'email'))->back()
      ->password->validate('Password', array('string', 'password'))->back()
      ->username->validate('Username', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->level->validate('User level', array('required', 'number', 'between' => array(1, 2)))->back()
      ->name->validate('Name', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->preposition->validate('Preposition', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->family_name->validate('Family name', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->comments->validate('Comments', array('string', 'no_html'))->back();
    
    //UPDATED: 28 June 2012, by Beanow
    //Now defaults to the default hashing algorithm and salt settings defined by core-security.
    
    //Get salt and algorithm.
    $data->salt = tx('Security')->random_string();
    $data->hashing_algorithm = tx('Security')->pref_hash_algo();
    
    //Hash the password.
    $data->password->set(tx('Security')->hash(
      $data->salt->get() . $data->password->get(),
      $data->hashing_algorithm
    ));
    
    /* ## No longer using this since 28 June 2012 ##
    //For now we do the ugly thing... ¬_¬
    //But using the data function so it will DIE straight away once it's deprecated.
    $data->password = $data->password->md5();
    */
    
    //Check if the user is already created.
    if(tx('Sql')->table('account', 'Accounts')->join('UserInfo', $ui)->where('email', $data->email)->where("(`$ui.status` & (1|4))", '>', 0)->count()->get('int') > 0){
      return tx('Sql')->table('account', 'Accounts')->join('UserInfo', $ui)->where('email', $data->email)->where("(`$ui.status` & (1|4))", '>', 0)->execute_single();
      // throw new \exception\User('A user with this email address has already been created.');
    }
    
    //Create the user in the core tables.
    $user = tx('Sql')
      ->model('account', 'Accounts')
      ->set($data->having('email', 'username', 'password', 'salt', 'hashing_algorithm', 'level'))
      ->save();
    
    //Store additional info in the account tables.
    tx('Sql')
      ->model('account', 'UserInfo')
      ->set($data->having('name', 'preposition', 'family_name', 'comments')->merge($user->having(array('user_id'=>'id')))->merge(array('status'=>1)))
      ->save();

    //Return the user model.
    return $user;
    
  }
  
  /**
   * Whether the logged in user should claim their account or not.
   *
   * @author Beanow
   * @return Boolean Whether the logged in user should claim their account or not.
   */
  public function should_claim()
  {
    
    $user_info = $this->table('UserInfo')
      ->pk(tx('Account')->user->id->get('int'))
      ->execute_single();
    
    //If there's no user info found for the logged in user then return false.
    if(!$user_info->is_set())
      return false;
    
    $should_claim = false;
    
    //Check the user status is claimable.
    $user_info->check_status('claimable')
    ->success(function()use(&$should_claim){
      //If it is then check if the user is logged in.
      $should_claim = tx('Account')->user->check('login');
    });
    
    return $should_claim;
    
  }
  
  public function set_group_members($group_id, $members)
  {
    
    raw($group_id, $members);
    
    //Could have been an empty data object.
    $skip = $members === null;
    
    //Validate.
    if(!is_int($group_id))
      throw new \exception\InvalidArgument('Group ID must be an integer.');
    
    if(!$skip && !is_array($members))
      throw new \exception\InvalidArgument('Members must be an array.');
    
    //If there are members provided.
    if(!$skip || count($members) > 0)
    {
      
      //Remove all members not in the list.
      //Like a pro bouncer.
      tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->where('user_id', '!', $members)
        ->execute()
        ->each(function($member){
          $member->delete();
        });
      
      //Find the members that were already inside.
      $alreadyMember = tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->where('user_id', $members)
        ->execute()
        ->map(function($member){
          return $member->user_id->get();
        })
        ->as_array();
      
      //Check the member list again.
      foreach($members as $member){
        
        //For the ones already inside you can just skip them.
        if(in_array($member, $alreadyMember))
          continue;
        
        //For anyone else, invite them in!
        tx('Sql')
          ->model('account', 'AccountsToUserGroups')
          ->set(array(
            'user_id' => $member,
            'user_group_id' => $group_id
          ))
          ->save();
        
      }
      
    }
    
    //If there are no members provided.
    else
    {
      
      //Just remove them all.
      tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->execute()
        ->each(function($member){
          $member->delete();
        });
      
    }
    
  }

  public function get_new_users($limit = 5)
  {
    return $this->table('Accounts')->join('UserInfo', $info)->select("$info.name", 'name')->limit($limit)->execute();
  }
  
  public function import_users($data)
  {
    
    $that = $this;
    return tx('Importing users', function()use($data, $that){
      
      tx('Validating input', function()use($data){
        
        $data = $data->having('overrides', 'retry', 'collumn_name', 'delimiter', 'user_group')
          ->overrides->validate('Overrides', array('array'))->back()
          ->collumn_name->validate('Collumn names', array('array'))->back()
          ->delimiter->validate('CSV delimiter', array('string', 'length'=>1))->back()
          ->user_group->validate('User groups', array('array'))->back();
        
        //Set the user groups if there are any.
        $data->user_group->is('set', function($user_group){
          tx('Data')->session->account->import->user_group->set($user_group->as_array());
        });
        
      })
      
      //If data is not ok, push an error.
      ->failure(function($userfunction){
        
        //Set this as failure.
        $ex = new \exception\Validation("");
        $ex->errors(array(array(
          'message' => $userfunction->get_user_message()
        )));
        $ex->value(false);
        throw $ex;
        
      });
      
      //Perform the import.
      $import = tx('CSV')
        ->import('account', 'users', $data->retry->is_set())
        ->initialize_source_file($data->delimiter->get('string'))
        ->process_import_data('Accounts', $data->collumn_name, array(
          'unique_fields' => array('email', 'username'),
          'overrides' => $data->overrides->as_array()
        ));
      
      //Check for errors.
      $errors = $import->errors();
      if(count($errors) > 0){
        
        //Set this as recoverable error.
        $ex = new \exception\Validation("");
        $ex->errors($errors);
        $ex->value(true);
        throw $ex;
        
      }
      
      //Go over the users.
      $import->resultset()->each(function($user)use($that){
        
        tx('Logging')->log('Account', 'User import', 'Inviting user '.$user->email);
        
        //Invite them.
        tx('Component')->helpers('account')->invite_user($user->merge(array(
          'for_link' => url('pid=1', true)->output,
          'for_title' => 'Import testing'
        )))
          
          ->failure(function($ufu){
            trace($ufu->get_user_message(), $ufu->exception);
          })
          
          ->success(function($ufu)use($that){
            
            //Make them members of the right groups.
            $that->helper('set_user_group_memberships', Data(array(
              'user_group' => tx('Data')->session->account->import->user_group,
              'user_id' => $ufu->return_value
            )));
            
          });
        
      });
      
      return $import->resultset();
      
    });
    
  }
  
  /**
   * Sets the user group memberships for an account.
   *
   * @author Beanow
   * data >> user_group, user_id
   */
  public function set_user_group_memberships($data)
  {
    
    //Set the proper groups.
    if($data->user_group->size() > 0)
    {
      
      //Go over each user group.
      tx('Sql')
        ->table('account', 'UserGroups')
        ->execute()
        ->each(function($usergroup)use($data){
          
          //When we're a part of this group.
          if($data->user_group->offsetExists($usergroup->id))
          {
            //See if there is already an entry for this group.
            tx('Sql')
              ->table('account', 'AccountsToUserGroups')
              ->where('user_id', $data->user_id)
              ->where('user_group_id', $usergroup->id)
              ->count()
              
              //If not, then insert it now.
              ->lt(1, function()use($usergroup, $data){
                tx('Sql')
                  ->model('account', 'AccountsToUserGroups')
                  ->set(array(
                    'user_id' => $data->user_id->get(),
                    'user_group_id' => $usergroup->id->get()
                  ))
                  ->save();
                
              });
            
          }
          
          //When we're not a part of this group.
          else
          {
            //See if there is already an entry for this group.
            tx('Sql')
              ->table('account', 'AccountsToUserGroups')
              ->where('user_id', $data->user_id)
              ->where('user_group_id', $usergroup->id)
              ->execute_single()
              
              //If there is, delete it.
              ->not('empty', function($usergroup){
                $usergroup->delete();
              });
            
          }
          
        });
      
    }
    
    //When there are no user groups provided.
    else
    {
      //Just remove all of them.
      tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_id', $data->user_id)
        ->execute()
        ->each(function($usergroup){
          $usergroup->delete();
        });
      
    }
    
  }
  
}
