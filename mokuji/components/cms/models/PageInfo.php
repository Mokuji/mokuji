<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class PageInfo extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'cms_page_info',
    
    $relations = array(
      'Pages' => array('page_id' => 'Pages.id'),
      'Languages' => array('language_id' => 'Languages.id')
    );

}
