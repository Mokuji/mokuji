<?php namespace core; if(!defined('MK')) die('No direct access.');

use \dependencies\account\AuthenticationTasks;
use \dependencies\account\CookieTasks;

/**
 * Handles the basic account operations and manages the users session.
 */
class Account
{
  
  /**
   * The basic user information for the current session.
   */
  public $user;

  /**
   * Initializes the class.
   *
   * Checks if the user is logged in.
   * Updates session expiry.
   * Logs out the user if session expired.
   * @return void
   */
  public function init()
  {
    
    //append user object for easy access
    $this->user =& tx('Data')->session->user;
    
    //Allow the cookie system to clean up.
    CookieTasks::cleanSessionRebase();
    
    //User is not logged in? Proceed to try log them in using an authentication cookie.
    if(!$this->user->check('login')){
      CookieTasks::tryLogin();
      return;
    }
    
    //Double check the session.
    $session = AuthenticationTasks::verifySession($this->user)
    if($session === false){
      $this->logout();
      return;
    }
    
    #TODO: Make this prettier.
    //This means we're logged in.
    //Check for https in the on-login mode.
    if(mk('Config')->user('tls_mode')->get() === 'logged-in' && mk('Url')->url->segments->scheme->get() !== 'https')
      mk('Url')->redirect(url('')->segments->merge(array('scheme' => 'https'))->back()->rebuild_output());
    
    //Look for session sharing signs.
    AuthenticationTasks::verifySharedSession($user, $session);
    
    #TODO: Check if this can be deprecated.
    //Progress user activity.
    mk('Data')->server->REQUEST_TIME->copyto($this->user->activity);
    
  }
  
  /**
   * Returns true if the user is logged in. Short for $this->user->check('login').
   * @return boolean
   */
  public function is_login()
  {
    
    return $this->user->check('login');
    
  }
  
  /**
   * Performs a login attempt for the current session.
   * @param String $email The email or user-name of the user to log in with.
   * @param String $pass The plain text password to log in with.
   * @return self Returns $this for chaining.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @throws \exception\EmptyResult If the user account is not found.
   * @throws \exception\Validation If the password is invalid.
   */
  public function login($email, $pass, $expiry_date = null, $persistent = false)
  {
    
    //If we're already logged in: Do nothing. :)
    if($this->user->check('login')){
      return $this;
    }
    
    //Extract raw data.
    raw($email, $pass, $expiry_date);
    
    tx('Logging')->log('Core', 'Login attempt', 'Starting for email/username "'.$email.'"');
    
    //Check if login is allowed, based on the IP permissions.
    $ipinfo = $this->_check_ip_permissions();
    
    //Let's be optimistic.
    $failed = false;
    
    //Get the user record based on the given email address or user name.
    $user = tx('Sql')->execute_single(''
      . "SELECT * FROM #__core_users WHERE email = ".tx('Sql')->escape($email)
      . " "
      . "OR username = ".tx('Sql')->escape($email)
    )
    
    //If the user record wasn't found, fail the login attempt.
    ->is('empty', function(){
      tx('Logging')->log('Core', 'Login attempt', 'FAILED: User account not found.');
      $failed = true;
    });
    
    //If we haven't failed yet, we will compare passwords.
    if(!$failed)
    {
      
      //See if we're using improved hashing.
      $user->hashing_algorithm->not('empty')
        
      //Use improved hashing.
      ->success(function()use($user, $pass, &$failed){
        
        //Apply salt, if any.
        $spass = $user->salt->otherwise('')->get('string') . $pass;
        
        //Apply hashing algorithm.
        $hspass = tx('Security')->hash($spass, $user->hashing_algorithm);

        //Compare hashes.
        if($user->password->get() !== $hspass){
          tx('Logging')->log('Core', 'Login attempt', 'FAILED: Invalid password.');
          $failed = true;
        }
        
      })
      
      //Use the old hashing method.
      ->failure(function()use($user, $pass, &$failed){
        
        if(md5($pass) !== $user->password->get()){
          tx('Logging')->log('Core', 'Login attempt', 'FAILED: Invalid password.');
          $failed = true;
        }
        
      });
      
    }
    
    //Check if we failed at any of the above.
    if($failed){
      throw new \exception\Validation('Invalid user name and password combination.');
    }
    
    //Log a successful login attempt.
    tx('Logging')->log('Core', 'Login attempt', 'SUCCESS: Logged in as user ID '.$user->id);
    
    //Log the user in.
    $user->level->set(min($user->level->get(), $ipinfo->login_level->get()));
    AuthenticationTasks::setLoggedIn($user, $expiry_date, $persistent);
    
  }

  /**
   * Logins a login attempt for the current session.
   * @param Integer $user_id The user ID of the user to log in with.
   * @return self Returns $this for chaining.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @throws \exception\EmptyResult If the user account is not found.
   */
  public function become_user($user_id, $persistent = false)
  {

    //Extract raw data.
    raw($user_id, $pass);
    
    tx('Logging')->log('Core', 'Become user attempt', 'Starting for user ID "'.$user_id.'"');
    
    //Check if login is allowed, based on the IP permissions.
    $ipinfo = $this->_check_ip_permissions();
    
    //Get the user record based on the given email address or user name.
    $user = tx('Sql')->execute_single("SELECT * FROM #__core_users WHERE id = ".tx('Sql')->escape($user_id))
    
    //If the user record wasn't found, fail the login attempt.
    ->is('empty', function(){
      tx('Logging')->log('Core', 'Become user attempt', 'FAILED: User account not found.');
    });
    
    //Log a successful login attempt.
    tx('Logging')->log('Core', 'Become user attempt', 'SUCCESS: Logged in as user ID '.$user->id);
    
    //Log the user in.
    $user->level->set(min($user->level->get(), $ipinfo->login_level->get()));
    AuthenticationTasks::setLoggedIn($user, null, $persistent);
    
  }

