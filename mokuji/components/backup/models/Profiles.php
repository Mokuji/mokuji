<?php namespace components\backup\models; if(!defined('MK')) die('No direct access.');

class Profiles extends \dependencies\BaseModel
{
  
  protected static
    $table_name = 'backup_profiles',
    
    $labels = array(
      'name' => 'Profile name',
      'title' => 'Title',
      'table_selection' => 'Table selection mode:',
      'table_drop' => 'Add DROP statements.',
      'table_structure' => 'Add table structure.',
      'table_data' => 'Add table data.',
      'output_include_comments' => 'Include comments in output.'
    ),
    
    $validate = array(
      'name' => array('required', 'string', 'not_empty', 'component_name', 'between'=>array(1, 255)),
      'title' => array('string', 'between'=>array(0, 255)),
      'table_selection' => array('required', 'string', 'not_empty', 'in'=>array('ALL', 'PREFIXED')),
      'table_drop' => array('boolean'),
      'table_structure' => array('boolean'),
      'table_data' => array('boolean'),
      'output_include_comments' => array('boolean')
    );
  
}
