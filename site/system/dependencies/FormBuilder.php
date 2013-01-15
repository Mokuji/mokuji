<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class FormBuilder
{
  
  protected
    $options;
  
  private
    $id,
    $model,
    $fields=array();
  
  /**
   * Creates a new form builder instance.
   *
   * @param BaseModel $model The model that this form builder is building the form for.
   * @param array $options An array of options to modify the FormBuilder.
   */
  public function __construct(BaseModel $model, array $options=array())
  {
    
    $this->model = $model;
    $this->generate_fields();
    $this->options = $options;
    
  }
  
  /**
   * Returns the unique ID of this form.
   *
   * @return string The unique ID of this form.
   */
  public function id()
  {
    
    if(!isset($this->id)){
      $this->id = uniqid('form_');
    }
    
    return $this->id;
    
  }
  
  /**
   * Outputs the form to the output stream.
   * 
   * @param array $options The options for the rendering of this form.
   *    string/language_id $force_language The language code or ID of the language to force the form to be translated to.
   *    string $translate_component The component name from which to use component specific translations.
   *    string/Url $action The action URL to use.
   *      Default: generate one in the format "action=<component>/<insert|update>_<model_name>".
   */
  public function render(array $options)
  {
    
    //TODO: Add field ordering option.
    
    if(isset($options['action'])){
      $action = url($options['action'], 1);
    }
    
    else
    {
      
      $this->pks()->each(function($pk)use(&$update){
        $update = $pk->is_set();
        return $update;
      });
        
      $action = url("?action={$this->component}/".($update ? 'update' : 'insert')."_".strtolower(preg_replace('~([A-Z])([A-Z][a-z])|([a-z0-9])([A-Z])~', '\1\3_\2\4', $this->model).'/post'));
      
    }
    
    $classes = 'form auto-generated';
    if(isset($options['class'])){
      $classes .= ' '.$options['class'];
    }
    
    $method = isset($options['method']) ? $options['method'] : 'POST';
    
    ?>
      <form id="<?php echo $this->id(); ?>" class="<?php echo $classes; ?>" action="<?php echo $action; ?>" method="<?php echo $method; ?>">
    <?php
    
    foreach($this->fields as $field){
      $field->render($options);
    }
    
    ?>
      <div class="ctrlHolder">
        <input type="submit" value="<?php __('Save'); ?>" />
      </div>
    </form>
    <?php
    
  }
  
  /**
   * Create instances of each of the fields in the model.
   */
  protected function generate_fields()
  {
    
    //Gather the information we need.
    $labels = $this->model->labels();
    $table = $this->model->table_data();
    $fields = array();
    
    //For each of the fields.
    foreach($labels as $column_name => $title)
    {
      
      //Get the table information of this field.
      $field = $table->fields[$column_name];
      
      //Try to find the best field type.
      $field_class = $this->detect_optimal_field($column_name, $field);
      
      #TODO: Maybe copy some options from the constructor to the field.
      //Create the field.
      $fields[] = new $field_class($column_name, $title, $this->model, array());
      
    }
    
    //Replace old fields.
    $this->fields = $fields;
    
  }
  
  /**
   * Based on the given field data, tries to detect the class name of the optimal field type.
   * Note that this is for detecting the base type field and does not take relations into account.
   * Defined relations should override this value.
   * 
   * @return string The full (namespaced) class name of the field type that is optimal to use.
   */
  protected function detect_optimal_field($column_name, $field)
  {
    
    #TODO: Detect if the model specified a specific override. Such as 'ImageUploadField'.
    #TODO: Implement the field classes being detected.
    
    $model = $this->model;
    
    //Map the MySql data types to the most basic defaults.
    $ns = '\\dependencies\\';
    $field_types = array(
      $ns.'TextField' => array('char', 'varchar', 'tinytext'),
      $ns.'NumberField' => array('int', 'tinyint', 'smallint', 'mediumint', 'bigint'),
      $ns.'DecimalField' => array('float', 'double', 'decimal', 'real'),
      $ns.'CheckboxField' => array('set', 'boolean'),
      $ns.'RadioField' => array('enum'),
      $ns.'TextAreaField' => array('text', 'mediumtext', 'longtext'),
      $ns.'DatePickerField' => array('date'),
      $ns.'DateTimePickerField' => array('datetime', 'timestamp')
    );
    
    /* For easy reference, other types that are detected:
      HiddenField
      SelectField
    */
    
    //Find which type to use based only on data type.
    $type = array_get(array_search_recursive($field->type->get(), $field_types), 0);
    if($type==false) \exception\Programmer('Unknown column data type '.$field->type->get().'.');
    
    
    ### Now further detect specific cases. ###
    
    //Primary key, being an auto_increment field. => HiddenField
    if($model->ai(true)->get() === $field->key() && in_array($column_name, $model->pks(true)->as_array()))
      $type = $ns.'HiddenField';
    
    //Enum fields with many options (more than 4). => SelectField
    if($field->type->get() === 'enum' && $field->arguments->size() > 4)
      $type = $ns.'SelectField';
    
    //Tinyint(1) and bit(1) fields. => CheckboxField
    if(in_array($field->type->get(), array('tinyint', 'bit')) && $field->arguments->{0}->get('int') === 1)
      $type = $ns.'CheckboxField';
    
    //Detect more cases here.
    
    ### End - detecting more specific cases. ###
    
    
    //See if the class we came up with exists.
    if(!class_exists($type))
      throw new \exception\Programmer('The field type '.$type.' has been detected as optimal. However it does not exist.');
    
    //Return the field type.
    return $type;
    
  }
  
}
