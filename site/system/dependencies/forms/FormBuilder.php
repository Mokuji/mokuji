<?php namespace dependencies\forms; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;
use \dependencies\RelationType;

class FormBuilder
{
  
  protected
    $options;
  
  private
    $id,
    $model,
    $relations=array(),
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
    $this->options = $options;
    
    $this->map_relations();
    $this->generate_fields();
    
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
   * Takes all provided relations from the options, then maps and normalizes them.
   */
  protected function map_relations()
  {
    
    //See if there are relations defined at all.
    if(!isset($this->options['relations']) || !is_array($this->options['relations']))
      return;
    
    //Init some handy variables.
    $input = $this->options['relations'];
    $relations = array();
    
    //Get relation data for this model.
    $model = $this->model;
    $model_relations = ($model::model_data('relations'));
    
    //Iterate over the input.
    foreach($input as $key=>$value)
    {
      
      //Type 1 definition: Value only, for relation name.
      if(is_numeric($key) && is_string($value)){
        
        $name = $value;
        
        //Check if this relation is defined.
        if(!isset($model_relations[$name]))
          throw new \exception\Programmer('No relation defined in model \'%s.%s\' with name \'%s\'.', $model->component(), $model->model(), $name);
        
        $relation = array(
          'field_type' => null,
          'relation_type' => \dependencies\RelationType::detect_type($this->model, $model_relations[$name]),
          'filter_options' => array()
        );
        
      }
      
      //Type 2 definition: Key=Relation name, Value=RelationType
      elseif(is_string($key) && is_numeric($value)){
        
        $name = $key;
        
        //Check if this relation is defined.
        if(!isset($model_relations[$name]))
          throw new \exception\Programmer('No relation defined in model \'%s.%s\' with name \'%s\'.', $model->component(), $model->model(), $name);
        
        $relation = array(
          'field_type' => null,
          'relation_type' => $value,
          'filter_options' => array()
        );
        
      }
      
      //Type 3 definition: Key=Relation name, Value=Options array
      elseif(is_string($key) && is_array($value)){
        
        $name = $key;
        
        //Check if this relation is defined.
        if(!isset($model_relations[$name]))
          throw new \exception\Programmer('No relation defined in model \'%s.%s\' with name \'%s\'.', $model->component(), $model->model(), $name);
        
        $relation = array(
          'field_type' => isset($value['field_type']) ? $value['field_type'] : null,
          'relation_type' => isset($value['relation_type']) ? $value['relation_type'] : null,
          'filter_options' => isset($value['filter_options']) && is_array($value['filter_options']) ? $value['filter_options'] : array()
        );
        
        //Validate field_type option.
        if(!(is_null($relation['field_type']) || is_string($relation['field_type'])))
          throw new \exception\InvalidArgument('Given field_type is invalid. Must be null or a class name.');
        
        //Validate relation_type option.
        if(!(is_null($relation['relation_type']) || is_numeric($relation['relation_type'])))
          throw new \exception\InvalidArgument('Given relation_type is invalid. Must be null or RelationType.');
        
      }
      
      //Store more meta information.
      $local_field = key($model_relations[$name]);
      $target = current($model_relations[$name]);
      $target_field = substr($target, strrpos($target, '.')+1);
      $target_model = substr($target, 0, strrpos($target, '.'));
      $target_model_parts = explode('.', $target_model);
      $target_model_instance = count($target_model_parts) == 1 ?
        tx('Sql')->model($this->model->component(), $target_model_parts[0]):
        tx('Sql')->model(strtolower($target_model_parts[0]), $target_model_parts[1]);
      $relation = array_merge($relation, array(
        'local_field' => $local_field,
        'target_field' => $target_field,
        'target_model' => $target_model,
        'target_model_instance' => $target_model_instance
      ));
      
      //Detect relation type.
      if(is_null($relation['relation_type'])){
        $relation['relation_type'] = \dependencies\RelationType::detect_type($this->model, $relation);
      }
      
      //Detect additional relation data.
      $relation = $this->find_additional_relation_data($relation);
      
      //Detect field type since it's not defined yet.
      if(is_null($relation['field_type']))
      {
        
        //If the model defines a preference for the field type, use that.
        $preferences = $target_model_instance->relation_preferences();
        if(isset($preferences[$relation['relation_type']])){
          $relation['field_type'] = $preferences[$relation['relation_type']];
        }
        
        //Otherwise, let our detection algorithm find the best default we have.
        else{
          $relation['field_type'] = $this->detect_optimal_relation_field($local_field, $relation);
        }
        
      }
      
      //Insert our findings.
      $relations[$local_field] = $relation;
      
    }
    
    $this->relations = $relations;
    
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
      
      //First check that this field really exists.
      if(!$field->is_set())
      {
        throw new \exception\Programmer(
          'Tried to define form field for column name \'%s\' that does not exist in table for \'%s\\%s\'.',
          $column_name,
          $this->model->component(),
          $this->model->model()
        );
      }
      
      //Find out if this field has overrides.
      $override = array();
      if(isset($this->options['fields']) &&
        is_array($this->options['fields']) &&
        isset($this->options['fields'][$column_name]))
      {
        
        $override = $this->options['fields'][$column_name];
        
        //If the override is equal to false, exclude this field.
        if($override === false)
          continue;
        
        //Otherwise it must be an array.
        if(!is_array($override))
          $override = array();
        
      }
      
      //See if a relation is defined.
      if(isset($this->relations[$column_name]))
      {
        
        //Take the field definition from there.
        $override['options'] = $this->relations[$column_name]['option_set'];
        $field_class = $this->relations[$column_name]['field_type'];
        
      }
      
      //Otherwise find it from the base type.
      else{
        $field_class = $this->detect_optimal_field($column_name, $field, $override);
      }
      
      #TODO: Maybe copy some options from the constructor to the field.
      $override['form_id'] = $this->id();
      
      //Create the field.
      $fields[] = new $field_class(
        $column_name,
        isset($override['title']) ? $override['title'] : $title,
        $this->model,
        $override
      );
      
    }
    
