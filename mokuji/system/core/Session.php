<?php namespace core; if(!defined('TX')) die('No direct access.');

class Session
{
  
  public
    $id,
    $requested_id,
    $keep_flashes=false;
  
  private
    $opened;
  
  public function init()
  {
    
    session_start();
    $this->id = session_id();
    $this->opened = true;
    
    if(!tx('Data')->session->tx->session_init->is_set()){
      mk('Logging')->log('Core', 'Session', 'Init was not set');
      $this->regenerate();
      tx('Data')->session->tx->session_init = true;
    }
    
    $session_fingerprint = md5(tx('Data')->server->HTTP_USER_AGENT);
    
    if(tx('Data')->session->tx->session_fingerprint->is_set())
    {
      // if(tx('Data')->session->tx->session_fingerprint->get() != $session_fingerprint){
      //   $this->destroy();
      //   throw new \exception\Validation('Oops! Your user-agent is different from the one that initiated the session data you are trying to access. This is potentialy bad business. You will be logged out, please refresh the page.');
      // }
    }
    else
    {
      tx('Data')->session->tx->session_fingerprint = $session_fingerprint;
    }
    
  }
  
  public function close()
  {
    
    //No need to do this more than once.
    if(!$this->opened)
      return;
    
    tx('Logging')->log('Session', 'Closed', 'Continuing in read-only mode for this pageload.');
    
    //Write session data and close it.
    tx('Data')->restore_session();
    session_write_close();
    
  }
  
  public function __destruct()
  {
    $this->progress_flashes();
  }
  
  public function regenerate()
  {
    tx('Logging')->log('Session', 'Regenerated', 'Old ID was '.$this->id);
    session_regenerate_id();
    $this->id = session_id();
  }
  
  public function destroy()
  {
    
    $_SESSION = array();
    tx('Data')->session->un_set();
    
    if(ini_get("session.use_cookies")){
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    
    session_destroy();
    
  }
  
  public function flash()
  {
    
    $flashes = tx('Data')->session->tx->flashes;
    
    switch(func_num_args()){
      case 0: return $flashes;
      case 1: return $flashes[func_get_arg(0)]->content;
      case 2: $flashes[func_get_arg(0)]->set(array('duration'=>0, 'content'=>func_get_arg(1))); break;
      case 3: $flashes[func_get_arg(0)]->set(array('duration'=>(int)data_of(func_get_arg(1)), 'content'=>func_get_arg(2))); break;
      default: throw new \exception\InvalidArguments('Expecting 0 to 3 arguments. %s Given.', func_num_args());
    }
  
  }
  
  public function unset_flash($name)
  {
    tx('Data')->session->tx->flashes[$name]->un_set();
  }
  
  public function clear_flashes()
  {
    tx('Data')->session->tx->flashes->un_set();
  }
  
  public function keep_flashes($set=true)
  {
    $this->keep_flashes = (bool) $set;
  }
  
  private function progress_flashes()
  {
    
    $flashes = tx('Data')->session->tx->flashes;
    
    if(tx('Url')->redirected){
      return;
    }
    
    if($this->keep_flashes === true){
      return;
    }
    
    if($flashes->is_leafnode()){
      return;
    }
    
    foreach($flashes AS $name => $flash)
    {
      
      if(!$flash->duration->is_set() || $flash->duration->get() == 0){
        $flash->un_set();
      }
      
      else{
        $flash->duration--;
      }
      
    }
    
  }
  
}
