<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class ComponentViewCustomNames extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_component_view_custom_names',
  
    $relations = array(
      'Languages' => array('lang_id' => 'Languages.id'),
      'ComponentViews' => array('com_view_id' => 'ComponentViews.id')
    );
    
    
}
