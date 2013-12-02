<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class ModulesPageLink extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_modules_to_pages',
  
    $relations = array(
      'Modules' => array('module_id' => 'Modules.id'),
      'Pages' => array('page_id' => 'Pages.id')
    );

}
