<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

class DateTimePickerField extends BaseFormField
{
  
  #TODO: Make date time picker widget.
  
  /**
   * Outputs this field to the output stream.
   * 
   * @param array $options An optional set of options to further customize the rendering of this field.
   */
  public function render(array $options=array())
  {
    
    parent::render($options);
    
    $value = $this->insert_value ? $this->value : '';
    
    $uid = 'l_'.tx('Security')->random_string(); ?>
    
    ?>
    <div class="ctrlHolder for_<?php echo $this->column_name; ?>">
      <label for="<?php echo $uid; ?>" class="label"><?php __($this->model->component(), $this->title); ?></label>
      <input id="<?php echo $uid; ?>" type="text" name="<?php echo $this->column_name; ?>" value="<?php echo $value; ?>" />
    </div>
    <?php
    
  }
  
}
