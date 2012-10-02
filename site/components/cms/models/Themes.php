<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Themes extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_themes',
  
    $relations = array(
      'Pages' => array('id' => 'Pages.theme_id')
    );
    
    
}