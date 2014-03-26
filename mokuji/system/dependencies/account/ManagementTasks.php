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
    * Edit user
    * Delete user
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
   * Creates a new user account.
   * 
   * Note: Attempts at registering should ALWAYS be protected at the form handling level.
   * Otherwise attackers will be able to discover existing e-mail addresses and usernames.
   * As well as create unlimited accounts for spamming or even DOS attacks by taking up the
   * entire username and e-mail space.
   * 
   * @param  Data $data The set of data to insert.
   * @param  boolean $silent When true, no e-mail notifications will be sent.
   * @return BaseModel The user that has been created.
   */
  public static function createUser(Data $data, $silent=false)
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
      $vex = new \exception\Validation('A user with this e-mail address already exists.');
      $vex->key('email');
      $vex->errors(array('A user with this e-mail address already exists.'));
      throw $vex;
    });
    
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
    
    //Notify the user.
    if(!$silent)
    {
      
      ManagementTasks::emailUser(
        
        $user, 'account.created',
        __('Account created', true),
        
        array(
          'site_name' => mk('Config')->user('site_name')->otherwise('My Mokuji Website'),
          'user' => $user,
          'verify_email_url' => (string)url('hi=true', true)
        )
        
      );
    }
    
    return $user;
    
  }
  
  /**
   * Edits a user account.
   * 
   * @param  integer $userId The ID for the user to edit.
   * @param  Data $data The set of data to insert.
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
    $user->merge($data->having('email', 'username', 'first_name', 'last_name', 'level', 'is_active', 'is_banned'));
    
    //Handle one alias for the level value.
    if($data->is_admin->is_set()){
      $user->merge(array('level', $data->check('is_admin') ? 2 : 1));
    }
    
    //Check if the password was given and filled in..
    if(!$data->password->is_empty()){
      $user->merge(AuthenticationTasks::hashPassword($data->password));
    }
    
    //Save to database.
    $user->save();
    return $user;
    
  }
  
  /**
   * Sends an email message to the user.
   * @param  Data   $user    The user model.
   * @param  string $key     The key for the message. Note: use built-in messages only.
   * @param  string $subject The e-mail message subject.
   * @param  array  $data    Input data for the template.
   * @return void
   */
  public static function emailUser($user, $key, $subject, $data)
  {
    
    //Gather message info.
    $file = PATH_SYSTEM_ASSETS.DS.'email_templates'.DS.$key.'.md.tpl';
    $meta = array(
      'to' => array('name'=>$user->full_name->get(), 'email'=>$user->email->get()),
      'subject' => $subject,
      'debug' => true
    );
    
    //Send message.
    EmailTasks::SendFormattedMessage(
      $key, $meta, $data, EmailTasks::MarkdownTemplateGetter($file)
    );
    
  }
  
}