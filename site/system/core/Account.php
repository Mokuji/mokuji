<?php namespace core; if(!defined('TX')) die('No direct access.');

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
    
    //User is not logged in? Proceed to try log them in using an authentication cookie.
    if(!$this->user->check('login')){
      $this->login_cookie();
      return;
    }
    
    //Backwards compatibility with old login method.
    if(tx('Sql')->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty())
    {
      
      //Get the current user session from the database.
      tx('Sql')->execute_scalar(
        "SELECT id FROM `#__core_users` WHERE id = {$this->user->id} AND session = ".tx('Sql')->escape(tx('Session')->id)
      )
      
      //No exist? Shoo!
      ->is('empty', function(){
        tx('Account')->logout();
      });
      
      //Progress user activity.
      tx('Data')->server->REQUEST_TIME->copyto($this->user->activity);
      
      //Cut if off here, because the other stuff is for the people who update their databases.
      return;
      
    }
    
    //Get active login sessions from the database.
    $login = tx('Sql')->execute_single("
      SELECT * FROM `#__core_user_logins`
      WHERE 1
        AND user_id = '{$this->user->id}'
        AND (dt_expiry IS NULL OR dt_expiry > '".date('Y-m-d H:i:s')."')
        AND session_id = ".tx('Sql')->escape(tx('Session')->id)."
    ");
    
    //No login data found? Away with you!
    if($login->is_empty()){
      tx('Logging')->log('Core', 'Account check', 'Logged out, because there is no login session.');
      $lastlogin = tx('Sql')->table('account', 'UserLogins')
        ->where('user_id', $this->user->id)
        ->order('date', 'DESC')->limit(1)
        ->execute_single();
      tx('Logging')->log('Core', 'Account check', 'Last login dump: '.$lastlogin->dump());
      return $this->logout();
    }
    
    //This means we're logged in.
    //Check for https in the on-login mode.
    if(tx('Config')->user('tls_mode')->get() === 'logged-in' && tx('Url')->url->segments->scheme->get() !== 'https')
      tx('Url')->redirect(url('')->segments->merge(array('scheme' => 'https'))->back()->rebuild_output());
    
    //Check if we're interested in shared sessions.
    if(tx('Config')->user()->check('log_shared_login_sessions'))
    {
      
      //Get the exact same session.
      $session = tx('Sql')->execute_scalar("
        SELECT id FROM `#__core_user_logins`
        WHERE 1
          AND user_id = {$this->user->id}
          AND session_id = ".tx('Sql')->escape(tx('Session')->id)."
          AND IPv4 = '".tx('Data')->server->REMOTE_ADDR."'
          AND user_agent = ".tx('Sql')->escape(tx('Data')->server->HTTP_USER_AGENT)."
      ");
      
      //Is the same session being used in a different environment?
      if($session->is_empty())
      {
        
        //Log it.
        tx('Sql')->query("
          INSERT INTO `#__core_user_login_shared_sessions` VALUES(
            NULL,
            '{$login->id}',
            '".tx('Data')->server->REMOTE_ADDR."',
            ".tx('Sql')->escape(tx('Data')->server->HTTP_USER_AGENT).",
            NULL
          )
        ");
        
      }
      
    }
    
    //Should we update the expiry date?
    if($login->check('dt_expiry'))
    {
      
      //Get the initial lifetime.
      $lifetime = strtotime($login->dt_expiry->get('string')) - strtotime($login->date->get('string'));
      
      //Create the new expiry date.
      $dt_expiry = date('Y-m-d H:i:s', time() + $lifetime);
      
      //Update it in the database.
      tx('Sql')->query("UPDATE `#__core_user_logins` SET dt_expiry = '$dt_expiry' WHERE id = '{$login->id}'");
      tx('Logging')->log('Account', 'Update expiry time', 'From '.$login->dt_expiry.' to '.$dt_expiry.' lifetime was '.$lifetime);
      
    }
    
    //Progress user activity.
    tx('Data')->server->REQUEST_TIME->copyto($this->user->activity);
    
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
    $ipinfo->login_level->eq(0, function(){
      tx('Logging')->log('Core', 'Login attempt', 'FAILED: IP address '.$ipa.' is blacklisted.');
      throw new \exception\Validation('IP address blacklisted.');
    });
    
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
    $this->_set_logged_in($user, $expiry_date, $persistent);
    
  }
  
  /**
   * Looks for a login cookie, and if present, attempts to log the user in with it.
   *
   * @return boolean Whether the user was logged in.
   */
  public function login_cookie()
  {
    
    //Get the SQL singleton.
    $sql = tx('Sql');
    
    //Is our database even able to handle persistent log-in stuff?
    if($sql->execute_single("SHOW TABLES LIKE '#__core_user_persistent_authentication_tokens'")->is_empty()){
      return false;
    }
    
    //Reference the authentication cookie.
    $cookie = tx('Data')->cookie->persistent_auth;
    
    //Check if it exists. If it doesn't; abort.
    if(!$cookie->is_set()){
      return false;
    }
    
    //Parse the cookie.
    $data = $cookie->split('.')->having(array(
      'user_id' => 0,
      'access_token' => 1,
      'series_token' => 2
    ));
    
    //Find the token row by serial number.
    $token = $sql->execute_single($sql->make_query(''
      . 'SELECT * FROM #__core_user_persistent_authentication_tokens '
      . 'WHERE user_id = ? AND series_token = ?'
      , $data['user_id']
      , $data['series_token']
    ));
    
    //Find the user in the database.
    $user = $sql->execute_single($sql->make_query(''
      . 'SELECT * FROM #__core_users '
      . 'WHERE id = ?'
      , $data['user_id']
    ));
    
    //If either row is not found; remove the cookie and abort.
    if($token->is_empty() || $user->is_empty()){
      setcookie('persistent_auth', '', time()-3600, '/'.URL_PATH.'/');
      $cookie->un_set();
      return false;
    }
    
    //If the series has had a new access token assigned to it, we can assume cookie theft.
    if($token->access_token->get() !== $data->access_token->get())
    {
      
      //Get the website title for use in the email.
      $title = tx('Site')->title;
      
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
      
      //Remove all tokens for this user.
      $sql->query($sql->make_query(''
        . 'DELETE FROM #__core_user_persistent_authentication_tokens '
        . 'WHERE user_id = ?'
        , $user->id
      ));
      
      //Now.
      $now = date('Y-m-d H:i:s');
      
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
      setcookie('persistent_auth', '', time()-3600, '/'.URL_PATH.'/');
      $cookie->un_set();
      
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
      
      //Abort.
      return false;
      
    }
    
    //At this point, we know that the authentication cookie is valid. Log the user in.
    $this->_set_logged_in($user, null, true, $token->series_token->get());
    
    //Success.
    return true;
    
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
      
      //Is our database able to handle persistent log-in stuff?
      if(!$sql->execute_single("SHOW TABLES LIKE '#__core_user_persistent_authentication_tokens'")->is_empty())
      {
        
        //Get the token cookie.
        $cookie = tx('Data')->cookie->persistent_auth;
        
        //If the cookie exists.
        if($cookie->is_set())
        {
          
          //Get the user ID and series token.
          $user_id = $this->user->id->get();
          $series_token = $cookie->split('.')->{2}->get();
          
          //Remove the series from the database.
          $sql->query($sql->make_query(''
            . 'DELETE FROM #__core_user_persistent_authentication_tokens '
            . 'WHERE user_id = ? AND series_token = ?'
            , $user_id
            , $series_token
          ));
          
          //Unset the cookie.
          setcookie('persistent_auth', '', time()-3600, '/'.URL_PATH.'/');
          $cookie->un_set();
          
        }
        
      }
      
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
   * Return a persistent authentication token with the given user ID.
   *
   * @param integer $user_id The ID of the user to include in the token.
   * @param string $series_token An optional series token to include. Will be generated when null is given.
   * @param array $data An out-parameter that will be filled with an array of the different components:
   *                    * `user_id`: The given user ID.
   *                    * `access_token`: The generated access token.
   *                    * `series_token`: The given or generated series token.
   *
   * @return string The full token.
   */
  private function _generate_authentication_token($user_id, $series_token = null, &$data=null)
  {
    
    $data = array(
      'user_id' => data_of($user_id),
      'access_token' => tx('Security')->random_string(24),
      'series_token' => (is_null($series_token) ? tx('Security')->random_string(24) : data_of($series_token))
    );
    
    return sprintf(
      '%u.%s.%s',
      $data['user_id'],
      $data['access_token'],
      $data['series_token']
    );
    
  }
  
  /**
   * Sets the log-in session for a given user object.
   *
   * @param \depednecies\Data $user A row from the users table.
   * 
   * @return self Chaining enabled.
   */
  private function _set_logged_in($user, $expiry_date = null, $persistent = false, $series_token = null)
  {
    
    //Regenerate the session ID.
    tx('Session')->regenerate();
    $sql = tx('Sql');
    
    //Backwards compatibility with old database structure.
    if($sql->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty())
    {
      
      //Update the login session.
      $sql->execute_non_query("
        UPDATE `#__core_users` SET
          session = ".$sql->escape(tx('Session')->id).",
          ipa = ".$sql->escape(tx('Data')->server->REMOTE_ADDR).",
          dt_last_login = '".date('Y-m-d H:i:s')."'
        WHERE id = '{$user->id}'
      ");
      
    }
    
    //This stuff is only for the people who update their database structures.
    else
    {
      
      //Compute the expiry date.
      $dt_expiry = is_null($expiry_date) ? 'NULL' : "'".strtotime($expiry_date)."'";
      
      //Insert this login session in the database.
      $sql->execute_non_query("
        INSERT INTO `#__core_user_logins` VALUES(
          NULL,
          '{$user->id}',
          ".$sql->escape(tx('Session')->id).",
          {$dt_expiry},
          ".$sql->escape(tx('Data')->server->REMOTE_ADDR).",
          ".$sql->escape(tx('Data')->server->HTTP_USER_AGENT).",
          NULL
        )
      ");
      
      tx('Logging')->log('Core', 'Login attempt', 'Setting expiry date to '.$dt_expiry.' for session ID '.tx('Session')->id);
      
    }
    
    //Is our database able to handle persistent log-in stuff?
    if(!$sql->execute_single("SHOW TABLES LIKE '#__core_user_persistent_authentication_tokens'")->is_empty())
    {
      
      
      //Do we give the user a persistent login cookie?
      if($persistent === true)
      {
        
        //Generate the token.
        $token = $this->_generate_authentication_token($user->id, $series_token, $data);
        
        //Set the cookie.
        setcookie('persistent_auth', $token, (time()+60*60*24*7), '/'.URL_PATH.'/');
        
        //Create a new series in the database?
        if(is_null($series_token)){
          $sql->query($sql->make_query(''
            . 'INSERT INTO #__core_user_persistent_authentication_tokens '
            . 'VALUES(?, ?, ?)'
            , $data['user_id']
            , $data['access_token']
            , $data['series_token']
          ));
        }
        
        //Update an existing series in the database.
        else{
          $sql->query($sql->make_query(''
            . 'UPDATE #__core_user_persistent_authentication_tokens '
            . 'SET access_token = ? '
            . 'WHERE user_id = ? AND series_token = ?'
            , $data['access_token']
            , $data['user_id']
            , $data['series_token']
          ));
        }
        
      }
      
    }
    
    //Set meta-data.
    $this->user->id = $user->id;
    $this->user->email = $user->email;
    $this->user->username = $user->username;
    $this->user->level = $user->level->get();
    $this->user->login = true;
    
    //Enable chaining.
    return $this;
    
  }

}
