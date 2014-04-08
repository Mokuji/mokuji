<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \dependencies\BaseModel;
use \dependencies\email\EmailTasks;

/**
 * Provides static methods to perform account management tasks.
 */
abstract class ManagementTasks
{
  
  /*
    #TODO
    * Banning??
  */
  
  /**
   * Check if registration is enabled.
   * @return boolean
   */
  public static function isRegistrationEnabled(){
    #TODO: Make configurable.
    return true;
  }
  
  /**
   * Checks whether or not the new extended core users is supported or not.
   * @return boolean
   */
  public static function isExtendedCoreUsersSupported(){
    return !mk('Sql')->execute_single("DESCRIBE #__core_users is_active")->is_empty();
  }
  
  /**
   * Checks if the currently logged in user should claim their account or not.
   * @return boolean
   */
  public static function shouldClaim()
  {
    
    //When not logged in, we don't have access to an account to claim.
    if(!mk('Account')->isLoggedIn())
      return false;
    
    if(ManagementTasks::isExtendedCoreUsersSupported()){
      
      //Look for the claimable flag.
      $claimable = mk('Sql')->execute_scalar(mk('Sql')->make_query(''
        ."SELECT is_claimable FROM `#__core_users`"
        ."WHERE id = ?"
        ,mk('Account')->id
      ))->get('string');
      
      return $claimable === "\x01";
      
    }
    
    $user_info = $this->table('UserInfo')
      ->pk(mk('Account')->id)
      ->execute_single();
    
    //If there's no user info found for the logged in user then return false.
    if(!$user_info->is_set())
      return false;
    
    $should_claim = false;
    
    //Check the user status is claimable.
    $user_info->check_status('claimable')
    ->success(function()use(&$should_claim){
      //If it is then check if the user is logged in.
      $should_claim = mk('Account')->isLoggedIn();
    });
    
    return $should_claim;
    
  }
  
