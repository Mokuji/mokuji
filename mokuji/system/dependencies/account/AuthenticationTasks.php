<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

use \dependencies\BaseModel;
use \dependencies\Data;

/**
 * Provides static methods to perform authentication logic.
 */
abstract class AuthenticationTasks
{
  
  /*
    #TODO
    * Claiming??
    * Email verification??
  */
  
  /**
   * Check for support of the core user logins database tables.
   * @return boolean
   */
  public static function isLoginStructureSupported()
  {
    
    return !mk('Sql')
      ->execute_single("SHOW TABLES LIKE '#__core_user_logins'")
      ->is_empty();
    
  }
  
  /**
   * Performs a login attempt.
   * 
   * Note: when already logged in, a successful attempt will log you out of the previous session.
   * Failed attempts will throw an exception, but you will still be logged with the previous session.
   * 
   * @param string $identifier The email or username of the user to log in with.
   * @param string $password The plain text password to log in with.
   * @param string $expiry_date The absolute expiry date of the session, should the attempt succeed (optional).
   * @param boolean $persistent Whether "remember-me" functionality is desired (optional).
   * @return boolean Whether these credentials were successfully used to log in.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @throws \exception\Validation If the email/username + password combination is invalid.
   */
  public static function login($identifier, $password, $expiry_date = null, $persistent = false)
  {
    
    mk('Logging')->log('Core', 'Login attempt', 'Starting for email/username "'.$identifier.'"');
    
    //Check if login is allowed, based on the IP permissions.
    $ipinfo = AuthenticationTasks::checkIpPermissions();
    
    //Get the user record based on the given email address or user name.
    $user = AuthenticationTasks::findUser($identifier);
    
    //Perform validation.
    $valid =
      $user->is_empty() === false &&                       //Username / email is correct.
      AuthenticationTasks::checkPassword($user, $password) //Password is correct.
    ;
    
    //If the user doesn't exist or the password is invalid.
    if(!$valid){
      mk('Logging')->log('Core', 'Login attempt', 'Login failed, invalid username and password combination.');
      throw new \exception\Validation('Invalid username and password combination');
    }
    
    //Banned?
    if($user->check('is_banned')){
      mk('Logging')->log('Core', 'Login attempt', 'Login failed, banned user.');
      throw new \exception\Validation('Your account has been banned.');
    }
    
    //Active?
    if(!$user->check('is_active')){
      mk('Logging')->log('Core', 'Login attempt', 'Login failed, deactivated user.');
      throw new \exception\Validation('Your account is currently deactivated.');
    }
    
    //Limit the login level to the IP restrictions, if any.
    $user->level->set(min($user->level->get('int'), $ipinfo->login_level->get('int')));
    
    //Set the login information.
    AuthenticationTasks::setLoggedIn($user, $expiry_date, $persistent);
    
    //Log a successful login attempt.
    mk('Logging')->log('Core', 'Login attempt', 'SUCCESS: Logged in as user ID '.mk('Account')->id);
    
    # できた!
    return true;
    
  }
  
  /**
   * Logs out the current user.
   * Note: if the user was not logged in this returns false.
   * 
   * @return boolean Whether the user successfully logged out.
   */
  public static function logout()
  {
    
    //If we are not actually logged in, return false.
    if(!mk('Account')->isLoggedIn()){
      return false;
    }
    
    //Get the SQL singleton.
    $sql = mk('Sql');
    
    //Get the user ID.
    $userId = mk('Account')->id;
    
    //Start the log.
    mk('Logging')->log('Core', 'Account', 'Logging out');
    
    //Log out the new way.
    if(AuthenticationTasks::isLoginStructureSupported())
    {
      
      #TODO: Use core models.
      $sql->execute_non_query($sql->make_query(
        "UPDATE `#__core_user_logins`
          SET dt_expiry = ?
          WHERE 1
            AND user_id = ?
            AND session_id = ?"
        , date('Y-m-d H:i:s')
        , $userId
        , mk('Session')->id
      ));
      
    }
    
    //Log out the old way.
    else
    {
      
      #TODO: Use core models.
      $sql->execute_non_query("UPDATE `#__core_users` SET session = NULL, ipa = NULL WHERE id = '{$userId}'");
      
    }
    
    //Do all the things that need to be done with cookies for logging out.
    CookieTasks::onLogout();
    
    //Regenerate the session ID.
    mk('Session')->regenerate();
    
    //Unset meta-data.
    mk('Account')->setUserData(Data(array(
      'id' => null,
      'email' => null,
      'username' => null,
      'level' => 0
    )));
    
    # じゃ、またね。
    return true;
    
  }
  
