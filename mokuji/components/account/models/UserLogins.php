<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class UserLogins extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'core_user_logins',
    
    $relations = array(
      'Accounts' => array('user_id' => 'Accounts.id')
    );
  
}
