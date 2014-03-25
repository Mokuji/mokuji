<?php namespace core; if(!defined('MK')) die('No direct access.');

use \dependencies\account\AuthenticationTasks;
use \dependencies\account\ManagementTasks;
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
    $session = AuthenticationTasks::verifySession($this->user);
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
    AuthenticationTasks::verifySharedSession($this->user, $session);
    
    #TODO: Check if this can be deprecated.
    //Progress user activity.
    mk('Data')->server->REQUEST_TIME->copyto($this->user->activity);
    
  }
  
  /**
   * Returns true if the user is logged in. Short for $this->user->check('login').
   * @return boolean
   */
  public function is_login(){
    return $this->user->check('login');
  }
  
  /**
   * Performs a login attempt for the current session.
   * @param string $identifier The email or username of the user to log in with.
   * @param string $password The plain text password to log in with.
   * @param string $expiry_date The absolute expiry date of the session, should the attempt succeed (optional).
   * @param boolean $persistent Whether "remember-me" functionality is desired (optional).
   * @return self Returns $this for chaining.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @throws \exception\EmptyResult If the user account is not found.
   * @throws \exception\Validation If the password is invalid.
   */
  public function login($identifier, $password, $expiry_date = null, $persistent = false)
  {
    
    raw($identifier, $password, $expiry_date, $persistent);
    
    //Let the task handle this.
    AuthenticationTasks::login($identifier, $password, $expiry_date, $persistent);
    
    //Add some chaining.
    return $this;
    
  }
  
  /**
   * Assume the identity of another user.
   * @param integer $user_id The user ID of the user to log in with.
   * @param boolean $persistent DEPRECATED: become_user is never persistent.
   * @return self Returns $this for chaining.
   * @throws \exception\Validation If the IP address of the remote connection is blacklisted.
   * @throws \exception\EmptyResult If the user account is not found.
   */
  public function become_user($user_id, $persistent = null)
  {
    
    #TODO: Remove this after a while.
    if(!is_null($persistent)){
      throw new \exception\Deprecated('The $persistent flag is no longer supported.');
    }
    
    //Go for it.
    raw($user_id);
    AuthenticationTasks::becomeUser($user_id);
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Logs out the current user.
   * @return self Returns $this for chaining.
   */
  public function logout()
  {
    
    //Let the task handle this.
    AuthenticationTasks::logout();
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Registers a new user account.
   * @param string $email The email address to set.
   * @param string $username The optional username to set.
   * @param string $password The password to set.
   * @param int $level The user level to set. (1 = Normal user, 2 = Administrator)
   * @return boolean Whether registering the user was successful.
   */
  public function register($email, $username = NULL, $password, $level=1)
  {
    
    //Let the management tasks handle this.
    $user = ManagementTasks::registerUser(Data(array(
      'email' => $email,
      'username' => $username,
      'password' => $password,
      'level' => $level
    )));
    
    mk('Logging')->log('Core', 'Account', 'Registered user '.$email);
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
    
    return $exact===true ?
      $this->user->level->get('int') == $level:
      $this->user->level->get('int') >= $level;
    
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
  
}
