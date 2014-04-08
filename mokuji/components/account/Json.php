<?php namespace components\account; if(!defined('TX')) die('No direct access.');

use components\account\classes\ControllerFactory as CF;
use \dependencies\account\EmailTokenTasks;
use \dependencies\account\ManagementTasks;
use \components\account\models\UserInfo;
use \dependencies\Data;

class Json extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'create_new_account' => 0,
      'create_password_reset_request' => 0, 'post_password_reset_request' => 0, //Alias
      'create_password_reset_finalization' => 0,
      'create_user_session' => 0, 'post_user_session' => 0, //Alias
      'delete_user_session' => 1,
      'update_password' => 1,
      'get_me' => 1,
      'get_login_status' => 0
    );
  
  ##
  ## USER SESSIONS
  ##
  
  /**
   * Attempt to log in the user.
   * @param \dependencies\Data $data Array containing 'email' and 'password' keys.
   * @param \dependencies\Data $params Empty array.
   * @return array Array with 'success' boolean and 'target_url' to suggest a redirect.
   */
  protected function create_user_session($data, $params)
  {
    
    //Use the session controller to log the user in.
    CF::getInstance()->Session->loginUser(
      $data->email->get(),
      $data->password->get(),
      ($data->persistent->get('string') === '1')
    );
    
    //If a target_url is set, go there.
    //Otherwise, '/admin/' for admins, the homepage for normal users or '/' if there is no homepage.
    $target_url = (string)url($data->target_url->otherwise(
      mk('Account')->isAdmin() ? '/admin/' : mk('Config')->user('homepage')->otherwise('/')
    ), true);
    
    //Exception would have been thrown if it failed, return as successful.
    return array(
      'success' => true,
      'target_url' => $target_url
    );
    
  }
  
  // Alias for create_user_session
  protected function post_user_session($data, $sub_routes, $options){
    return $this->create_user_session($data, $sub_routes);
  }
  
  /**
   * Logs the user out of the system.
   * @return void
   */
  protected function delete_user_session($data, $params)
  {
    
    CF::getInstance()->Session->logoutUser();
    
  }
  
  /**
   * Return the user object of the currently logged in user.
   * 
   * Requires a user to be logged in.
   * 
   * @param \dependencies\Data $data Empty array.
   * @param \dependencies\Data $params Empty array.
   * @return \dependencies\Data Sort of like a user model but not really because this is Mokuji.
   */
  protected function get_me($data, $parameters)
  {
    
    return CF::getInstance()->Session->getUserObject();
    
  }
  
  /**
   * Return the level of access the user has on the server.
   * 
   * `0` For not logged in.
   * `1` For logged in.
   * `2` For super-user.
   * 
   * @param \dependencies\Data $data Empty array.
   * @param \dependencies\Data $params Empty array.
   * @return integer
   */
  protected function get_login_status($data, $parameters)
  {
    
    return CF::getInstance()->Session->getLoginStatus();
    
  }
  
  ##
  ## USER ACCOUNTS
  ##
  
  //Allows user to register.
  protected function create_new_account($data, $params)
  {
    
    //Check basic formatting.
    $raw_data = $data;
    $data = Data($data)->having('email', 'username', 'password1', 'password2')
      ->email->validate('E-mail', array('required', 'string', 'not_empty', 'email'))->back()
      ->password1->validate('Password', array('required', 'string', 'not_empty', 'password'))->back()
      ->password2->validate('Confirm password', array('required', 'string', 'not_empty'))->back();
    
    //Check passwords match.
    if($data->password1->get() !== $data->password2->get()){
      $vex = new \exception\Validation(__($this->component, 'The passwords do not match', true));
      $vex->key('password1');
      $vex->errors(array(__($this->component, 'The passwords do not match', true)));
      throw $vex;
    }
    
    //Check Captcha.
    if(!mk('Component')->helpers('security')->call('validate_captcha', array('form_data'=>$raw_data))){
      $vex = new \exception\Validation(__($this->component, 'The security code is invalid', true));
      $vex->key('captcha_section');
      $vex->errors(array(__($this->component, 'The security code is invalid', true)));
      throw $vex;
    }
    
    //Lets go!
    $userData = $data->having('email', 'username');
    $userData->merge(array('password'=>$data->password1, 'level'=>1));
    $user = \dependencies\account\ManagementTasks::createUser($userData, array(
      'url' => '/?action=account/verify_email&uid=%u&token=%s'
    ));
    
    //No exceptions, so try to log in now.
    mk('Account')->login($data->email, $data->password1);
    
    return array(
      'success' => $success
    );
    
  }

  protected function create_password_reset_finalization($data, $params)
  {
    
    $data = Data($data)->having('token', 'uid', 'password1', 'password2')
      ->password1->validate('New password', array('required', 'string', 'not_empty', 'password'))->back()
      ->password2->validate('Confirm new password', array('required', 'string', 'not_empty'))->back();
    
    if($data->password1->get() !== $data->password2->get()){
      $vex = new \exception\Validation(__($this->component, 'The passwords do not match', true));
      $vex->key('password1');
      $vex->errors(array(__($this->component, 'The passwords do not match', true)));
      throw $vex;
    }
    
    //See if we want to use the new method.
    if(!$data->uid->is_empty())
    {
      
      $valid = EmailTokenTasks::validate(
        $data->uid,
        $data->token,
        'account.password_reset'
      );
      
      if(!$valid){
        throw new \exception\User(__($this->component, 'The token is invalid, it may have expired in the meantime', true));
      }
      
      //Set the new password.
      ManagementTasks::editUser($data->uid, $data->having(array('password' => 'password1')));
      
      return array(
        'message' => __($this->component, 'PASSWORD_RECOVERED_SUCCESSFULLY_P1', true)
      );
      
    }
    
    $token = mk('Sql')
      ->table('account', 'PasswordResetTokens')
      ->where('token', "'{$data->token}'")
      ->execute_single();
    
    if(!$token->is_expired->is_false())
      throw new \exception\User(__($this->component, 'The token is invalid, it may have expired in the meantime', true));
    
    $user = mk('Sql')
      ->table('account', 'Accounts')
      ->pk($token->user_id)
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\User(__($this->component, 'The token is invalid, it may have expired in the meantime', true));
      });
    
    //Get salt and algorithm.
    $user->merge(array(
      'salt' => mk('Security')->random_string(),
      'hashing_algorithm' => mk('Security')->pref_hash_algo()
    ));
    
    //Hash using above information.
    $user->merge(array(
      'password' =>
        mk('Security')->hash(
          $user->salt->get() . $data->password1->get(),
          $user->hashing_algorithm
        )
    ));
    
    //Store the changes to the user.
    $user->save();
    
    //Delete the token. Since it's been used now.
    $token->delete();
    
    //Send a message to the user about this.
    $subject = __($this->component, 'Password has been reset', 1);
    $body = mk('Component')->views('account')->get_html('email_password_reset_complete', array(
      'email' => $user->email->get(),
      'site_url' => url('/', true)->output,
      'site_name' => mk('Config')->user('site_name')->otherwise(url('/', true)->output),
      'ipa' => mk('Data')->server->REMOTE_ADDR,
      'user_agent' => mk('Data')->server->HTTP_USER_AGENT,
      'target_url' => url('/?action=account/use_password_reset_token/get&token='.$token->token->get(), true)
    ));
    
    //Use fancy method to send if it's available.
    if(mk('Component')->available('mail')){
      
      mk('Component')->helpers('mail')->send_fleeting_mail(array(
        'to' => array('name'=>$user->info->full_name->get(), 'email'=>$user->email->get()),
        'from' => array('name'=>EMAIL_NAME_AUTOMATED_MESSAGES, 'email'=>EMAIL_ADDRESS_AUTOMATED_MESSAGES),
        'subject' => $subject,
        'html_message' => $body
      ));
      
    }
    
    else{
      
      mail(
        $user->email->get('string'),
        $subject, $body,
        'From: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
        'Return-path: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
        'Content-type: text/html'.n
      );
      
    }
    
    return array(
      'message' => __($this->component, 'PASSWORD_RECOVERED_SUCCESSFULLY_P1', true)
    );
    
  }
  
  protected function create_password_reset_request($data, $params)
  {
    
    $data = Data($data)
      ->email->validate('E-mail address', array('required', 'string', 'not_empty', 'email'))->back();
    
    if(!mk('Component')->helpers('security')->call('validate_captcha', array('form_data'=>$data))){
      $vex = new \exception\Validation(__($this->component, 'The security code is invalid', true));
      $vex->key('captcha_section');
      $vex->errors(array(__($this->component, 'The security code is invalid', true)));
      throw $vex;
    }
    
    //If the new method is available. Go for it.
    if(EmailTokenTasks::isEmailTokensSupported())
    {
      
      ManagementTasks::passwordReset($data->email, '/admin/?password_forgotten=token&uid=%u&token=%s');
      
      return array(
        'message' => __($this->component, 'An e-mail has been sent to the specified address with further instructions', true).'.'
      );
      
    }
    
    $data = $data->having('email');
    
    $com_name = $this->component;

    //Catch all exceptions here. We don't want to leak information to the user.
    try{
      
      mk('Sql')
        ->table('account', 'Accounts')
        ->where('email', "'{$data->email}'")
        ->execute_single()
        ->is('set')
        
        //User found, create token and send it.
        ->success(function($user)use($com_name){
          
          //First of all, clear expired token.
          //Not required for this operation, but keeps things clean.
          //And it makes generating unique tokens more efficient later on.
          mk('Sql')
            ->table('account', 'PasswordResetTokens')
            ->where('dt_expiry', '>', time())
            ->execute()
            ->each(function($token){
              $token->delete();
            });
          
          //Now create a new one.
          $token = mk('Sql')
            ->model('account', 'PasswordResetTokens')
            ->generate($user->id)
            ->save();
          
          //Send it.
          $subject = __($com_name, 'Password reset', 1);
          $body = mk('Component')->views('account')->get_html('email_password_reset_token', array(
            'email' => $user->email->get(),
            'site_url' => url('/', true)->output,
            'site_name' => mk('Config')->user('site_name')->otherwise(url('/', true)->output),
            'ipa' => mk('Data')->server->REMOTE_ADDR,
            'user_agent' => mk('Data')->server->HTTP_USER_AGENT,
            'target_url' => url('/?action=account/use_password_reset_token/get&token='.$token->token->get(), true)
          ));
          
          //Use fancy method to send if it's available.
          if(mk('Component')->available('mail')){
            
            mk('Component')->helpers('mail')->send_fleeting_mail(array(
              'to' => array('name'=>$user->info->full_name->get(), 'email'=>$user->email->get()),
              'from' => array('name'=>EMAIL_NAME_AUTOMATED_MESSAGES, 'email'=>EMAIL_ADDRESS_AUTOMATED_MESSAGES),
              'subject' => $subject,
              'html_message' => $body
            ));
            
          }
          
          else{
            
            mail(
              $user->email->get('string'),
              $subject, $body,
              'From: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
              'Return-path: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
              'Content-type: text/html'.n
            );
            
          }
          
        })
        
        //User with email not found. Send them a message.
        ->failure(function()use($data, $com_name){
          
          $subject = __($com_name, 'Password reset', 1);
          $body = mk('Component')->views('account')->get_html('email_password_reset_no_account', array(
            'email' => $data->email->get(),
            'site_url' => url('/', true)->output,
            'site_name' => mk('Config')->user('site_name')->otherwise(url('/', true)->output),
            'ipa' => mk('Data')->server->REMOTE_ADDR,
            'user_agent' => mk('Data')->server->HTTP_USER_AGENT
          ));
          
          //Use fancy method to send if it's available.
          if(mk('Component')->available('mail')){
            
            mk('Component')->helpers('mail')->send_fleeting_mail(array(
              'to' => array('email'=>$data->email->get()),
              'from' => array('name'=>EMAIL_NAME_AUTOMATED_MESSAGES, 'email'=>EMAIL_ADDRESS_AUTOMATED_MESSAGES),
              'subject' => $subject,
              'html_message' => $body
            ));
            
          }
          
          else{
            
            mail(
              $data->email->get('string'),
              $subject, $body,
              'From: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
              'Return-path: '.EMAIL_NAME_AUTOMATED_MESSAGES.'<'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'.n.
              'Content-type: text/html'.n
            );
            
          }
          
        });
      
    }catch(\Exception $ex){
      mk('Logging')->log('Account', 'Password reset request', 'Exception occurred: '.$ex->getMessage());
    }
    
    return array(
      'message' => __($this->component, 'An e-mail has been sent to the specified address with further instructions', true).'.'
    );
    
  }

  // Alias for create_password_reset_request
  protected function post_password_reset_request($data, $sub_routes, $options){
    return $this->create_password_reset_request($data, $sub_routes);
  }

  protected function update_password($data, $parameters)
  {
    
    //See if a password should have been given.
    if(!mk('Component')->helpers('account')->should_claim())
      throw new \exception\Validation('You have already claimed this account.');
    
    //Validate.
    $data = $data->having('password', 'password_check')
      ->password->validate('Password', array('required', 'string', 'not_empty', 'password'))->back()
      ->password_check->validate('Confirm password', array('required', 'string', 'not_empty'))->back()
    ;
    
    //If passwords are not equal, throw exception.
    $data->password->eq($data->password_check)->failure(function(){
      $vex = new \exception\Validation('Passwords are not the same.');
      $vex->key('password');
      $vex->errors(array('Passwords are not the same.'));
      throw $vex;
    });
    
    //Also make sure we claim the account.
    $info = Data(array(
      'password' => $data->password,
      'is_claimable' => false,
      'is_active' => true
    ));
    
    //Update the user password and flags.
    $user = ManagementTasks::editUser(mk('Account')->id, $info);
    
    //See if we should claim the user the old way.
    if(!ManagementTasks::isExtendedCoreUsersSupported()){
      $user->user_info
        ->set_status('claimed')
        ->merge(array('claim_key'=>'NULL'))
        ->save();
    }
    
    //Also, we want to get rid of our 2 hour limited session.
    mk('Account')->login($user->email, $data->password);
    
    return $user->having('id', 'email', 'username', 'level');
    
  }
  
  //Create a new user.
  public function create_user($data, $parameters)
  {
    
    //Does not check permissions, so access level 2.
    
    //Handle one alias for the level value.
    $data->merge(array('level' => $data->check('is_admin') ? 2 : 1));
    
    //Check if password should be filtered.
    $method = strtolower($data->password_method->get('string'));
    
    //Do the basic user create call.
    $claim = $method === 'claim';
    $user = ManagementTasks::createUser($data, array(
      'claim' => $claim,
      'url' => $claim ? 
        '/?action=account/claim_account&uid=%u&token=%s':
        '/?action=account/verify_email&uid=%u&token=%s'
    ));
    
    //Add our component's additional data as well.
    $this->_update_user_info($user, $data);
    
    #TODO: Make prettier.
    $user->user_info;
    $user->full_name;
    
    return $user;
    
  }
  
  //Updates an existing user.
  public function update_user($data, $parameters)
  {
    
    //Does not check permissions, so access level 2.
    
    //Handle one alias for the level value.
    $data->merge(array('level' => $data->check('is_admin') ? 2 : 1));
    
    //Do the core edit.
    $user = ManagementTasks::editUser($parameters->{0}, $data);
    
    //Do component data edit.
    $this->_update_user_info($user, $data);
    
    #TODO: Make prettier.
    $user->user_info;
    $user->full_name;
    
    return $user;
    
  }
  
  /**
   * Helper function that sets form data to the UserInfo model.
   */
  private function _update_user_info(Data $user, Data $data)
  {
    
    //Add our component's additional data as well.
    $userInfo = $this->model('UserInfo')
      ->set(array(
        'user_id' => $user->id,
        'comments' => $data->comments->otherwise('NULL')
      ));
    
    //If we need to store things the old way, do that.
    if(!ManagementTasks::isExtendedCoreUsersSupported())
    {
      
      $userInfo
        
        //Store the name.
        ->merge($data->having(array(
          'name' => 'first_name',
          'family_name' => 'last_name'
        )))
        
        //Merge the status information to a bitwise field.
        ->merge(array(
          'status' =>
            ($data->check('is_active') ? UserInfo::STATUS_ACTIVE : 0) |
            ($data->check('is_banned') ? UserInfo::STATUS_BANNED : 0) |
            ($data->check('is_claimable') ? UserInfo::STATUS_CLAIMABLE : 0)
        ));
      
    }
    
    //Store that.
    $userInfo->save();
    
    //Set the proper groups.
    $this->helper('set_user_group_memberships', Data(array(
      'user_group' => $data->user_group,
      'user_id' => $user->id
    )));
    
  }
  
  ##
  ## MAIL
  ##
  
  protected function get_mail_autocomplete($data, $parameters)
  {
    
    $resultset = Data();
    
    mk('Sql')
      ->table('account', 'Accounts')
      ->join('UserInfo', $ui)
      ->where("(`$ui.status` & (1|4))", '>', 0)
      ->where(mk('Sql')->conditions()
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
    
    mk('Sql')
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
  
  protected function create_mail($data, $parameters)
  {
    
    $recievers = Data();
    
    //Add groups.
    mk('Sql')
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
    mk('Sql')
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
      if(mk('Component')->available('autologin')){
        
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
          $link = mk('Component')->helpers('autologin')->call('generate_autologin_link', $linkParams);
          $message = str_replace($autologinElement[0], '<a class="autologin" data-autologin="true" href="'.$link->output.'">', $message);
          
        }
        
      }
      
      //Validate email through mail component.
      mk('Component')->helpers('mail')->send_fleeting_mail(array(
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
    
    mk('Logging')->log('Account', 'Mail sent', 'Sent '.$mailers->size().' email.');
    
  }
  
}
