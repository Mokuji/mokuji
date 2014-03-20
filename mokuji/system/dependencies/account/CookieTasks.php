<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

/**
 * Provides static methods to perform authentication logic.
 * 
 * ## About session rebasing
 *   
 *   Session rebasing is a feature that allows persistent authentication cookies to work
 *   during parallel requests. Normally this would require thread locking or the browser
 *   to know the final session ID. In other words, parallel requests should be preceded
 *   by one request to find out this session ID, or parallel requests are forced into a 
 *   sequence. Both defeating the purpose of the parallel requests.
 *   
 *   Rebasing happens only when multiple requests rely on the authentication cookie to log
 *   in. If the browser sends new requests before it finds out the session ID that will be
 *   generated, multiple session ID's will start to emerge. Rebasing forces all of these
 *   sessions to safely and quickly merge back to one session.
 * 
 */
abstract class CookieTasks
{
  
  /**
   * The duration in seconds a "remember-me" cookie may be valid for.
   * Value: 7 days.
   * @var int
   */
  const PERSISTENT_COOKIE_DURATION = 604800;
  
  /**
   * Detects support for login cookies.
   * @return boolean
   */
  public static function isLoginCookieEnabled()
  {
    
    #TODO: Make this configurable.
    
    //See if our database is up-to-date enough to support it.
    return !mk('Sql')
      ->execute_single("SHOW TABLES LIKE '#__core_user_persistent_authentication_tokens'")
      ->is_empty();
    
  }
  
  /**
   * Creates or updates a persistent authentication cookie and sets it on the client.
   * @param  integer $userId       [description]
   * @param  string  $series_token [description]
   * @param  boolean $regenerate   Out parameter, whether the session still needs regeneration.
   * @return void
   */
  public static function deployLoginCookie($userId, $series_token, &$regenerate)
  {
    
    //When login cookies are not enabled, do nothing.
    if(!CookieTasks::isLoginCookieEnabled()){
      return;
    }
    
    raw($userId, $series_token);
    
    //Generate the token.
    $cookie = CookieTasks::generateCookie($userId, $series_token);
    
    //Set the cookie on the client.
    CookieTasks::setCookie($cookie);
    
    //Alias for SQL.
    $sql = mk('Sql');
    
    //Create a new series in the database?
    if(is_null($series_token)){
      $sql->query($sql->make_query(''
        . 'INSERT INTO #__core_user_persistent_authentication_tokens (`user_id`, `access_token`, `series_token`) '
        . 'VALUES(?, ?, ?)'
        , $cookie->user_id
        , $cookie->access_token
        , $cookie->series_token
      ));
    }
    
    //Update an existing series in the database.
    else{
      
      //Regenerate now.
      mk('Session')->regenerate();
      $regenerate = false;
      
      #TODO: Use core models.
      //To manage parallel requests with this *valid* cookie, keep this entry as a rebase value.
      $sql->query($sql->make_query(''
        . 'UPDATE #__core_user_persistent_authentication_tokens '
        . 'SET rebase_session_id = ? '
        . 'WHERE user_id = ? AND series_token = ?'
        , mk('Session')->id
        , $cookie->user_id
        , $cookie->series_token
      ));
      
      #TODO: Use core models.
      //Insert a new entry for the fresh token.
      $sql->query($sql->make_query(''
        . 'INSERT INTO #__core_user_persistent_authentication_tokens (`user_id`, `access_token`, `series_token`) '
        . 'VALUES(?, ?, ?)'
        , $cookie->user_id
        , $cookie->access_token
        , $cookie->series_token
      ));
      
    }
    
  }
  
