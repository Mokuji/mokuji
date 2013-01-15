<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class TextField extends BaseFormField
{
  
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
    
    parent::__construct($column_name, $title, $model, $options);
    
  }
  
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
      <input type="text" name="<?php echo $this->column_name; ?>" value="<?php echo $value; ?>" />
    </div>
    <?php
    
  }
  
}