    //Replace old fields.
    $this->fields = $fields;
    
  }
  
  /**
   * Based on the given field data, tries to detect the class name of the optimal field type.
   * Note that this is for detecting the base type field and does not take relations into account.
   * Defined relations should override this value.
   * 
   * @param string $column_name The name of the database column to search the optimal field for.
   * @param Data $field The field meta information.
   * @param array $override Overrides for this field that may apply.
   * @return string The full (namespaced) class name of the field type that is optimal to use.
   */
  protected function detect_optimal_field($column_name, $field, array $override=array())
  {
    
    #TODO: Detect if the model specified a specific override. Such as 'ImageUploadField'.
    
    //Maybe override the type.
    if(isset($override['type'])){
      $type = $override['type'];
    }
    
    //If there was an override, don't do the normal detection. Save some CPU, save the rainforest!.
    if(!isset($type))
    {
      
      $model = $this->model;
      
      //Map the MySql data types to the most basic defaults.
      $ns = '\\dependencies\\forms\\';
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
      $typeMatches = array_search_recursive($field->type->get(), $field_types);
      if($typeMatches!==false){
        $type = array_get($typeMatches, 0);
      }
      
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
      
    }
    
    //See if the class we came up with exists.
    if(!isset($type)) throw new \exception\Programmer('Unknown column data type '.$field->type->get().'.');
    if(!class_exists($type)) throw new \exception\Programmer('The field type '.$type.' has been detected as optimal. However it does not exist.');
    
    //Return the field type.
    return $type;
    
  }
  
  /**
   * Based on the given field data, tries to detect the class name of the optimal field type.
   * Note that this is for detecting the relation field and does not take base types into account.
   * This should be used to override base types.
   * 
   * @param string $column_name The name of the database column to search the optimal field for.
   * @param Data &$relation The normalized relation information.
   * @param array $option_set The option set that is found for this relation.
   * @return string The full (namespaced) class name of the field type that is optimal to use.
   */
  protected function detect_optimal_relation_field($column_name, &$relation)
  {
    
    //Maybe the work has already been done for us.
    if(isset($relation['field_type'])){
      $type = $relation['field_type'];
    }
    
    //If there was an override, don't do the normal detection. Save some CPU, save the rainforest!.
    if(!isset($type))
    {
      
      $model = $this->model;
      $ns = '\\dependencies\\forms\\';
      $field = $this->model->table_data()->fields[$column_name];
      
      switch($relation['relation_type']){
        
        case RelationType::ForeignKey:
          
          //Get the option set size.
          $size = isset($relation['option_set']) && is_array($relation['option_set']) ?
            count($relation['option_set']) : 0;
          
          //By default this is a radio field.
          $type = $ns.'RadioField';
          
          //If we have a large option set, select field.
          if($size > 4)
            $type = $ns.'SelectField';
          
          //If the option set is empty while the field cannot be null, exception.
          if($size == 0 && $field->null_allowed->get('bool') !== true)
          {
            
            $tmp = $model->labels();
            throw new \exception\Expected(
              'Relation defined for \'%s\' but there are no options available and the field is not optional',
              $tmp[$column_name]
            );
            
          }
          
          break;
        
        case RelationType::Reference:
          throw new \exception\Exception('Reference relation types are not yet supported.');
          
        
        default:
          throw new \exception\Exception('RelationType with ID %s is not implemented.', $relation['relation_type']);
        
      }
      
    }
    
    //See if the class we came up with exists.
    if(!isset($type)) throw new \exception\Programmer('Unable to detect relation field for column \'%s\'', $column_name);
    if(!class_exists($type)) throw new \exception\Programmer('The field type '.$type.' has been detected as optimal. However it does not exist.');
    
    //Return the field type.
    return $type;
    
  }
  
  /**
   * Depending on all the earlier detected variables gathers all relevant data about the relation.
   * For example when applicable gathers an option_set.
   *
   * @param array $relation The relation to find additional data for.
   */
  protected function find_additional_relation_data(array $relation)
  {
    
    switch($relation['relation_type']){
        
      case RelationType::ForeignKey:
        
        //Find option set.
        $relation['option_set'] = tx('Sql')
          ->table($relation['target_model_instance']->component(), $relation['target_model_instance']->model())
          ->is(count($relation['filter_options']) > 0, function($t)use($relation){
            
            //Add the filters.
            foreach($relation['filter_options'] as $key => $value){
              $t->where($key, $value);
            }
            
          })
          ->execute()
          ->as_option_set($relation['target_field']);
        
        break;
      
    }
    
    return $relation;
    
  }
  
}