  /**
   * Attempts to log in based on a cookie.
   * Should not be called when already logged in through sessions.
   * @return boolean Whether the user was logged in.
   */
  public static function tryLogin()
  {
    
    //Get and validate the cookie.
    $token = CookieTasks::getToken();
    
    //If it was not valid, abort login.
    if($token === false){
      return false;
    }
    
    //Check if we should rebase the session.
    if(!$token->rebase_session_id->is_empty()){
      CookieTasks::performSessionRebase($token);
    }
    
    //Otherwise, do a normal login.
    else{
      
      //Log the user in.
      $user = CookieTasks::getUser($token);
      AuthenticationTasks::setLoggedIn($user, null, true, $token->series_token);
      
      //Let the current session know that on the next request it gets with this explicit session ID, the rebase value should be removed.
      mk('Data')->session->mk->remove_rebase_tokens->set(true);
      
    }
    
    //Success.
    return true;
    
  }
  
  /**
   * Do a normal logout for this client and remove the persistent authentication.
   * @return void
   */
  public static function onLogout()
  {
    
    if(CookieTasks::isLoginCookieEnabled())
    {
      
      //Get the token cookie.
      $cookie = CookieTasks::getCookie();
      
      //If the cookie exists.
      if(!$cookie->is_empty())
      {
        
        #TODO: Use core models.
        //Delete the series related to this cookie.
        mk('Sql')->query(mk('Sql')->make_query(''
          . 'DELETE FROM #__core_user_persistent_authentication_tokens '
          . 'WHERE user_id = ? AND series_token = ?'
          , $cookie->user_id
          , $cookie->series_token
        ));
        
      }
      
    }
    
    //Unset the cookie either way.
    CookieTasks::unsetCookie();
    
  }
  
  /**
   * Rebase the session to the rebase target given by the token data.
   * @param  \dependencies\Model $token The token data.
   * @return void
   */
  public static function performSessionRebase($token)
  {
    
    #TODO: Use core models.
    //Get the main token as well.
    $target = mk('Sql')->execute_single(mk('Sql')->make_query(''
      . 'SELECT * FROM #__core_user_persistent_authentication_tokens '
      . 'WHERE user_id = ? AND series_token = ? AND rebase_session_id IS NULL'
      , $token->user_id
      , $token->series_token
    ));
    
    //Store it.
    CookieTasks::setCookie($target);
    
    $sess = mk('Session');
    
    //Close the current session.
    session_write_close();
    
    //Rebase the session.
    $sess->id = $token->rebase_session_id->get();
    session_id($sess->id);
    session_start();
    
    //Load the session data into the Data class.
    mk('Data')->session = Data($_SESSION);
    $this->user =& mk('Data')->session->user;
    $_SESSION = array();
    
    //Let the current session know that on the next request it gets with this explicit session ID, the rebase value should be removed.
    mk('Data')->session->mk->remove_rebase_tokens->set(true);
    
  }
  
  /**
   * Cleans rebase entries for our session.
   * @return void
   */
  public static function cleanSessionRebase()
  {
    
    //In case we just moved to this fresh session from a persistent authentication cookie.
    if(mk('Data')->session->mk->remove_rebase_tokens->is_true())
    {
      
      #TODO: Use core models.
      mk('Sql')->execute_non_query(
        "DELETE FROM `#__core_user_persistent_authentication_tokens` ".
        "WHERE `rebase_session_id`=".mk('Sql')->escape(mk('Session')->id)
      );
      
      mk('Data')->session->mk->remove_rebase_tokens->un_set();
      
    }
    
  }
  
  /**
   * Gets and validates the cookie, retrieving the associated token data.
   * @return mixed Returns the token when cookie is valid, or false when it's not.
   */
  public static function getToken()
  {
    
    //Get the SQL singleton.
    $sql = tx('Sql');
    
    //Is our database even able to handle persistent log-in stuff?
    if(!CookieTasks::isLoginCookieEnabled()){
      return false;
    }
    
    //Get the authentication cookie.
    $cookie = CookieTasks::getCookie();
    
    //Check if it exists. If it doesn't; abort.
    if($cookie->is_empty()){
      return false;
    }
    
    //Find the user in the database.
    $user = CookieTasks::getUser($cookie);
    
    //Empty user is not allowed.
    if($user->is_empty()){
      CookieTasks::unsetCookie();
      return false;
    }
    
    //Look for the best token in this series.
    $token = CookieTasks::searchSeries($cookie);
    
    //Empty token is not allowed.
    if($token->is_empty()){
      CookieTasks::unsetCookie();
      return false;
    }
    
    //If the series has had a new access token assigned to it, we can assume cookie theft.
    if($token->access_token->get() !== $cookie->access_token->get()){
      CookieTasks::handleCompromisedCookie($user);
      return false;
    }
    
    //The token looks valid, return it.
    return $token;
    
  }
  