  /**
   * Logs out the current user.
   * @return self Returns $this for chaining.
   */
  public function logout()
  {
    
    //Get the SQL singleton.
    $sql = tx('Sql');
    
    //Really logged in? Log out from the database.
    if($this->user->check('login'))
    {
      
      mk('Logging')->log('Core', 'Account', 'Logging out');
      
      //Log out the old way.
      if($sql->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty()){
        $sql->execute_non_query("UPDATE `#__core_users` SET session = NULL, ipa = NULL WHERE id = '{$this->user->id}'");
      }
      
      //Log out the new way.
      else
      {
        
        $sql->execute_non_query("
          UPDATE `#__core_user_logins`
            SET
              dt_expiry = '".date('Y-m-d H:i:s')."'
            WHERE 1
              AND user_id = '{$this->user->id}'
              AND session_id = ".$sql->escape(tx('Session')->id)."
        ");
        
      }
      
      //Do all the things that need to be done with cookies for logging out.
      CookieTasks::onLogout();
      
      //Regenerate the session ID.
      tx('Session')->regenerate();
      
    }
    
    //Unset meta-data.
    $this->user->un_set('id', 'email', 'activity', 'username');
    $this->user->login = false;
    $this->user->level = 0;
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Registers a new user account.
   * @param String $email The email address to set.
   * @param String $username The optional username to set.
   * @param String $password The password to set.
   * @param int $level The user level to set. (1 = Normal user, 2 = Administrator)
   * @return boolean Whether registering the user was successful.
   */
  public function register($email, $username = NULL, $password, $level=1)
  {
    
    //Prepare variables.
    $data = Data();
    raw($email, $username, $level);
    
    //Defaults to the default hashing algorithm and salt settings defined by core-security.
    $password->is('set')->and_not('empty')->success(function()use(&$data, &$password){
      
      //Get salt and algorithm.
      $data->salt = tx('Security')->random_string();
      $data->hashing_algorithm = tx('Security')->pref_hash_algo();
      
      //Hash using above information.
      $password = tx('Security')->hash(
        $data->salt->get() . $password->get(),
        $data->hashing_algorithm
      );
    
    })->failure(function()use(&$data, &$password){
      $password->un_set();
    });
    
    mk('Logging')->log('Core', 'Account', 'Registered user '.$email);
    
    tx('Session')->regenerate();
    $sid = tx('Session')->id;
    $ipa = tx('Data')->server->REMOTE_ADDR->get();
    
    tx('Sql')->execute_non_query(
      "INSERT INTO `#__core_users`
        (id,   dt_created, email,    username,    password,    level,    hashing_algorithm,            salt) VALUES
        (NULL, NOW(), ".tx('Sql')->escape($email).", ".tx('Sql')->escape($username).", ".
        tx('Sql')->escape($password).", ".tx('Sql')->escape($level).", '{$data->hashing_algorithm}', '{$data->salt}')"
    );
    
    if(tx('Component')->available('account'))
    {
      
      tx('Sql')->execute_non_query(
        "INSERT INTO #__account_user_info (user_id, status) VALUES (".abs(mk('Sql')->get_insert_id()).", 1)"
      );
      
    }
    
    return true;
    
  }
  
  /**
   * Checks whether the currently logged in user has a certain user level.
   *
   * When not checking the exact level,
   * it checks whether the user level is greater than or equal to the provided level.
   *
   * @param int $level The level the user should be checked against.
   * @param boolean $exact Whether the `$level` parameter should be exactly matched.
   * @return boolean Whether or not the user meets the level requirements.
   */
  public function check_level($level, $exact=false)
  {
    
    return ($exact===true ? $this->user->level->get('int') == $level : $this->user->level->get('int') >= $level);
    
  }
  
  /**
   * Checks whether the currently logged in user has permission to view this page.
   * Similar to check_level except it redirects the user if the user is not authorized.
   * @param int $level The level the user should be checked against.
   * @param boolean $exact Whether the `$level` parameter should be exactly matched.
   * @return void
   * @throws \exception\User If the redirect target requires the user to be logged in as well.
   */
  public function page_authorisation($level, $exact=false)
  {

    if($this->check_level($level, $exact)){
      return;
    }

    if(tx('Config')->user('login_page')->is_set()){
      $redirect = url(URL_BASE.'?'.tx('Config')->user('login_page'), true);
    }

    else{
      $redirect = url(URL_BASE.'?'.tx('Config')->user('homepage'), true);
    }

    if($redirect->compare(tx('Url')->url)){
      throw new \exception\User('The login page requires you to be logged in. Please contact the system administrator.');
    }

    tx('Url')->redirect($redirect);

  }

  /**
   * Check if a user is allowed to login based on IP.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @return Object $ipinfo.
   */
  private function _check_ip_permissions()
  {

    //Get the client IP address.
    $ipa = tx('Data')->server->REMOTE_ADDR->get();
    
    //Get IP permissions.
    $ipinfo = tx('Sql')->execute_single(
      "SELECT * FROM #__core_ip_addresses WHERE address = ".tx('Sql')->escape($ipa)
    )
      
    //If no specific entry is available, get the global settings.
    ->is('empty', function(){
      return tx('Sql')->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '*'");
    });
    
    //Check if login is allowed. Throw an exception if it's not.
    $ipinfo->login_level->eq(0, function()use($ipa){
      tx('Logging')->log('Core', 'Login attempt', 'FAILED: IP address '.$ipa.' is blacklisted.');
      throw new \exception\Validation('IP address blacklisted.');
    });

    return $ipinfo;

  }
  
}
