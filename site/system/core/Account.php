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

    //progress user activity
    tx('Data')->server->REQUEST_TIME->copyto($this->user->activity);

    //validate login
    if($this->user->check('login'))
    {

      tx('Sql')->execute_scalar("
        SELECT id FROM #__core_users
        WHERE 1
          AND id = '{$this->user->id}'
          AND (email = '{$this->user->email}' OR username = '{$this->user->username}')
          AND level >= '{$this->user->level}'
          AND session = '".tx('Session')->id."'
          AND ipa = '".tx('Data')->server->REMOTE_ADDR."'
      ")

      ->is('empty', function(){
        tx('Account')->logout();
      });

    }

    else{
      $this->logout();
    }

  }

  public function login($email, $pass)
  {
    raw($email, $pass);

    $ipa = tx('Data')->server->REMOTE_ADDR->get();
    
    //Get IP permissions.
    $ipinfo = tx('Sql')
      ->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '$ipa'")
      
      //If no specific entry is available, get the global settings.
      ->is('empty', function(){
        return tx('Sql')->execute_single("SELECT * FROM #__core_ip_addresses WHERE address = '*'");
      });
    
    //Check if login is allowed.
    $ipinfo->login_level->eq(0, function(){
      throw new \exception\Validation('IP address blacklisted.');
    });

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
    
    tx('Session')->regenerate();
    
    $sid = tx('Session')->id;
    $dtl = date("Y-m-d H:i:s");
    
    tx('Sql')->execute_non_query("UPDATE #__core_users SET session = '$sid', ipa = '$ipa', dt_last_login = '$dtl' WHERE id = {$user->id}");
    
    $this->user->id = $user->id;
    $this->user->email = $user->email;
    $this->user->username = $user->username;
    $this->user->level = min($user->level->get(), $ipinfo->login_level->get());
    $this->user->login = true;
    
  }

  public function logout()
  {
    
    $this->user->un_set('id', 'email', 'activity');
    $this->user->login = false;
    $this->user->level = 0;
    
    tx('Sql')->execute_non_query("UPDATE #__core_users SET session = NULL, ipa = NULL WHERE (session != NULL OR ipa != NULL)");
    
    tx('Session')->regenerate();
    
  }

  public function register($email, $username = NULL, $password, $level=1)
  {
    $data = Data();
    raw($email, $username, $level);
    
    //Now defaults to the default hashing algorithm and salt settings defined by core-security.
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
      "INSERT INTO #__core_users (id, dt_created, email, username, password, level, session, ipa, hashing_algorithm, salt) VALUES (NULL, NOW(), '$email', '$username', '$password', '$level', '$sid', '$ipa', '{$data->hashing_algorithm}', '{$data->salt}')"
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
