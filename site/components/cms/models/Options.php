<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Options extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_options',
  
    $relations = array(
      'OptionSets' => array('id' => 'OptionsLink.option_id')
    );
    
    
}
