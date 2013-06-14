<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class OptionsLink extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_options_link',
  
    $relations = array(
      'Options' => array('option_id' => 'Options.id'),
      'OptionSets' => array('optset_id' => 'OptionSets.id')
    );
    
    
}
