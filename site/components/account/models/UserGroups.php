<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class UserGroups extends \dependencies\BaseModel
{

  protected static

    $table_name = 'account_user_groups',
    
    $relations = array(
      'AccountsToUserGroups' => array('id' => 'AccountsToUserGroups.user_group_id')
    );
  
  public static function validate_data($data)
  {
    
    return Data($data)->having('id', 'title', 'description')
      ->id->validate('ID', array('number'=>'integer'))->back()
      ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
      ->description->validate('Description', array('string'))->back();
    
  }
  
  public static function validated_create($data)
  {
    
    $data = self::validate_data($data);
    return tx('Sql')->model('account', 'UserGroups')->set($data);
    
  }
  
  public function get_users()
  {
    
    return tx('Sql')
      ->table('account', 'AccountsToUserGroups')
      ->where('user_group_id', $this->id)
      ->join('Accounts', $A)
      ->workwith($A)
      ->join('UserInfo', $UI)
      ->where("(`$UI.status` & (1|4))", '>', 0)
      ->execute($A);
    
  }
  
}
