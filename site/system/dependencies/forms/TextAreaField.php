<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

class TextAreaField extends BaseFormField
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
    
    ?>
    <div class="ctrlHolder">
      <label><?php __($this->model->component(), $this->title); ?></label>
      <textarea name="<?php echo $this->column_name; ?>"><?php echo $value; ?></textarea>
    </div>
    <?php
    
  }
  
}
