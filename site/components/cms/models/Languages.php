<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Languages extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'core_languages',
  
    $relations = array(
      'ComponentViewInfo' => array('id' => 'ComponentViewInfo.lang_id'),
      'MenuItemInfo' => array('id' => 'MenuItemInfo.lang_id'),
      'LanguageInfo' => array('id' => 'LanguageInfo.language_id')
    );
    
    
}