  /**
   * Gets the user based on given cookie.
   * @param  \dependencies\Data $cookie The cookie data to get the user for.
   * @return \dependencies\BaseModel The user for this cookie.
   */
  public static function getUser($cookie)
  {
    
    #TODO: Use core models.
    return mk('Sql')->execute_single(mk('Sql')->make_query(''
      . 'SELECT * FROM #__core_users '
      . 'WHERE id = ?'
      , $cookie->user_id
    ));
    
  }
  
  /**
   * Returns the name of the cookie to look for.
   * @return string
   */
  public static function getCookieName(){
    #TODO: Make this configurable.
    return 'persistent_auth';
  }
  
  /**
   * Return a persistent authentication token with the given user ID.
   *
   * @param integer $user_id The ID of the user to include in the token.
   * @param string $series_token An optional series token to include. Will be generated when null is given.
   * @return \dependencies\Data An object having `user_id`, `access_token` and `series_token`.
   */
  public static function generateCookie($user_id, $series_token = null)
  {
    
    return Data(array(
      'user_id' => $user_id,
      'access_token' => mk('Security')->random_string(24),
      'series_token' => (is_null($series_token) ? mk('Security')->random_string(24) : $series_token)
    ));
    
  }
  
  /**
   * Gets the parsed cookie.
   * @return \dependencies\Data An object having `user_id`, `access_token` and `series_token`.
   */
  public static function getCookie()
  {
    
    $cookie = mk('Data')->cookie->{CookieTasks::getCookieName()};
    return CookieTasks::decodeCookie($cookie);
    
  }
  
  /**
   * Sets the cookie on the client.
   * @param \dependencies\Data $cookieData An object having `user_id`, `access_token` and `series_token`.
   * @return void
   */
  public static function setCookie($cookieData)
  {
    
    $string = CookieTasks::encodeCookie($cookieData);
    setcookie(
      CookieTasks::getCookieName(), $string,
      (time()+CookieTasks::PERSISTENT_COOKIE_DURATION),
      '/'.URL_PATH.'/'
    );
    mk('Data')->cookie->{CookieTasks::getCookieName()}->set($string);
    
  }
  
  /**
   * Removes the cookie from the client and $_COOKIE.
   * @return void
   */
  public static function unsetCookie()
  {
    
    setcookie(CookieTasks::getCookieName(), '', time()-3600, '/'.URL_PATH.'/');
    mk('Data')->cookie->{CookieTasks::getCookieName()}->un_set();
    
  }
  
  /**
   * Encodes the cookie data to a cookie string.
   * @param \dependencies\Data $cookieData An object having `user_id`, `access_token` and `series_token`.
   * @return string The cookie string as can be stored in the cookie.
   */
  public static function encodeCookie($cookieData)
  {
    
    return sprintf(
      '%u.%s.%s',
      $cookieData->user_id->get(),
      $cookieData->access_token->get(),
      $cookieData->series_token->get()
    );
    
  }
  
  /**
   * Parses a given cookie string into key value pairs of it's contents.
   * @param  string $cookieString The cookie string as retrieved from the cookie.
   * @return \dependencies\Data An object having `user_id`, `access_token` and `series_token`.
   */
  public static function decodeCookie($cookieString)
  {
    
    return Data($cookieString)
      ->split('.')
      ->having(array(
        'user_id' => 0,
        'access_token' => 1,
        'series_token' => 2
      ));
    
  }
  
