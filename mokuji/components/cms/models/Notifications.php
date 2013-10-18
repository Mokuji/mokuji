<?php namespace components\cms\models; if(!defined('MK')) die('No direct access.');

class Notifications extends \dependencies\BaseModel
{

  protected static
    $table_name = 'cms_notifications',
  
    $validate = array(
      'id' => array('required', 'number'=>'integer', 'gt'=>0),
      'user_id' => array('number'=>'integer', 'gt'=>0),
      'level' => array('required', 'number'=>'integer', 'between'=>array(0,2)),
      'type' => array('required', 'number'=>'integer', 'in'=>array(10, 20, 30)),
      'message' => array('required', 'string', 'not_empty', 'between'=>array(1, 255)),
      'url' => array('url', 'between'=>array(0, 255))
    );
  
  public function get_type_name()
  {
    return \components\cms\classes\Notifications::type_to_string($this->type);
  }
  
}
