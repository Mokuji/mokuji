<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class PageGroupPermissions extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_page_group_permissions',
    
    $relations = array(
      'UserGroups' => array('user_group_id' => 'Account.UserGroups.id')
    );
    
    
}
