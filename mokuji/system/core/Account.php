<?php namespace core; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
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
  protected $_user;
  
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
    
    //Instead of a direct reference, now use a clone.
    //This prevents funny people from manipulating the session data.
    $this->_user = mk('Data')->session->user->having('id', 'email', 'username', 'level');
    
    //Allow the cookie system to clean up.
    CookieTasks::cleanSessionRebase();
    
    //User is not logged in? Proceed to try log them in using an authentication cookie.
    if(!$this->isLoggedIn()){
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
    
  }
  
  /**
   * Read-only access with short writing style.
   */
  public function __get($key)
  {
    
    //Special case, share a clone of the user object.
    if($key === 'user'){
      #TODO: Deprecate.
      $clone = $this->_user->having('id', 'email', 'username', 'level');
      $clone->merge(array('login' => $this->isLoggedIn()));
      return $clone;
    }
    
    //Limit what can be accessed.
    if(!in_array($key, array('id', 'email', 'username', 'level')))
      throw new \exception\Programmer('Account has no property %s', $key);
    
    //Give them what they wanted, as a raw value.
    return $this->_user->{$key}->get();
    
  }
  
  /**
   * Returns true if the user is logged in.
   * @return boolean
   */
  public function isLoggedIn(){
    return $this->level >= 1;
  }
  
  /**
   * Returns true if the user is logged in as an administrator.
   * @return boolean
   */
  public function isAdmin(){
    return $this->level == 2;
  }
  
  /**
   * Returns true if the user has exactly the provided level.
   * @param  integer $level The level to match.
   * @return boolean
   */
  public function isLevel($level){
    return $this->level === $level;
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
   * Sets the given user data.
   * Note: only supports id, email, username and level.
   * @param Data $userData The data to set on the user.
   */
  public function setUserData(Data $userData){
    mk('Logging')->log('Account', 'Setting user data', $userData->dump());
    $this->_user->merge($userData->having('id','email','username','level'));
    tx('Data')->session->user->become($this->_user);
  }
  
  /**
   * DEPRECATED: Use \dependencies\account\ManagementTasks::createUser(...).
   * @param string $email
   * @param string $username
   * @param string $password
   * @param int $level
   * @return boolean
   */
  public function register($email, $username = NULL, $password, $level=1)
  {
    
    //Let the management tasks handle this.
    $user = ManagementTasks::createUser(Data(array(
      'email' => $email,
      'username' => $username,
      'password' => $password,
      'level' => $level
    )));
    
    mk('Logging')->log('Core', 'Account', 'Registered user '.$email);
    return true;
    
  }
  
  /**
   * DEPRECATED: use isLoggedIn().
   * @return boolean
   */
  public function is_login(){
    return $this->isLoggedIn();
  }
  
  /**
   * DEPRECATED: use level, isLoggedIn(), isAdmin() or isLevel($level).
   * @param int $level
   * @param boolean $exact
   * @return boolean
   */
  public function check_level($level, $exact=false)
  {
    
    return $exact===true ?
      $this->user->level->get('int') == $level:
      $this->user->level->get('int') >= $level;
    
  }
  
  /**
   * DEPRECATED: Use controller level permissions instead. See \dependencies\BaseComponent.
   * @param int $level
   * @param boolean $exact
   */
  public function page_authorisation($level, $exact=false)
  {
    
    #TODO: Deprecate this, in favor of controller level permission checking.
    
    if($this->check_level($level, $exact)){
      return;
    }
    
    if(mk('Config')->user('login_page')->is_set()){
      $redirect = url(URL_BASE.'?'.mk('Config')->user('login_page'), true);
    }
    
    else{
      $redirect = url(URL_BASE.'?'.mk('Config')->user('homepage'), true);
    }
    
    if($redirect->compare(mk('Url')->url)){
      throw new \exception\User('The login page requires you to be logged in. Please contact the system administrator.');
    }
    
    mk('Url')->redirect($redirect);
    
  }
  
  /**
   * DEPRECATED: Use \dependencies\account\AuthenticationTasks::becomeUser(...).
   * @param integer $user_id
   * @param boolean $persistent
   * @return self
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
  
}
