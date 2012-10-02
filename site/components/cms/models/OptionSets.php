<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class OptionSets extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_option_sets',
  
    $relations = array(
      'Pages' => array('id' => 'Pages.optset_id'),
      'Options' => array('id' => 'OptionLink.optset_id')
    );
    
    
}
