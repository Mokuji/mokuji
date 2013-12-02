<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Components extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_components',
  
    $relations = array(
      'Pages' => array('id' => 'Pages.com_id'),
      'ComponentViews' => array('id' => 'ComponentViews.com_id')
    );
    
}