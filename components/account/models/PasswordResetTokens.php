<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class PasswordResetTokens extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'account_password_reset_tokens';
  
  public function generate($user_id)
  {
    
    //Set basic info.
    $this->set(array(
      'user_id' => $user_id,
      'IPv4' => tx('Data')->server->REMOTE_ADDR,
      'user_agent' => tx('Data')->server->HTTP_USER_AGENT,
      'date' => time(),
      'dt_expiry' => time() + 3600 //Expires in 1 hour.
    ));
    
    //Find a unique token.
    $attempts = 0;
    do{
      
      if($attempts > 15)
        throw new \exception\Programmer('Over 15 attempts made to generate a unique token, has the table filled up?');
      
      $token = tx('Security')->random_string(40);
      $attempts++;
      $notUnique = tx('Sql')
        ->table('account', 'PasswordResetTokens')
        ->where('token', "'{$token}'")
        ->count()->get('int') > 0;
      
    }while($notUnique);
    
    $this->token->set($token);
    
    return $this;
    
  }
  
  public function get_ipa()
  {
    return $this->IPv4;
  }
  
  public function get_is_expired()
  {
    return strtotime($this->dt_expiry->get()) <= time();
  }
  
  public function get_user()
  {
    return tx('Sql')
      ->table('account', 'Accounts')
      ->pk($this->user_id)
      ->execute_single();
  }
  
}
