<?php namespace components\account\controllers; if(!defined('TX')) die('No direct access.');

use components\account\controllers\base\Controller;
use \dependencies\Validator;

class SessionController extends Controller
{
  
  /**
   * Contains a reference to the user object in the core.
   * @var \dependencies\Data
   */
  private $userObject;
  
  /**
   * Set the userObject.
   */
  public function __construct()
  {
    
    $this->userObject =& mk('Account')->user;
    call_user_func_array('parent::__construct', func_get_args());
    
  }
  
  /**
   * Return the user object.
   *
   * @return \dependencies\Data
   */
  public function getUserObject()
  {
    
    return $this->userObject;
    
  }
  
  /**
   * Return the level of access the user has on the server.
   * 
   * `0` For not logged in.
   * `1` For logged in.
   * `2` For super-user.
   * 
   * @return integer
   */
  public function getLoginStatus()
  {
    
    mk('Account')->is_login() ? $this->userObject->level->get('int') : 0;
    
  }
  
  /**
   * Destroy the user session.
   *
   * @return self Chaining enabled.
   */
  public function logoutUser()
  {
    
    //Use core/Account to log out the user.
    mk('Account')->logout();
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Create a user session.
   *
   * @param string $name The name of the user.
   * @param string $pass The email address of the user.
   * @param boolean $persistent Whether a persistence cookie should be created.
   *
   * @return self Chaining enabled.
   */
  public function loginUser($name, $pass, $persistent = false)
  {
    
    //Validate input.
    $name = $this->validate($name, 'Email address / username', array('required', 'not_empty', 'no_html'));
    $pass = $this->validate($pass, 'Password', array('required', 'not_empty', 'between'=>array(3, 30)));
    
    //Perform login attempt using core/Account.
    mk('Account')->login($name, $pass, null, $persistent);
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Change the session to the new given user ID.
   *
   * @param integer $userId The ID of the user to log in as.
   *
   * @return self Chaining enabled.
   */
  public function becomeUser($userId)
  {
    
    //Use core/Account to become the new user.
    mk('Account')->become_user($userId);
    
    //Enable chaining.
    return $this;
    
  }
  
}
