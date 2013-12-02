<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Templates extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_templates',
  
    $relations = array(
      'Pages' => array('id' => 'Pages.template_id')
    );
    
    
}