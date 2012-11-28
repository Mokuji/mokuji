<?php namespace core; if(!defined('TX')) die('No direct access.');

class Account
{

  public
    $user;

  public function __construct()
  {
  }

  public function init()
  {

    //append user object for easy access
    $this->user =& tx('Data')->session->user;

    //User is not logged in? Nothing else left but to make sure.
    if(!$this->user->check('login')){
      return $this->logout();
    }
    
    //Backwards compatibility with old login method.
    if(tx('Sql')->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty())
    {
      
      //Get the current user session from the database.
      tx('Sql')->execute_scalar(
        "SELECT id FROM `#__core_users` WHERE id = {$this->user->id} AND session = '".tx('Session')->id."'"
      )
      
      //No exist? Shoo!
      ->is('empty', function(){
        tx('Account')->logout();
      });
      
      //Progress user activity.
      tx('Data')->server->REQUEST_TIME->copyto($this->user->activity);
      
      //Cut if off here, because the other stuff is for the people who update their databases.
      return $this;
      
    }
    
    //Get active login sessions from the database.
    $login = tx('Sql')->execute_single("
      SELECT * FROM `#__core_user_logins`
      WHERE 1
        AND user_id = {$this->user->id}
        AND (dt_expiry IS NULL OR dt_expiry > '".date('Y-m-d H:i:s')."')
        AND session_id = '".tx('Session')->id."'
    ");
    
    //No login data found? Away with you!
    if($login->is_empty()){
      return $this->logout();
    }
    
    //Check if we're interested in shared sessions.
    if(tx('Config')->user()->check('log_shared_login_sessions'))
    {
      
      //Get the exact same session.
      $session = tx('Sql')->execute_scalar("
        SELECT id FROM `#__core_user_logins`
        WHERE 1
          AND user_id = {$this->user->id}
          AND session_id = '".tx('Session')->id."'
          AND IPv4 = '".tx('Data')->server->REMOTE_ADDR."'
          AND user_agent = '".tx('Data')->server->HTTP_USER_AGENT."'
      ");
      
      //Is the same session being used in a different environment?
      if($session->is_empty())
      {
        
        //Log it.
        tx('Sql')->query("
          INSERT INTO `#__core_user_login_shared_sessions` VALUES(
            NULL,
            {$login->id},
            '".tx('Data')->server->REMOTE_ADDR."',
            '".tx('Data')->server->HTTP_USER_AGENT."',
            NULL
          )
        ");
        
      }
      
    }
    
    //Should we update the expiry date?
    if($login->check('dt_expiry'))
    {
      
      //Get the initial lifetime.
      $lifetime = $login->dt_expiry->get('int') - $login->date->get('int');
      
      //Create the new expiry date.
      $dt_expiry = date('Y-m-d H:i:s', time() + $lifetime);
      
      //Update it in the database.
      tx('Sql')->query("UPDATE `#__core_user_logins` SET dt_expiry = $dt_expiry WHERE id = {$login->id}");
      
    }
    
    //Progress user activity.
    tx('Data')->server->REQUEST_TIME->copyto($this->user->activity);
    
  }

  public function login($email, $pass, $expiry_date = null)
  {
    
    //If we're already logged in: Do nothing. :)
    if($this->user->check('login')){
      return $this;
    }
    
    //Extract raw data.
    raw($email, $pass);
    
    //Get the client IP address.
    $ipa = tx('Data')->server->REMOTE_ADDR->get();
    
    //Get IP permissions.
    $ipinfo = tx('Sql')->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '$ipa'")
      
      //If no specific entry is available, get the global settings.
      ->is('empty', function(){
        return tx('Sql')->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '*'");
      });
    
    //Check if login is allowed.
    $ipinfo->login_level->eq(0, function(){
      throw new \exception\Validation('IP address blacklisted.');
    });
    
    //Get the user record based on the given email address or user name.
    $user = tx('Sql')->execute_single("SELECT * FROM #__core_users WHERE email = '$email' OR username = '$email'")->is('empty', function(){
      throw new \exception\EmptyResult('User account not found.');
    });
    
    //See if we're using improved hashing.
    $user->hashing_algorithm->not('empty')
      
      //Use improved hashing.
      ->success(function()use($user, $pass){
        
        //Apply salt, if any.
        $spass = $user->salt->otherwise('')->get('string') . $pass;
        
        //Apply hashing algorithm.
        $hspass = tx('Security')->hash($spass, $user->hashing_algorithm);

        //Compare hashes.
        if($user->password->get() !== $hspass)
          throw new \exception\Validation('Invalid password.');
        
      })
      
      //Use the old way.
      ->failure(function()use($user, $pass){
        
        if(md5($pass) !== $user->password->get()){
          throw new \exception\Validation('Invalid password.');
        }
        
      })
      
    ;//END - password checking.
    
    //Regenerate the session ID.
    tx('Session')->regenerate();
    
    //Backwards compatibility with old database structure.
    if(tx('Sql')->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty())
    {
      
      //Update the login session.
      tx('Sql')->execute_non_query("
        UPDATE `#__core_users` SET
          session = '".tx('Session')->id."',
          ipa = '".tx('Data')->server->REMOTE_ADDR."',
          dt_last_login = '".date('Y-m-d H:i:s')."'
        WHERE id = {$user->id}
      ");
      
    }
    
    //This stuff is only for the people who update their database structures.
    else
    {
      
      //Compute the expiry date.
      $dt_expiry = is_null($expiry_date) ? 'NULL' : "'".strtotime($expiry_date)."'";
      
      //Insert this login session in the database.
      tx('Sql')->execute_non_query("
        INSERT INTO `#__core_user_logins` VALUES(
          NULL,
          {$user->id},
          '".tx('Session')->id."',
          {$dt_expiry},
          '".tx('Data')->server->REMOTE_ADDR."',
          '".tx('Data')->server->HTTP_USER_AGENT."',
          NULL
        )
      ");
      
    }
    
    //Set meta-data.
    $this->user->id = $user->id;
    $this->user->email = $user->email;
    $this->user->username = $user->username;
    $this->user->level = min($user->level->get(), $ipinfo->login_level->get());
    $this->user->login = true;
    
    //Enable chaining.
    return $this;
    
  }

  public function logout()
  {
    
    //Really logged in? Log out from the database.
    if($this->user->check('login'))
    {
      
      //Log out the old way.
      if(tx('Sql')->execute_single("SHOW TABLES LIKE '#__core_user_logins'")->is_empty()){
        tx('Sql')->execute_non_query("UPDATE `#__core_users` SET session = NULL, ipa = NULL WHERE id = {$this->user->id}");
      }
      
      //Log out the new way.
      else
      {
        
        tx('Sql')->execute_non_query("
          UPDATE `#__core_user_logins` 
            SET
              dt_expiry = '".date('Y-m-d H:i:s')."'
            WHERE 1
              AND user_id = {$this->user->id}
              AND session_id = '".tx('Session')->id."'
        ");
        
      }
      
    }
    
    //Regenerate the session ID.
    tx('Session')->regenerate();
    
    //Unset meta-data.
    $this->user->un_set('id', 'email', 'activity');
    $this->user->login = false;
    $this->user->level = 0;
    
    //Enable chaining.
    return $this;
    
  }

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
        (NULL, NOW(),      '$email', '$username', '$password', '$level', '{$data->hashing_algorithm}', '{$data->salt}')"
    );
    
    if(tx('Component')->available('account'))
    {
      
      tx('Sql')->execute_non_query(
        "INSERT INTO #__account_user_info (user_id, status) VALUES (".abs(mysql_insert_id()).", 1)"
      );
      
    }
    
    return true;
    
  }

  public function check_level($level, $exact=false)
  {
    
    return ($exact===true ? $this->user->level->get('int') == $level : $this->user->level->get('int') >= $level);
    
  }
  
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