  /**
   * Creates a new user account.
   * 
   * Note: Attempts at registering should ALWAYS be protected at the form handling level.
   * Otherwise attackers will be able to discover existing e-mail addresses and usernames.
   * As well as create unlimited accounts for spamming or even DOS attacks by taking up the
   * entire username and e-mail space.
   * 
   * Options:
   *   * silent = whether or not to send messages to the user.
   *   * claim = whether or not to use the claiming process instead of setting the password.
   *   * url = the sprintf formatted url that will handle email verification / claiming links.
   * 
   * @param  Data $data The set of data to insert.
   * @param  array $options Options to alter the process slightly.
   * @return BaseModel The user that has been created.
   */
  public static function createUser(Data $data, $options=array())
  {
    
    #TODO: Check for registration enabled setting.
    
    //Data class comes in handy here.
    $options = Data($options);
    
    //Make sure that a URL is provided when we need it.
    if($options->url->is_empty() && ($options->check('claim') || !$options->check('silent'))){
      throw new \exception\Programmer('The url option is required when sending verification / claim e-mails.');
    }
    
    //Use claiming process?
    if($options->check('claim')){
      $data->password->un_set();
    }
    
    //Lets use a model.
    #TODO: Use core models.
    $user = new \components\account\models\Accounts();
    $user->merge($data);
    
    //Validate given fields.
    $user->validate_model(array(
      
      'force_create' => true,
      'nullify' => true,
      
      'rules' => array(
        'password' => $options->check('claim') ? array() : array('required', 'password', 'not_empty'),
        'level' => array('required', 'number'=>'int', 'in'=>array(1, 2)),
        'first_name' => array('string', 'between'=>array(0, 255), 'no_html'),
        'last_name' => array('string', 'between'=>array(0, 255), 'no_html'),
        'is_active' => array('boolean'),
        'is_banned' => array('boolean')
        //is_claimable will be determined by the given options.
      )
      
    ));
    
    #TODO: Delegate this to the core model.
    //Check for duplicate email.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE email = ?'
      , $user->email
    ))->gt(0, function(){
      $vex = new \exception\Validation('A user with this e-mail address already exists.');
      $vex->key('email');
      $vex->errors(array('A user with this e-mail address already exists.'));
      throw $vex;
    });
    
    #TODO: Delegate this to the core model.
    //Check for duplicate username.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE username = ?'
      , $user->username
    ))->gt(0, function(){
      $vex = new \exception\Validation('A user with this username already exists.');
      $vex->key('username');
      $vex->errors(array('A user with this username already exists.'));
      throw $vex;
    });
    
    //Hash the password.
    $user->merge(AuthenticationTasks::hashPassword($user->password));
    
    //In case we have extended models, add the defaults to it.
    if(ManagementTasks::isExtendedCoreUsersSupported())
    {
      
      //Claiming should deactivate the account until claimed.
      //When silent, no claim link will be available, so it's a deactivated account.
      if($options->check('claim')){
        $user->merge(array(
          'is_claimable' => !$options->check('silent'),
          'is_active' => false
        ));
      }
      
      //Otherwise, apply some defaults.
      else{
        $user->merge(array(
          'is_claimable' => false, //Don't use claiming here.
          'is_active' => $user->is_active->otherwise(true),
          'is_banned' => $user->is_banned->otherwise(false)
        ));
      }
      
      //We're done it seems.
      $user->save();
      
    }
    
    //Set these values the old fashioned way.
    else{
      
      //We need an ID, so save first.
      $user->save();
      
      #TODO: Deprecate this.
      if(mk('Component')->available('account'))
      {
        
        mk('Sql')
          ->model('account', 'UserInfo')
          ->set(array(
            'user_id' => $user->id
          ))
          ->set_status('activated')
          ->save();
        
      }
      
    }
    
    //Only when we want to be sending messages.
    if(!$options->check('silent'))
    {
      
      //Notify the user they can claim an account.
      if($options->check('claim')){
        
        //Create a verify token with a long lifetime.
        //The maximum lifetime is still considered proper validation, so use that for user friendliness.
        $lifetime = EmailTokenTasks::MAX_TOKEN_LIFETIME;
        $token = EmailTokenTasks::generate($user->id, 'account.claim', $lifetime);
        
        //Send the email now.
        ManagementTasks::emailUser(
          
          $user, 'account.claim',
          __('You can claim your account', true),
          
          array(
            'site_name' => mk('Config')->user('site_name')->otherwise(URL_BASE),
            'user' => $user,
            'claim_url' => (string)url(sprintf($options->url->get('string'), $user->id->get('int'), $token), true),
            'token_expires' => date('j F Y, H:i', time()+$lifetime)
          )
          
        );
        
      }
      
      //Send a normal create mail.
      else
      {
        
        //Create a verify token with a long lifetime.
        //We only need to know that the user can read the e-mail messages at all.
        $lifetime = EmailTokenTasks::MAX_TOKEN_LIFETIME;
        $token = EmailTokenTasks::generate($user->id, 'account.verify_email', $lifetime);
        
        //Send the email now.
        ManagementTasks::emailUser(
          
          $user, 'account.created',
          __('Your account has been created', true),
          
          array(
            'site_name' => mk('Config')->user('site_name')->otherwise(URL_BASE),
            'user' => $user,
            'verify_email_url' => (string)url('/?action=account/verify_email&uid='.$user->id.'&token='.$token, true),
            'token_expires' => date('j F Y, H:i', time()+$lifetime)
          )
          
        );
          
      }
      
    }
    
    
    return $user;
    
  }
  
  /**
   * Edits a user account.
   * 
   * @param  integer $userId The ID for the user to edit.
   * @param  Data $data The set of data to update.
   * @return BaseModel The user that has been edited.
   */
  public static function editUser($userId, Data $data)
  {
    
    #TODO: User core models.
    //Get the old user model from the database.
    $user = mk('Sql')->table('account', 'Accounts')
      ->pk($userId)
      ->execute_single()
      
      //Make sure we found it.
      ->is('empty', function()use($userId){
        throw new \exception\User('Could not update because no entry was found in the database with id %s.', $userId);
      });
    
    //Merge the fields from the given data.
    $user->merge($data->having('email', 'username', 'first_name', 'last_name', 'level', 'is_active', 'is_banned', 'is_claimable'));
    
    //Check if the password was given and filled in..
    if(!$data->password->is_empty()){
      $user->merge($data->having('password'));
    }
    
    //Validate given fields.
    $user->validate_model(array(
      
      'nullify' => true,
      
      'rules' => array(
        'password' => array('required', 'password'),
        'level' => array('required', 'number'=>'int', 'in'=>array(1, 2)),
        'first_name' => array('string', 'between'=>array(0, 255), 'no_html'),
        'last_name' => array('string', 'between'=>array(0, 255), 'no_html'),
        'is_active' => array('boolean'),
        'is_banned' => array('boolean'),
        'is_claimable' => array('boolean')
      )
      
    ));
    
    #TODO: Delegate this to the core model.
    //Check for duplicate email.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE email = ?'
      , $user->email
    ))->gt(1, function(){
      $vex = new \exception\Validation('A user with this e-mail address already exists.');
      $vex->key('email');
      $vex->errors(array('A user with this e-mail address already exists.'));
      throw $vex;
    });
    
    #TODO: Delegate this to the core model.
    //Check for duplicate username.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE username = ?'
      , $user->username
    ))->gt(1, function(){
      $vex = new \exception\Validation('A user with this username already exists.');
      $vex->key('username');
      $vex->errors(array('A user with this username already exists.'));
      throw $vex;
    });
    
    //Seems the given password was valid.
    if(!$data->password->is_empty()){
      $user->merge(AuthenticationTasks::hashPassword($data->password));
    }
    
    //If the user has no password at this point, is_active can not be set to true.
    if($user->check('is_active') && $user->password->is_empty()){
      $vex = new \exception\Validation('Account must have a password to be activated.');
      $vex->key('is_active');
      $vex->errors(array('Account must have a password to be activated.'));
      throw $vex;
    }
    
    //Save to database.
    $user->save();
    return $user;
    
  }
  
  /**
   * Deletes a user.
   * Permanently... so be careful alright?
   * @param  integer $userId The ID of the user to delete.
   * @return boolean Whether or not the user was deleted.
   */
  public static function deleteUser($userId)
  {
    
    #TODO: User core models.
    #TODO: User transaction.
    
    raw($userId);
    
    //This makes sure that you don't lock yourself out of the system.
    if(mk('Account')->id == $userId)
      throw new \exception\User('Cannot delete yourself while logged in');
    
    mk('Logging')->log('Account', 'Deleting user', 'ID: '.$userId. ' by user: '.mk('Account')->id);
    
    //Check the account exists.
    $exists = mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      .'SELECT count(*) FROM `#__core_users` '
      .'WHERE id=?'
      , $userId
    ));
    
    if($exists->get('int') <= 0){
      throw new \exception\NotFound('User with ID %u was not found', $userId);
    }
    
    //Find shared sessions.
    $sessions = mk('Sql')->execute_query(mk('Sql')->make_query(''
      .'SELECT * FROM `#__core_user_logins` '
      .'WHERE user_id=?'
      , $userId
    ));
    
    //Remove shared session data.
    foreach($sessions as $session){
      mk('Sql')->execute_non_query(mk('Sql')->make_query(''
        .'DELETE FROM `#__core_user_login_shared_sessions` '
        .'WHERE login_id=?'
        , $session->id
      ));
    }
    
    //Remove the sessions.
    mk('Sql')->execute_non_query(mk('Sql')->make_query(''
      .'DELETE FROM `#__core_user_logins` '
      .'WHERE user_id=?'
      , $userId
    ));
    
    //Remove email tokens.
    mk('Sql')->execute_non_query(mk('Sql')->make_query(''
      .'DELETE FROM `#__core_user_email_tokens` '
      .'WHERE id=?'
      , $userId
    ));
    
    //Last but not least, remove user.
    mk('Sql')->execute_non_query(mk('Sql')->make_query(''
      .'DELETE FROM `#__core_users` '
      .'WHERE id=?'
      , $userId
    ));
    
    #TODO: Deprecate this.
    //Some components may break if we don't do this.
    if(mk('Component')->available('account')){
      mk('Sql')->table('account', 'UserInfo')
        ->pk($userId)
        ->execute_single()
        ->delete();
    }
    
    mk('Logging')->log('Account', 'Deleted user', 'SUCCESS');
    
    return true;
    
  }
  
  /**
   * Initiate the password reset process for the given user.
   * 
   * Note: if the given email address does not match a user, a message is sent to notify the user of this.
   * 
   * @param  integer $email The email for the user to reset the password of.
   * @param  string $url The sprintf formatted url that will handle email verification / claiming links.
   * @return void
   */
  public static function passwordReset($email, $url)
  {
    
    #TODO: Use core models.
    $user = mk('Sql')->execute_single(mk('Sql')->make_query(''
      . 'SELECT * FROM #__core_users '
      . 'WHERE email = ?'
      , $email
    ));
    
    //If the email doesn't match, send a notification to the user about it.
    if($user->is_empty())
    {
      
      $user = Data(array('email'=>$email));
      
      //Send the email now.
      ManagementTasks::emailUser(
        
        $user, 'account.password_reset.wrong_email',
        __('Password reset attempt', true),
        
        array(
          'site_name' => mk('Config')->user('site_name')->otherwise(URL_BASE),
          'user' => $user
        )
        
      );
      
      return;
      
    }
    
    //Create a token with a short lifetime.
    //This is because a password reset is usually completed right away.
    $lifetime = EmailTokenTasks::MIN_TOKEN_LIFETIME;
    $token = EmailTokenTasks::generate($user->id, 'account.password_reset', $lifetime);
    
    //Send the email now.
    ManagementTasks::emailUser(
      
      $user, 'account.password_reset',
      __('Reset your password', true),
      
      array(
        'site_name' => mk('Config')->user('site_name')->otherwise(URL_BASE),
        'user' => $user,
        'claim_url' => (string)url(sprintf((string)$url, $user->id->get('int'), $token), true),
        'token_expires' => date('H:i', time()+$lifetime)
      )
      
    );
    
  }
  
  /**
   * Sends an email message to the user.
   * @param  Data   $user    The user model.
   * @param  string $key     The key for the message. Note: use built-in messages only.
   * @param  string $subject The e-mail message subject.
   * @param  array  $data    Input data for the template.
   * @return void
   */
  public static function emailUser(Data $user, $key, $subject, $data)
  {
    
    //Gather message info.
    $file = PATH_SYSTEM_ASSETS.DS.'email_templates'.DS.$key.'.md.tpl';
    $meta = array(
      'to' => array('name'=>$user->full_name->get(), 'email'=>$user->email->get()),
      'subject' => $subject
    );
    
    //Send message.
    EmailTasks::SendFormattedMessage(
      $key, $meta, $data, EmailTasks::MarkdownTemplateGetter($file)
    );
    
  }
  
}