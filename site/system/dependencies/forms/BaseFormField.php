<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

abstract class BaseFormField
{
  
  protected
    $model,
    $value,
    $title,
    $column_name,
    $insert_value,
    $form_id;
  
  /**
   * Initiates a new form field.
   *
   * @param string $column_name The table column name for this field.
   * @param string $title The preferred and translated title to use for this field.
   * @param BaseModel $model The model that this field is related to.
   * @param array $options An optional set of options to further customize this field.
   */
  public function __construct($column_name, $title, BaseModel $model, array $options=array())
  {
    
    $this->model = $model;
    $this->value = $model[$column_name];
    $this->column_name = $column_name;
    $this->title = $title;
    $this->form_id = $options['form_id'];
    
  }
  
  /**
   * Outputs this field to the output stream.
   * 
   * @param array $options An optional set of options to further customize the rendering of this field.
   */
  public function render(array $options=array())
  {
    
    $this->insert_value = isset($options['insert_value']) && $options['insert_value'] === false ? false : true;
    
  }
  
}