  /**
   * Assume the identity of another user.
   * @param  integer $userId The ID of the user to become.
   * @return boolean Whether or not the operation succeeded.
   * @throws \exception\Validation If the user ID is invalid.
   * @throws \exception\Authorisation If you are not allowed to do this.
   */
  public static function becomeUser($userId)
  {
    
    #TODO: Make configurable global permission restriction on this.
    //Never allow guests to do this.
    if(!mk('Account')->isLoggedIn()){
      throw new \exception\Authorisation('You must be logged in to do this');
    }
    
    //When we're trying to become the same user, abort.
    if($userId === mk('Account')->id){
      mk('Logging')->log(
        'Core', 'Become user attempt',
        'FAILED: Tried to become the same user ID "'.$userId.'".'
      );
      return false;
    }
    
    mk('Logging')->log(
      'Core', 'Become user attempt',
      'Starting for user ID "'.$userId.'" by user ID "'.(mk('Account')->id ? mk('Account')->id : 'guest').'".'
    );
    
    //Check if login is allowed, based on the IP permissions.
    $ipinfo = AuthenticationTasks::checkIpPermissions();
    
    #TODO: Use core models.
    //Get the user record based on the given email address or user name.
    $user = mk('Sql')->execute_single("SELECT * FROM #__core_users WHERE id = ".mk('Sql')->escape($user_id))
    
    //If the user record wasn't found, fail the login attempt.
    ->is('empty', function()use($userId){
      mk('Logging')->log('Core', 'Become user attempt', 'FAILED: User account not found.');
      throw new \exception\Validation('Invalid user ID %u', $userId);
    });
    
    //Log a successful login attempt.
    mk('Logging')->log('Core', 'Become user attempt', 'SUCCESS: Logged in as user ID '.$user->id);
    
    //Limit the login level to the IP restrictions, if any.
    $user->level->set(min($user->level->get('int'), $ipinfo->login_level->get('int')));
    
    //Log the user in.
    AuthenticationTasks::setLoggedIn($user);
    
    //Transformation complete!
    return true;
    
  }
  
  /**
   * Looks for a user based on email or username identifier.
   * 
   * @param string $identifier The email or username of the user to log in with.
   * @return Data The user that was found.
   */
  public static function findUser($identifier)
  {
    
    #TODO: Use core models.
    $user = mk('Sql')->execute_single(mk('Sql')->make_query(''
      . 'SELECT * FROM #__core_users '
      . 'WHERE email = ? OR username = ?'
      , $identifier
      , $identifier
    ));
    
    return mk('Sql')->table('account', 'Accounts')
      ->pk($user->id)
      ->execute_single();
    
  }
  
  /**
   * Compare the provided password to the hashed values of the user model.
   * @param  Data $user  The user model to check the password against.
   * @param  string $password The plain text password entered by the user.
   * @return boolean Whether the password matches or not.
   */
  public static function checkPassword(Data $user, $password)
  {
    
    #TODO: Change Data to core model.
    
    //Only explicitly change to true when definitely valid.
    $valid = false;
    
    //See if we're using improved hashing.
    $user->hashing_algorithm->not('empty')
    
    //Use improved hashing.
    ->success(function()use($user, $password, &$valid){
      
      //Apply salt, if any.
      $spass = $user->salt->otherwise('')->get('string') . $password;
      
      //Apply hashing algorithm.
      $hspass = mk('Security')->hash($spass, $user->hashing_algorithm);
      
      //Compare hashes.
      if($user->password->get() === $hspass){
        $valid = true;
      }
      
    })
    
    //Use the old hashing method.
    ->failure(function()use($user, $password, &$valid){
      
      if(md5($password) === $user->password->get()){
        $valid = true;
      }
      
    });
    
    return $valid;
    
  }
  
