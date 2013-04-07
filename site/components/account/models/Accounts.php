<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class Accounts extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'core_users',
    
    $relations = array(
      'UserInfo' => array('id' => 'UserInfo.user_id'),
      'AccountsToUserGroups' => array('id' => 'AccountsToUserGroups.user_id')
    ),
    
    $validate = array(
      'email' => array('required', 'email'),
      'username' => array('string', 'between'=>array(0, 255), 'no_html'),
      'name' => array('string', 'between'=>array(0, 255), 'no_html'),
      'preposition' => array('string', 'between'=>array(0, 255), 'no_html'),
      'family_name' => array('string', 'between'=>array(0, 255), 'no_html'),
      'comments' => array('string', 'no_html')
    );
  
  public function get_is_administrator()
  {
    
    return $this->level->get('int') == 2;
    
  }
  
  public function get_user_info()
  {
    
    return $this->table('UserInfo')->where('user_id', $this->__get('id'))->execute_single();
    
  }
  
  public function get_groups()
  {
    
    return tx('Sql')
      ->table('account', 'AccountsToUserGroups')
      ->where('user_id', $this->id)
      ->join('UserGroups', $UG)
      ->execute($UG);
    
  }
  
  //Return the list of logins for this user.
  public function get_logins()
  {
    
    return tx('Sql')
      ->table('account', 'UserLogins')
      ->where('user_id', $this->__get('id'))
      ->execute();
    
  }
  
  //Return the last login date.
  public function get_last_login()
  {
    
    return tx('Sql')
      ->table('account', 'UserLogins')
      ->where('user_id', $this->__get('id'))
      ->order('date', 'DESC')
      ->limit(1)
      ->execute_single()
      ->date;
  }

  //Return the avatar URL.
  public function get_avatar()
  {

    $image = tx('Sql')->table('media', 'Images')
      ->pk($this->user_info->avatar_image_id)
      ->execute_single();
    
    if($image->get())
      return $image->generate_url(array('fit_width' => 200, 'fit_height' => 200));

    else
      return false;
    

  }
  

  
}
