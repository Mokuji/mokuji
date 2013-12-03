<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class AccountsToUserGroups extends \dependencies\BaseModel
{

  protected static

    $table_name = 'account_accounts_to_user_groups',
    
    $relations = array(
      'Accounts' => array('user_id' => 'Accounts.id'),
      'UserGroups' => array('user_group_id' => 'UserGroups.id')
    );

}
