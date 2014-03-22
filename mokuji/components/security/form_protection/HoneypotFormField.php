<?php namespace components\security\form_protection\forms; if(!defined('MK')) die('No direct access.');

use \dependencies\BaseModel;
use \dependencies\forms\BaseFormField;

class HoneypotFormField extends BaseFormField
{
  
  /**
   * Outputs this field to the output stream.
   * 
   * @param array $options An optional set of options to further customize the rendering of this field.
   */
  public function render(array $options=array())
  {
    
    ?>
    <input type="text" name="<?php echo $this->column_name; ?>" value=""
      placeholder="<?php echo $this->title; ?>" tabindex="-1"
      style="width:0px;height:0px;background:none;border:none;outline:none;" />
    <?php
    
  }
  
}