  /**
   * Hashes the given password into a format that meets our security settings.
   * 
   * Most likely the return data will include a hashed password, a salt and hashing algorithm information.
   * 
   * @param  string $password A plain text password to hash.
   * @return Data A bundle of data that can be merged into a (core) user model.
   */
  public static function hashPassword($password)
  {
    
    raw($password);
    
    //Start with a salt and algorithm.
    $data = Data(array(
      'dt_password_changed' => date('Y-m-d H:i:s'),
      'salt' => mk('Security')->random_string(),
      'hashing_algorithm' => mk('Security')->pref_hash_algo()
    ));
    
    //Hash using above information.
    $data->merge(array(
      
      'password' => mk('Security')->hash(
        $data->salt->get() . $password,
        $data->hashing_algorithm
      )
      
    ));
    
    return $data;
    
  }
  
  /**
   * Check if a user is allowed to login based on IP.
   * @param string? $address The IP address to check (optional).
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @return \dependencies\BaseModel The IP address entry.
   */
  public static function checkIpPermissions($address = null)
  {
    
    //Default is the remote address.
    if(is_null($address)){
      
      //Get the client IP address.
      $address = mk('Data')->server->REMOTE_ADDR->get();
      
    }
    
    //Get IP permissions.
    $ipinfo = mk('Sql')->execute_single(
      "SELECT * FROM #__core_ip_addresses WHERE address = ".mk('Sql')->escape($address)
    )
    
    //If no specific entry is available, get the global settings.
    ->is('empty', function(){
      return mk('Sql')->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '*'");
    });
    
    //Check if login is allowed. Throw an exception if it's not.
    $ipinfo->login_level->eq(0, function()use($address){
      mk('Logging')->log('Core', 'Login attempt', 'FAILED: IP address '.$address.' is blacklisted.');
      throw new \exception\Validation('IP address blacklisted');
    });
    
    return $ipinfo;
    
  }
  
  /**
   * Double checks that the session values match up with the database values.
   * @param  Object $user The user to verify the active session for.
   * @return boolean Whether the session is valid.
   */
  public static function verifySession(&$user)
  {
    
    #TODO: remove this support.
    //Backward compatibility with old login method.
    if(!AuthenticationTasks::isLoginStructureSupported())
    {
      
      #TODO: Use core models.
      //Get the current user session from the database.
      $session = mk('Sql')->execute_scalar(
        "SELECT id FROM `#__core_users` WHERE id = {$user->id} AND session = ".mk('Sql')->escape(mk('Session')->id)
      );
      
      //No exist? Shoo!
      if($session->is_empty())
        return false;
      
      //Cut if off here, because the other stuff is for the people who update their databases.
      return $session;
      
    }
    
    //Get active login sessions from the database.
    $session = AuthenticationTasks::getActiveSession($user);
    
    //No login data found? Away with you!
    if($session->is_empty())
    {
      
      mk('Logging')->log('Core', 'Account check', 'Logged out, because there is no login session.');
      
      $lastlogin = mk('Sql')->execute_single(mk('Sql')->make_query(''
        . 'SELECT * FROM #__core_user_logins '
        . 'WHERE user_id = ? '
        . 'ORDER BY date DESC'
        , $user->id
      ));
      
      mk('Logging')->log('Core', 'Account check', 'Last login dump: '.$lastlogin->dump());
      
      return false;
      
    }
    
    return $session;
    
  }
  
