<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_modules',
  
    $relations = array(
      'Pages' => array('id' => 'ModulesPageLink.module_id'),
      'ModulesPageLink' => array('id' => 'ModulesPageLink.module_id'),
      'Components' => array('com_id' => 'Components.id')
    );

}
