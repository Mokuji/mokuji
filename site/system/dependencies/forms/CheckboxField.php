<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

class CheckBoxField extends BaseFormField
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
    
    
    ### Determine the option set. ###
    
    //If it's given in the overrides.
    if(isset($options['options']) && is_array($options['options']))
    {
      
      //Pretty easy.
      $this->option_set = $options['options'];
      
    }
    
    //Otherwise, find out from the database.
    else
    {
      
      $field = $model->table_data()->fields[$column_name];
      
      //boolean, bit(1) or tinyint(1) implementations.
      if($field->type->get() === 'boolean' ||
        (in_array($field->type->get(), array('bit', 'tinyint')) && $field->arguments->get('int') === 1))
      {
        
        //We don't have a set, but a single value.
        $this->option_set = array(1);
        
      }
      
      if($field->type->get() === 'set')
      {
        
        //Also pretty easy.
        $this->option_set = array_combine($field->arguments->as_array(), $field->arguments->as_array());
        
      }
      
      if(!isset($this->option_set))
        throw new \exception\Programmer('SelectField has no source for the option set');
      
    }
    
    ### End - determine option set. ###
    
  }
  
  /**
   * Outputs this field to the output stream.
   * 
   * @param array $options An optional set of options to further customize the rendering of this field.
   */
  public function render(array $options=array())
  {
    
    parent::render($options);
    
    //For single option, use one line.
    if(count($this->option_set) == 1)
    {
      
      $value = $this->insert_value ? $this->value : false;
      
      ?>
      <div class="ctrlHolder for_<?php echo $this->column_name; ?>">
        <label>
          <input type="checkbox" name="<?php echo $this->column_name; ?>" value="1"<?php if($this->value->get('bool')) echo 'checked="checked"' ?> />
          <?php __($this->model->component(), $this->title); ?>
        </label>
      </div>
      <?php
      
    }
    
    //For multiple options, use a fieldset.
    else
    {
      
      $values = $this->insert_value && is_string($this->value) ? explode(',', $this->value) : array();
      
      ?>
      <div class="ctrlHolder for_<?php echo $this->column_name; ?>">
        <p><?php __($this->model->component(), $this->title); ?></legend>
        <?php foreach($this->option_set as $key=>$title): ?>
          <label>
            <input type="checkbox" name="<?php echo $this->column_name; ?>[<?php echo $key; ?>]" value="1"<?php if(in_array($key, $values)) echo 'checked="checked"' ?> />
            <?php __($this->model->component(), $title, 'ucfirst'); ?>
          </label>
        <?php endforeach; ?>
      </div>
      <?php
      
    }
    
  }
  
}
