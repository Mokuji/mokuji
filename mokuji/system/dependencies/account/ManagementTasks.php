<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

use \dependencies\BaseModel;
use \dependencies\Data;

/**
 * Provides static methods to perform account management tasks.
 */
abstract class ManagementTasks
{
  
  /*
    #TODO
    * Create user
    * Edit user
    * Delete user
    * Register user
    * Password forgotten
    * Claiming??
    * Banning??
    * Email verification??
  */
  
  private static $REGISTER_DEFAULTS = array(
    'is_active' => true,
    'is_banned' => false,
    'is_claimable' => false
  );
  
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
   * Registers a new user account.
   * 
   * Note: Attempts at registering should ALWAYS be protected at the form handling level.
   * Otherwise attackers will be able to discover existing e-mail addresses and usernames.
   * As well as create unlimited accounts for spamming or even DOS attacks by taking up the
   * entire username and e-mail space.
   * 
   * @param  Data $data The set of data to insert.
   * @return BaseModel The user that has been created.
   */
  public static function registerUser(Data $data)
  {
    
    //Lets use a model.
    #TODO: Use core models.
    $user = new \components\account\models\Accounts();
    $user->merge($data);
    
    //Validate given fields.
    $user->validate_model(array(
      
      'force_create' => true,
      'nullify' => true,
      
      'rules' => array(
        'password' => array('required', 'password'),
        'level' => array('required', 'number'=>'int', 'in'=>array(1, 2)),
        'first_name' => array('string', 'between'=>array(0, 255), 'no_html'),
        'last_name' => array('string', 'between'=>array(0, 255), 'no_html')
      )
      
    ));
    
    //Check for duplicate email.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE email = ?'
      , $user->email
    ))->gt(0, function(){
      throw new \exception\Validation('A user with this e-mail address already exists.');
    });
    
    //Check for duplicate username.
    mk('Sql')->execute_scalar(mk('Sql')->make_query(''
      . 'SELECT COUNT(*) FROM #__core_users '
      . 'WHERE username = ?'
      , $user->username
    ))->gt(0, function(){
      throw new \exception\Validation('A user with this username already exists.');
    });
    
    //Hash the password.
    $user->merge(AuthenticationTasks::hashPassword($user->password));
    
    //In case we have extended models, add the defaults to it.
    if(ManagementTasks::isExtendedCoreUsersSupported())
    {
      
      //Set the default account flags.
      $user->merge(self::$REGISTER_DEFAULTS);
      
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
    
    return $user;
    
  }
  
}