  /**
   * Searches the token entries in the database that are in the same series as the given cookie.
   * Will return the optimal token only.
   * @param  \dependencies\Data $cookie The cookie data to search it's series for.
   * @return \dependencies\Model The best token in this series.
   */
  public static function searchSeries($cookie)
  {
    
    #TODO: Use core models.
    $tokens = mk('Sql')->execute_query(mk('Sql')->make_query(''
      . 'SELECT * FROM #__core_user_persistent_authentication_tokens '
      . 'WHERE user_id = ? AND series_token = ?'
      , $cookie->user_id
      , $cookie->series_token
    ));
    
    //If there is more than one, that probably means a session rebase is going on.
    //Find the most appropriate one.
    if($tokens->size() > 1)
    {
      
      foreach($tokens as $candidate_token)
      {
        
        //If the access_token matches, this takes the win.
        if($candidate_token->access_token->get() === $cookie->access_token->get()){
          $token = $candidate_token;
          break;
        }
        
        //If this is not a rebase, it's the default value.
        if(!isset($token) && $candidate_token->rebase_session_id->is_empty()){
          $token = $candidate_token;
        }
        
      }
      
    }
    
    //If 0 or 1 results, just use that.
    else{
      $token = $tokens->{0};
    }
    
    return $token;
    
  }
  
  /**
   * Call this function to perform a full logout, cookie invalidation and send a warning message to the user.
   * @return void
   */
  public static function handleCompromisedCookie($user)
  {
    
    //Sql alias.
    $sql = mk('Sql');
    
    //Get the website title for use in the email.
    $title = mk('Site')->title;
    
    //Warn the user.
    $mailed = mail(
      $user->email->get(), 
      sprintf('%s: Possible security breach.', $title),
      sprintf(''
        
        //The email message.
        . 'Dear %s,'
        . n.n
        . 'It seems you visited %s with an expired authentication cookie (created by '
        . 'the "remember me" check box).'
        . n.n
        . 'The cookie might have expired because some one else has used it to gain '
        . 'access to your account illegally.'
        . n
        . 'Your account has been logged out from all computers, therefore the attacker '
        . 'will no longer have access to the account without your password.'
        . n.n
        . 'The attacker should not have had access to vital actions, as they all '
        . 'require a password to be provided. To be on the safe-side, however, we '
        . 'recommend that you change your password.'
        . n.n
        . 'To prevent this happening in the future, only use "remember me" on devices '
        . 'that you trust and don\'t visit dodgy websites that may steal your cookies.'
        . n.n
        . 'Our apologies for the inconveniences this may have caused.'
        . n.n
        . '-----'
        . n.n
        . 'This was an automated message.'
        
        //The parameters for insertion into the email message.
        , ($user->username->is_empty() ? $title.' user' : $user->username)
        , $title
        
      )
    );
    
    #TODO: Use core models.
    //Remove all tokens for this user.
    $sql->query($sql->make_query(''
      . 'DELETE FROM #__core_user_persistent_authentication_tokens '
      . 'WHERE user_id = ?'
      , $user->id
    ));
    
    //Now.
    $now = date('Y-m-d H:i:s');
    
    #TODO: Use core models.
    //Expire all active login-sessions for this user.
    $sql->query($sql->make_query(''
      . 'UPDATE #__core_user_logins '
      . 'SET dt_expiry = ? '
      . 'WHERE user_id = ? AND (dt_expiry IS NULL OR dt_expiry < ?)'
      , $now
      , $user->id
      , $now
    ));
    
    //Unset the cookie.
    CookieTasks::unsetCookie();
    
    //Warn the user more.
    #TODO: A nicer way to get this message into the output HTML.
    print(''
      . 'WARNING: Your account may have been compromised. '
      . ($mailed
          ? 'Please check the email associated with the account. '
          : 'We failed to send an email about this matter to your account. '
        )
      . 'You have been logged out.'
    );
    
  }
  
}