  /**
   * Verifies the exact session has already been found before.
   * @param  Object $user The user to verify the active session for.
   * @param  \dependencies\BaseModel $session The session that was found to be active.
   * @return void
   */
  public static function verifySharedSession($user, $session)
  {
    
    //Check if we're interested in shared sessions.
    if(!mk('Config')->user()->check('log_shared_login_sessions')){
      return;
    }
    
    #TODO: Use core models.
    //Get the exact session.
    $exactSession = mk('Sql')->execute_scalar("
      SELECT id FROM `#__core_user_logins`
      WHERE 1
        AND user_id = {$user->id}
        AND session_id = ".mk('Sql')->escape(mk('Session')->id)."
        AND IPv4 = '".mk('Data')->server->REMOTE_ADDR."'
        AND user_agent = ".mk('Sql')->escape(mk('Data')->server->HTTP_USER_AGENT)."
    ");
    
    //Didn't find a session with this environment yet?
    if($exactSession->is_empty())
    {
      
      #TODO: Use core models.
      //Log it.
      mk('Sql')->query("
        INSERT INTO `#__core_user_login_shared_sessions` VALUES(
          NULL,
          '{$session->id}',
          '".mk('Data')->server->REMOTE_ADDR."',
          ".mk('Sql')->escape(mk('Data')->server->HTTP_USER_AGENT).",
          NULL
        )
      ");
      
    }
    
  }
  
  /**
   * Gets the active session for this user. (Could be empty)
   * @param  Object $user The user to find the active session for.
   * @return \dependencies\BaseModel
   */
  public static function getActiveSession($user)
  {
    
    #TODO: Use core models.
    return mk('Sql')->execute_single("
      SELECT * FROM `#__core_user_logins`
      WHERE 1
        AND user_id = '{$user->id}'
        AND (dt_expiry IS NULL OR dt_expiry > '".date('Y-m-d H:i:s')."')
        AND session_id = ".mk('Sql')->escape(mk('Session')->id)."
    ");
    
  }
  
  /**
   * Manipulates the current session to log in the provided user.
   * @param \dependencies\Data $user A row from the users table.
   * @param string? $expiry_date  NULL or a date-time string, when the session should expire.
   * @param boolean $persistent   Whether "remember-me" functionality is desired.
   * @param string? $series_token NULL or the login cookie series token to continue.
   * @return void
   */
  public static function setLoggedIn($user, $expiry_date = null, $persistent = false, $series_token = null)
  {
    
    //If we were logged in, perform a logout first.
    if(mk('Account')->isLoggedIn()){
      mk('Logging')->log('Core', 'Account login', 'Already logged in, logging out first.');
      AuthenticationTasks::logout();
    }
    
    //Shortcut.
    $sql = mk('Sql');
    
    //Track if session regenerate is needed.
    $regenerate = true;
    
    //Do we want the "remember-me" functionality?
    if($persistent){
      CookieTasks::deployLoginCookie($user->id->get(), $series_token, $regenerate);
    }
    
    //Regenerate the session ID if it's still needed.
    if($regenerate)
      mk('Session')->regenerate();
    
    #TODO: Remove this support.
    //Backward compatibility with old database structure.
    if($sql->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty())
    {
      
      #TODO: Use core models.
      //Update the login session.
      $sql->execute_non_query("
        UPDATE `#__core_users` SET
          session = ".$sql->escape(mk('Session')->id).",
          ipa = ".$sql->escape(mk('Data')->server->REMOTE_ADDR).",
          dt_last_login = '".date('Y-m-d H:i:s')."'
        WHERE id = '{$user->id}'
      ");
      
    }
    
    //This stuff is only for the people who update their database structures.
    else
    {
      
      //Compute the expiry date.
      $dt_expiry = is_null($expiry_date) ? 'NULL' : "'".strtotime($expiry_date)."'";
      
      #TODO: Use core models.
      //Insert this login session in the database.
      $sql->execute_non_query("
        INSERT INTO `#__core_user_logins` VALUES(
          NULL,
          '{$user->id}',
          ".$sql->escape(mk('Session')->id).",
          {$dt_expiry},
          ".$sql->escape(mk('Data')->server->REMOTE_ADDR).",
          ".$sql->escape(mk('Data')->server->HTTP_USER_AGENT).",
          DEFAULT
        )
      ");
      
      mk('Logging')->log('Core', 'Login attempt', 'Setting expiry date to '.$dt_expiry.' for session ID '.mk('Session')->id);
      
    }
    
    //Set meta-data on the account information.
    mk('Account')->setUserData($user);
    
  }
  
}