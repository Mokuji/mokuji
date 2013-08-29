<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

class HiddenField extends BaseFormField
{
  
  /**
   * Outputs this field to the output stream.
   * 
   * @param array $options An optional set of options to further customize the rendering of this field.
   */
  public function render(array $options=array())
  {
    
    parent::render($options);
    
    $value = $this->insert_value ? $this->value : '';
    echo '<input type="hidden" class="for_'.$this->column_name.'" name="'.$this->column_name.'" value="'.$value.'" />'.n;
    
  }
  
}
