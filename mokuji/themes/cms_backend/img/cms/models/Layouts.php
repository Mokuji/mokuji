<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Layouts extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_layouts',
  
    $relations = array(
      'Pages' => array('id' => 'Pages.layout_id'),
      'LayoutInfo' => array('id' => 'LayoutInfo.layout_id')
    ),
    
    $hierarchy = array(
      'left' => 'lft',
      'right' => 'rgt'
    );
    
    
}
