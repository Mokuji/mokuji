<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

/**
 * Provides static methods to perform authentication logic.
 */
abstract class AuthenticationTasks
{
  
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
  
  //Login
  
  //Logout
  
  //Become user
  
  //Claiming??
  
  //Email verification??
  
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
      
      $lastlogin = mk('Sql')->table('account', 'UserLogins')
        ->where('user_id', $user->id)
        ->order('date', 'DESC')
        ->execute_single();
      
      mk('Logging')->log('Core', 'Account check', 'Last login dump: '.$lastlogin->dump());
      
      return false;
      
    }
    
    //Should we update the expiry date?
    if($session->check('dt_expiry'))
    {
      
      //Get the initial lifetime.
      $lifetime = strtotime($session->dt_expiry->get('string')) - strtotime($session->date->get('string'));
      
      //Create the new expiry date.
      $dt_expiry = date('Y-m-d H:i:s', time() + $lifetime);
      
      //Update it in the database.
      mk('Sql')->query("UPDATE `#__core_user_logins` SET dt_expiry = '$dt_expiry' WHERE id = '{$session->id}'");
      mk('Logging')->log('Account', 'Update expiry time', 'From '.$session->dt_expiry.' to '.$dt_expiry.' lifetime was '.$lifetime);
      
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
    
    //Shortcut.
    $sql = mk('Sql');
    
    //Track if session regenerate is needed.
    $regenerate = true;
    
    //Do we want the "remember-me" functionality?
    if($persistent){
      CookieTasks::deployLoginCookie($user->id, $series_token, $regenerate);
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
    
    #TODO: Make this prettier.
    //Set meta-data.
    $that = mk('Account');
    $that->user->id = $user->id;
    $that->user->email = $user->email;
    $that->user->username = $user->username;
    $that->user->level = $user->level->get();
    $that->user->login = true;
    
  }
  
}