<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class LayoutInfo extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_layout_info',
  
    $relations = array(
      'Layouts' => array('layout_id' => 'Layouts.id')
    );
    
    
}
