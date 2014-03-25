<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class BaseModel extends Data
{
  
  protected static
    $generatedLabels = array(),
    $labels = array(),
    $validate = array(),
    $relation_preferences = array(),
    $relations_by_column;
  
  private static
    $table_data = array();
  
  private
    $deleted=false,
    $component,
    $model;
  
  // Constructor is to be executed after the extended class's constructor.
  public function __construct($database_row=null, &$resultset=false, $key=false)
  {
    
    // set component
    $this->component = array_get(explode('\\', get_class($this)), 1);

    //set model
    $this->model = substr(strrchr(get_class($this), '\\'), 1);
    
    //Compile label names.
    $this->refresh_labels();

    // be sure table data is retrieved
    self::table_data();

    // set the context
    $this->_set_context($resultset, $key);

    //Apply default values
    $this->set(self::table_data()->fields->map(function($val, $key)use(&$database_row){
      
      //Workaround for byte strings from mysql_fetch_assoc.
      #TODO: is this still needed with PDO?
      if($val->type->get() === 'bit' && $val->arguments->{0}->get('int') === 1 && gettype($database_row[$key]) === 'string'){
        $database_row[$key] = $database_row[$key] === "\x01";
      }
      
      if($val->check('null_allowed') && !$val->value->is_set()){
        return array($key => $val->value);
      }else{
        return null;
      }
      
    }));
    
    //Set the supplied array if any
    if(is_array($database_row)){
      $this->merge($database_row);
    }

  }
  
  public static function clear_table_data_cache()
  {
    self::$table_data=array();
  }
  
  // Getter for table data
  public static function table_data($get=false, $set=false)
  {
    
    //Has caching of it's own, so don't do the checks twice.
    self::create_table_data();
    return self::$table_data[self::model_data('table_name')];
    
  }

  // get metadata from the model extending this basemodel: table_name, aliases, nesting, or relations
  public static function model_data($get)
  {
    
    switch($get)
    {
      
      case 'table_name':
        return tx('Sql')->get_prefix().static::$table_name;
      
      case 'title_field':
        return isset(static::$title_field) && is_string(static::$title_field) ? static::$title_field : 'title';
      
      case 'fields':
        return isset(static::$fields) && is_array(static::$fields) ? static::$fields : array();

      case 'hierarchy':
        return isset(static::$hierarchy) && is_array(static::$hierarchy) ? static::$hierarchy : array();

      case 'relations':
        return isset(static::$relations) && is_array(static::$relations) ? static::$relations : array();

      case 'secondary_keys':
        return isset(static::$secondary_keys) && is_array(static::$secondary_keys) ? static::$secondary_keys : array();
      
      case 'validate':
        return isset(static::$validate) && is_array(static::$validate) ? static::$validate : array();
      
    }

  }
  
  public static function get_related_model($name)
  {
    
    $relations = static::model_data('relations');
    $model_name = substr(strrchr(get_class($this), '\\'), 1);
    
    if(!isset($relations[$name]))
      throw new \exception\NotFound('The relation "%s" is not defined in model %s.', $name, $model_name);
    
    $parts = explode('.', current($relations[$name]));
    $part_count = count($parts);
    
    if($part_count < 2 || $part_count > 3){
      throw new \exception\Programmer(
        'The foreign column in the relation to %s defined in %s has an invalid format. Expected format '.
        'is: "[ComponentName.]ModelName.column_name". Given value is: "%s"', $model_name, $name, current($relations[$name])
      );
    }
    
    switch ($part_count) {
      case 2:
        $component = array_get(explode('\\', get_class($this)), 1);
        $model = $parts[0];
        $field_name = $parts[1];
        break;
      
      case 3:
        $component = $parts[0];
        $model = $parts[1];
        $field_name = $parts[2];
        break;
    }
    
    return array(
      'class' => load_model($component, $model),
      'foreign_field' => $field_name,
      'source_field' => key($relations[$name])
    );
    
  }
  
  /**
   * Gets the relations grouped by column name, rather than target model name.
   * 
   * @param string $column Gets the result for one specific column. Defaults to returning all columns.
   * @return array The relations of this model grouped by column name.
   *    The format for this is:
   *      [column_name] => array(   | For every column... (only if $column is not set)
   *        [0,1,...,n] => array(   | A 0-indexed array of relations.
   *          [target] => (string), | The target field of the relation.
   *          [model] => (string)   | The target model of the relation.
   *        )
   *      )
   */
  public function relations_by_column($column=null)
  {
    
    if(!isset(static::$relations_by_column))
    {
      
      $relations = $this->model_data('relations');
      $result = array();
      
      foreach($relations as $model => $relation)
      {
        
        reset($relation);
        $column_name = key($relation);
        $target = current($relation);
        
        if(!isset($result[$column_name])){
          $result[$column_name] = array();
        }
        
        $result[$column_name][] = array(
          'target' => $target,
          'model' => $model
        );
        
      }
      
      static::$relations_by_column = $result;
      
    }
    
    if(isset($column))
      return static::$relations_by_column[$column_name];
    return static::$relations_by_column;
    
  }

  // Magic set function either sets the attribute directly or calls a custom setter function if it exists.
  public function __set($var_name, $value)
  {
    
    if(method_exists($this, 'set_'.$var_name)){
      $this->set(array($var_name=>call_user_func(array($this, 'set_'.$var_name), $value)));
    }else{
      $this->set(array($var_name=>$value));
    }
    
  }

  // Magic get function either gets the attribute directly or calls a custom getter function if it exists.
  public function __get($var_name)
  {

    if(method_exists($this, 'get_'.$var_name) && !parent::__get($var_name)->is_set()){
      $val = call_user_func(array($this, 'get_'.$var_name));
      parent::__get($var_name)->become(Data($val));
    }
    return parent::__get($var_name);

  }

  // Get the auto increment field (or key if first param is true).
  public function ai($get_key=false)
  {

    if($get_key === true){
      return self::table_data()->auto_increment;
    }

    return $this[self::table_data()->auto_increment];

  }

  // get primary keys
  public function pks($get_keys=false)
  {

    if($get_keys === true){
      return self::table_data()->primary_keys;
    }

    return $this->having(self::table_data()->primary_keys->as_array());

  }

  // get secondary keys
  public function sks($get_keys=false)
  {

    if($get_keys === true){
      return self::model_data('secondary_keys');
    }

    return $this->having(self::model_data('secondary_keys'));

  }
  
  public function component()
  {
    return $this->component;
  }
  
  public function model()
  {
    return $this->model;
  }

  /**
   * Create an HTML form for updating this model.
   *
   *  as_form(&$id[, $action][, $columns])
   *  @id       (string)          Form ID.
   *  @action   (string)          An action to execute with the form.
   *  @action   (string)          An URL, to set as form action.
   *  @action   (instanceof Url)  Read the last two words at the left of this description.
   *  @columns  (array)           Array of columns.
   *    array('column_name' => 'string')              Type, see $field_types.
   *    array('column_name' => instanceof \Closure)   $closure($value, $info[$column], $options).
   *    array('column_name' => array())               Array with options.
   *      add_placeholder     (bool)    If true, also set an placeholder name. See below.
   *      name                (string)  Placeholder title.
   *      required            (bool)    Well..
   *      wrapper_attributes  (array)   Wrapper attributes. E.g. class="awesomeness".
   *      field_attributes    (array)   Field attributes. E.g. class="small".
   *      field_id            (string)  E.g. <label for="$field_id">, <input id="$field_id">.
   *      label               (string)  E.g. <label>$label</label>.
   *      accesskey           (string)  E.g. <label accesskey="$accesskey">.
   *      custom_field        (bool)    Whether to add this field regardless of the column name being present in the table.
   *      custom_html         (string)  When type = custom, this field contains the html for the field.
   */
  public function as_form(&$id)
  {
    
    //Predefine variables.
    $field_types = array(
      'text' => array('char', 'varchar'),
      'number' => array('int', 'tinyint', 'smallint', 'mediumint', 'bigint', 'float', 'double', 'decimal'),
      'checkbox' => array('set', 'boolean'),
      'radio' => array('enum'),
      'email',
      'url',
      'range',
      'date, month, week, time, datetime, datetime-local',
      'color',
      'hidden',
      'textarea' => array('text'),
      'custom' => array('custom') //Requires custom_html option to be set.
    );
    
    $info = self::table_data()->fields;
    $id = uniqid('form_');
    
    //Handle arguments.
    $args = func_get_args();
    array_shift($args);
    
    //A string as first argument is an action to execute with the form, or a url.
    if(count($args) > 0 && is_string($args[0]))
    {
      
      if(preg_match('~^[a-z_]+$~', $args[0])){
        $action = url('?action='.$args[0]);
      }
      
      else{
        $action = url($args[0]);
      }
      
      array_shift($args);
      
    }
    
    //If the argument is an instance of Url, well, then what? Captain obvious.
    elseif(count($args) > 0 && $args[0] instanceof \dependencies\Url){
      $action = array_shift($args);
    }
    
    //The first argument does not have the format of a url, find our own.
    else
    {
    
      $this->pks()->each(function($pk)use(&$update){
        $update = $pk->is_set();
        return $update;
      });
      
      $action = url("?action={$this->component}/".($update ? 'update' : 'insert')."_".strtolower(preg_replace('~([A-Z])([A-Z][a-z])|([a-z0-9])([A-Z])~', '\1\3_\2\4', $this->model).'/post'));
      
    }
    
    //If there is an argument left, it must be the array of columns.
    if(count($args) > 0){
      $columns = (array) $args[0];
    }
    
    //No columns given.
    else{
      $columns = array();
    }
    
    //Check if there are custom fields to add.
    foreach($columns as $column => $meta)
    {
      
      if(is_array($meta) && array_key_exists('custom_field', $meta) && $meta['custom_field'] === true)
      {
        
        if(!array_key_exists('type', $meta))
          throw new Programmer('Using custom_field, without defining type.');
        
        $info[$column]->type = $meta['type'];
        
      }
      
    }
    
    //Build ze form.
    $form = '<form id="'.$id.'" action="'.$action.'" method="post" class="form">'."\n\n";
    
    //For every value in this node.
    foreach($info as $column => $meta)
    {
      
      $options = Data();
      $value = $this->{$column}->get();
      
      //Skip columns that are not part of the table structure.
      if( ! $info[$column]->is_set()){
        continue;
      }
      
      //Get input type.
      if($info[$column]->type->get() == null)
        trace('null type', $info[$column]->type->get(), $column, $info[$column]->dump());
      $type = array_get(array_search_recursive($info[$column]->type->get(), $field_types), 0);
      
      //Start making html.
      $html = '';

      //Get given data.
      if(array_key_exists($column, $columns))
      {

        $data = data_of($columns[$column]);

        if(is_string($data)){
          $type = $data;
        }

        elseif($data instanceof \Closure){
          $options = array();
          $html = $data($value, $info[$column], $options);
        }

        elseif(is_array($data)){
          $options = $data;
          $type = (array_key_exists('type', $options) ? $options['type'] : $type);
        }

      }

      //Hide primary keys by default.
      else
      {
        // if($info[$column]->key == 'PRI'){
        //   $type = 'hidden';
        // }
      }

      //Create html if we do not already have it.
      if(empty($html) || !is_string($html))
      {

        $label =
          '<label'.(array_key_exists('field_id', $options) ? ' for="'.$options['field_id'].'"' : '').(array_key_exists('accesskey', $options) ? ' accesskey="'.$options['accesskey'].'"' : '').'>'.__(array_key_exists('label', $options) ? $options['label'] : $column, 1).'</label>';

        switch($type)
        {

          case 'hidden': $html =
            '<input'.
            ' name="'.$info[$column]->key().'"'.
            ' type="hidden"'.
            ' value="'.$value.'"'.
            '>';
            break;

          case 'text': $html =
            $label.
            '<input'.
            ' name="'.$info[$column]->key().'"'.
            ' type="text"'.
            ' value="'.$value.'"'.
            (array_key_exists('add_placeholder', $options) && $options['add_placeholder'] === true ? ' placeholder="'.(array_key_exists('name', $options) ? $options['name'] : $column).'"' : '').
            (array_key_exists('required', $options) ? ($options['required'] === true ? ' required' : '') : ($info[$column]->check('null_allowed') ? '' : ' required')).
            (array_key_exists('field_attributes', $options) ? ' '.implode_keys('" ', '="', $options['field_attributes']).'"' : '').
            '>';
            break;

          case 'textarea': $html =
            $label.
            '<textarea'.
            ' name="'.$info[$column]->key().'"'.
            (array_key_exists('required', $options) ? ($options['required'] === true ? ' required' : '') : ($info[$column]->check('null_allowed') ? '' : ' required')).
            '>'.$value.'</textarea>';
            break;

          case 'number': $html =
            $label.
            '<input'.
            ' name="'.$info[$column]->key().'"'.
            ' type="number"'.
            ' value="'.$value.'"'.
            (array_key_exists('required', $options) ? ($options['required'] === true ? ' required' : '') : ($info[$column]->check('null_allowed') ? '' : ' required')).
            '>';
            break;
            
          case 'custom':
            if(!array_key_exists('custom_html', $options))
              throw new Programmer('Custom field type used without defining custom_html option.');
            $html = $label.$options['custom_html'];
            break;
          
        }
        
      }
      
      //Append html to ze form.
      $form .=
        '<div class="ctrlHolder"'.(array_key_exists('wrapper_attributes', $options) ? ' '.implode_keys('" ', '="', $options['wrapper_attributes']).'"' : '').'>'.
        "  $html".
        '</div>'.
        "\n\n";
      
    }
    
    //Append form buttons to ze form.
    $form .= form_buttons();
    
    //Close ze form.
    $form .= '</form>'."\n\n";
    
    //Return ze form.
    return $form;
    
  }
  
  // Store the model to the database.
  public function save()
  {
    
    $this->get_save_data($insert, $data);
    
    //Now either insert or update
    if($insert)
    {
      
      //Create and execute insert query
      $query = tx('Sql')->make_query(
        'INSERT INTO `'.self::model_data('table_name').'` (`'.implode('`, `', array_keys($data)).'`) VALUES('.implode(', ', array_fill(0, count($data), '?')).')',
        $data
      );
      
      tx('Sql')->execute_non_query($query);
      
      //If we have an auto_increment_field, set it to the inserted value.
      if(self::table_data()->auto_increment->get() !== null){
        $this[self::table_data()->auto_increment]->set(tx('Sql')->get_insert_id());
      }
      
    }
    else
    {
      
      //Create and execute update query
      $query = 'UPDATE '.self::model_data('table_name').' SET `'.implode('` = ?, `', array_keys($data)).'` = ? WHERE 1';
      
      foreach(self::table_data()->primary_keys as $primary_key){
        $query .= " AND `$primary_key` = ?";
        $data[] = $this[$primary_key]->get();
      }
      
      $query = tx('Sql')->make_query($query, $data);
      
      tx('Sql')->execute_non_query($query);
      
    }
    
    $this->deleted = false;
    
    return $this;
    
  }

  // Store the model to the database taking into account the hierarchial structure, so setting lft and rgt values and updating siblings
  public function hsave($parent_pks=null, $index=null)
  {

    $parent_pks = data_of($parent_pks);
    $index = data_of($index);

    if(!(array_key_exists('left', self::model_data('hierarchy')) && array_key_exists('right', self::model_data('hierarchy')))){
      throw new \exception\NotFound("Not all hierarchy fields (left and right) have been defined in %s.", get_class($this));
    }

    //get lft and rgt names
    $lft = array_get(self::model_data('hierarchy'), 'left');
    $rgt = array_get(self::model_data('hierarchy'), 'right');

    //get save data
    $this->get_save_data($insert, $data);

    //get new_lft
    if(is_null($parent_pks) && is_null($index)){
      $new_lft = $insert ? 1 : $this->{$lft}->get('int');
    }

    else
    {

      $result = $this->table($this->model)
        ->sk($this->having(self::model_data('secondary_keys'))->as_array())
        ->not(is_null($parent_pks))
          ->success(function($q)use($parent_pks){
            $q->parent_pk($parent_pks)->add_relative_depth();
          })
          ->failure(function($q){
            $q->add_absolute_depth();
          })
        ->max_depth(1)
        ->execute();

      //if there are no siblings
      if($result->is_empty()){
        $new_lft = (is_null($parent_pks)
          ? 1
          : $this->table($this->model)->pk($parent_pks)->execute_single()->{$lft}->get('int') + 1
        );
      }

      //if there are siblings
      else
      {

        if(is_null($index)){
          $new_lft = $result->idx(0)->{$lft}->get('int');
        }

        elseif($index > $result->size()-1){
          $new_lft = $result->idx(-1)->{$lft}->get('int');
        }

        else{
          $new_lft = $result->{$index}->{$lft}->get('int');
        }

      }

    }

    //make secondary key string
    $sk = '';
    foreach(self::model_data('secondary_keys') as $secondary_key){
      $sk .= " AND `$secondary_key` = '".$this->{$secondary_key}."'";
    }

    //insert
    if($insert)
    {

      $size = 1;
      $new_rgt = $new_lft + $size;

      //query 1: create a gap in lft values
      tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$lft` = (`$lft` + $size + 1) WHERE `$lft` >= $new_lft $sk");

      //query 2: create a gap in rgt values
      tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$rgt` = (`$rgt` + $size + 1) WHERE `$rgt` >= $new_lft $sk");

      //set values for insertion
      $data = array_merge($data, array(
        $lft => $new_lft,
        $rgt => $new_rgt
      ));

      //query 3: insert
      tx('Sql')->execute_non_query(tx('Sql')->make_query(
        'INSERT INTO `'.self::model_data('table_name').'`'.
        ' (`'.implode('`, `', array_keys($data)).'`)'.
        ' VALUES('.implode(', ', array_fill(0, count($data), '?')).')'
        , $data
      ));

      //set ai
      if(self::table_data()->auto_increment->get() !== null){
        $this->ai()->set(tx('Sql')->get_insert_id());
      }

    }

    //update
    else
    {

      //restriction
      if((array)$parent_pks == $this->having(self::table_data()->primary_keys->as_array())->map(function($v){return $v;})->as_array()){
        throw new \exception\Restriction('You can not make a node become its own ancestor.');
      }

      $size = $this->{$rgt}->get('int') - $this->{$lft}->get('int');
      $compensate = ($new_lft > $this->{$lft}->get('int') ? -($size+1) : 0); //substract its own size, because the gap is closed before the item is moved
      $new_lft = $new_lft + $compensate;
      $new_rgt = $new_lft + $size;
      $distance = $new_lft - $this->{$lft}->get('int');

      if($new_lft !== $this->{$lft}->get('int'))
      {

        //query 1: temporary "remove" self (and subnodes) by setting the lft/rgt values to negative
        tx('Sql')->execute_non_query(
          "UPDATE `".self::model_data('table_name')."` SET `$lft` = (0-`$lft`), `$rgt` = (0-`$rgt`)".
          " WHERE `$lft` >= ".$this->{$lft}." AND `$rgt` <= ".$this->{$rgt}.$sk
        );

        //query 2: close the gap in lft values
        tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$lft` = (`$lft` - $size - 1) WHERE `$lft` > ".$this->{$lft}.$sk);

        //query 3: close the gap in rgt values
        tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$rgt` = (`$rgt` - $size - 1) WHERE `$rgt` > ".$this->{$rgt}.$sk);

        //query 4: create a gap in lft values
        tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$lft` = (`$lft` + $size + 1) WHERE `$lft` >= $new_lft $sk");

        //query 5: create a gap in rgt values
        tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$rgt` = (`$rgt` + $size + 1) WHERE `$rgt` >= $new_lft $sk");

        //query 6: place item in new gap
        tx('Sql')->execute_non_query("UPDATE `".self::model_data('table_name')."` SET `$lft` = (0-`$lft`+$distance), `$rgt` = (0-`$rgt`+$distance) WHERE `$lft` < 0");

        //unset lft and rgt from update data
        unset($data[$lft], $data[$rgt]);

      }

      //query: update
      $pks = $this->having(self::table_data()->primary_keys->as_array());
      tx('Sql')->execute_non_query(
        "UPDATE `".self::model_data('table_name')."`".
        " SET ".
          Data($data)->map(function($v, $k){
            return "`$k` = ".tx('Sql')->escape($v);
          })->join(', ').
        " WHERE ".
          $pks->map(function($v, $k){
            return "`$k` = $v";
          })->join(' AND ')
      );

    }

    //set values in model
    $this->merge(array(
      $lft => $new_lft,
      $rgt => $new_rgt
    ));

    return $this;

  }

  // Deletes the database row represented by this model.
  public function delete()
  {

    if($this->deleted){
      throw new \exception\Programmer('The row corresponding to this model (instance of %s) has already been deleted.', get_class($this));
    }

    $query = 'DELETE FROM `'.self::model_data('table_name').'` WHERE 1';

    foreach(self::model_data('secondary_keys') as $secondary_key){
      $query .= " AND `$secondary_key` = '".$this->{$secondary_key}."'";
    }

    foreach(self::table_data()->primary_keys as $primary_key){
      $query .= " AND `$primary_key` = '".$this[$primary_key]."'";
    }

    tx('Sql')->execute_non_query($query);

    $this->deleted = true;
    return $this;

  }

  // Deletes the database row taking into account the hierarchial structure, so also deleting children and updating siblings
  public function hdelete()
  {

    if($this->deleted){
      throw new \exception\Programmer('The row corresponding to this model (instance of %s) has already been deleted.', get_class($this));
    }

    if(!(array_key_exists('left', self::model_data('hierarchy')) && array_key_exists('right', self::model_data('hierarchy')))){
      throw new \exception\NotFound("Not all hierarchy fields (left and right) have been defined in %s.", get_class($this));
    }

    //get lft and rgt names
    $lft = array_get(self::model_data('hierarchy'), 'left');
    $rgt = array_get(self::model_data('hierarchy'), 'right');

    //make first query
    $query =
      'DELETE FROM `'.self::model_data('table_name').'` WHERE 1'.
      " AND `".$lft."` >= '".$this->{$lft}."'".
      " AND `".$rgt."` <= '".$this->{$rgt}."'";

    foreach(self::model_data('secondary_keys') as $secondary_key){
      $query .= " AND `$secondary_key` = '".$this->{$secondary_key}."'";
    }

    //execute first query
    tx('Sql')->execute_non_query($query);

    //get gap
    $gap = $this->{$rgt}->get('int') - $this->{$lft}->get('int');

    //make second query
    $query =
      'UPDATE `'.self::model_data('table_name').'`'.
      ' SET'.
      '  `'.$lft.'` = (`'.$lft.'` - '.$gap.' - 1)'.
      ' WHERE 1'.
      '  AND `'.$lft.'` > '.$this->{$lft};

    foreach(self::model_data('secondary_keys') as $secondary_key){
      $query .= " AND `$secondary_key` = '".$this->{$secondary_key}."'";
    }

    //execute second query
    tx('Sql')->execute_non_query($query);

    //make third query
    $query =
      'UPDATE `'.self::model_data('table_name').'`'.
      ' SET'.
      '  `'.$rgt.'` = (`'.$rgt.'` - '.$gap.' - 1)'.
      ' WHERE 1'.
      '  AND `'.$rgt.'` > '.$this->{$rgt};

    foreach(self::model_data('secondary_keys') as $secondary_key){
      $query .= " AND `$secondary_key` = '".$this->{$secondary_key}."'";
    }

    //execute third query
    tx('Sql')->execute_non_query($query);

    $this->deleted = true;
    return $this;

  }

  // Gets the required table information from the database.
  private static function create_table_data()
  {
    
    if(array_key_exists(self::model_data('table_name'), self::$table_data)){
      return;
    }
    
    $target = Data();
    self::$table_data[self::model_data('table_name')] = $target;
    
    $info = tx('Sql')->execute_query('SHOW COLUMNS FROM `'.self::model_data('table_name').'`');
    
    foreach($info as $column)
    {
      
      //Check if it's an auto_increment
      if($column->Extra->get() == 'auto_increment'){
        $target->auto_increment->set($column->Field);
      }
      
      //Check if it's a primary key
      if($column->Key->get() == 'PRI' && $target->primary_keys->keyof($column->Field->get()) === false){
        $target->primary_keys->push($column->Field);
      }
      
      //Create a shortcut.
      $fields = $target->fields[$column->Field];
      
      //Set "null_allowed" to an actual boolean. Silly MySQL..
      switch($column->Null->get()){
        case 'YES': $fields->null_allowed->set(true); break;
        case 'NO': $fields->null_allowed->set(false); break;
      }
      
      //Set some essential information per column
      $fields->merge(array(
        'value' =>  $column->Default->get(),
        'extra' =>  $column->Extra->get(),
        'key' =>    $column->Key->get()
      ));
      
      //Parse attributes
      preg_match('~'.
        '(?:^(?P<type>\w+))'. //type
        '(?:\((?P<arguments>[^\)]+)\))?'. //arguments
        '(?:(?P<extra>(?:\s+\w+)*))'. //other attributes
      '~', $column->Type->get(), $attr_matches);
      
      //Format the arguments.
      $arguments = array();
      $argument_parts = explode("','", $attr_matches['arguments']);
      foreach($argument_parts as $ap)
        $arguments[] = trim($ap, " '");
      $fields->arguments->set($arguments);
      
      //Format the extras.
      $extras = array();
      $extra_parts = explode(' ', trim($attr_matches['extra']));
      foreach($extra_parts as $ep)
        $extras[$ep] = true;
      $fields->merge($extras);
      
      //Add the basic type.
      $fields->type->set($attr_matches['type']);
      
    }

  }

  //helper for save functions
  private function get_save_data(&$insert, &$data)
  {

    //Check wether we need to insert or update.
    $pk = true;
    $insert = false;

    //Start by checking the primary key values are set.
    foreach(self::table_data()->primary_keys as $primary_key){
      if(!$this[$primary_key]->is_set()){
        $pk = false;
      }
    }

    //Next, check if this record exists in the database.
    if($pk)
    {

      $query = 'SELECT COUNT(*) FROM `'.self::model_data('table_name').'` WHERE 1';
      foreach(self::table_data()->primary_keys as $primary_key){
        $query .= ' AND `'.$primary_key.'`=\''.$this[$primary_key].'\'';
      }

      if(tx('Sql')->execute_scalar($query)->get('int') < 1){
        $insert = true;
      }

    }

    //No primary keys? We will have to insert.
    else{
      $insert = true;
    }

    //only data that can be stored to the database shall be stored
    $data = array_intersect_key($this->get(), self::table_data()->fields->get());

    //normalize data array
    foreach($data as $k => $v)
    {
      
      $v = ($v->is_leafnode() ? $v->get() : $v->serialized());
      
      try{
        $data[$k] = $this->validate_column($k, $v);
        if($data[$k] === 'NULL')
          $this->{$k}->un_set();
      }
      
      catch(\exception\Validation $e){
        $e->key($k);
        $e->value($v);
        throw $e;
      }
      
    }

  }

  //validates a $value to be inserted into $column_name, returns validated $value
  private function validate_column($column_name, $value)
  {

    $info = self::table_data()->fields->{$column_name};

    //validate NULL
    if(is_null($value) || $value === 'NULL')
    {

      if(!$info->check('null_allowed'))
      {
        
        if($info->value->is_empty() && $info->key->get() != 'PRI'){
          throw new \exception\Validation('Value may not be NULL for insertion into %s.', $column_name);
        }
      
      }
      
      $value = 'NULL';

    }

    //validate varchar
    elseif($info->type->get() == 'varchar' || $info->type->get() == 'char')
    {

      if(mb_strlen($value, 'UTF-8') > $info->arguments[0]->get()){
        throw new \exception\Validation('The length of the value is longer than the allowed maximum of %s characters for insertion into %s.', $info->arguments[0], $column_name);
      }

    }

    //validate integers
    elseif($info->type->get() == 'tinyint' || $info->type->get() == 'smallint' || $info->type->get() == 'mediumint' || $info->type->get() == 'int' || $info->type->get() == 'bigint')
    {

      if(!is_numeric($value)){
        throw new \exception\Validation('Given "%s" is not a valid number for insertion into %s.', $value, $column_name);
      }

      $value = (int) $value;
      $byte = '11111111';

      switch($info->type->get()){
        case 'tinyint': $bits = $byte; break;
        case 'smallint': $bits = str_repeat($byte, 2); break;
        case 'mediumint': $bits = str_repeat($byte, 3); break;
        case 'int': $bits = str_repeat($byte, 4); break;
        case 'bigint': $bits = str_repeat($byte, 8); break;
      }

      if($info->check('unsigned')){
        $max = bindec($bits);
        $min = 0;
      }

      else{
        $bits = substr($bits, 1);
        $max = bindec($bits)-1;
        $min = -bindec($bits);
      }


      if($value > $max){
        throw new \exception\Validation('The database can not store numbers higher than %s for insertion into %s.', $max, $column_name);
      }

      if($value < $min){
        throw new \exception\Validation('The database can not store numbers below %s for insertion into %s.', $min, $column_name);
      }

    }

    //validate boolean
    elseif($info->type->get() == 'bit' && $info->arguments[0]->get() == 1)
    {
      
      if(is_numeric($value)){
        $value = (($value > 0) ? 1 : 0);
      }

      elseif(is_bool($value)){
        $value = (int) $value;
      }

      elseif(is_string($value))
      {

        $value = strtolower($value);
        switch($value)
        {

          case 'true':
          case 'yes':
            $value = 1;
            break;

          case 'false':
          case 'no':
            $value = 0;
            break;

          default:
            throw new \exception\Validation('This is a yes or no question. You can not answer "%s".', $value);

        }

      }

      else{
        throw new \exception\Validation('No valid boolean given (%s) for insertion into %s.', $value, $column_name);
      }

    }

    //validate bits
    elseif($info->type->get() == 'bit')
    {

      if(!is_numeric($value)){
        throw new \exception\Validation('You must give a number for insertion into %s. You gave "%s".', $column_name, $value);
      }

      $value = is_string($value) ? (preg_match('~^[01]+$~', $value) == 1 ? $value : decbin((int)$value)) : decbin((int)$value);

      if(strlen($value) > $info->arguments[0]->get()){
        throw new \exception\Validation('Maximum number of bits (%s) for insertion into %s exceeded (%s).', $info->arguments[0]->get(), $column_name, strlen($value));
      }

    }

    //validate precise numbers
    elseif($info->type->get() == 'float' || $info->type->get() == 'real' || $info->type->get() == 'double')
    {

      if(!is_numeric($value)){
        throw new \exception\Validation('Given "%s" is not a valid number for insertion into %s.', $value, $column_name);
      }

    }

    //validate decimal
    elseif($info->type->get() == 'decimal' || $info->type->get() == 'numeric')
    {

      if(!is_numeric($value)){
        throw new \exception\Validation('Given "%s" is not a valid number for insertion into %s.', $value, $column_name);
      }

    }

    //validate dates
    elseif($info->type->get() == 'date' || $info->type->get() == 'datetime' || $info->type->get() == 'timestamp' || $info->type->get() == 'time' || $info->type->get() == 'year')
    {

      switch($info->type->get()){
        case 'date': $regex = '(?P<Y>\d{4})-(?P<m>\d{2})-(?P<d>\d{2})'; break;
        case 'timestamp':
        case 'datetime': $regex = '(?P<Y>\d{4})-(?P<m>\d{2})-(?P<d>\d{2}) (?P<H>\d{2}):(?P<i>\d{2}):(?P<s>\d{2})'; break;
        case 'time': $regex = '(?P<H>\d{2}):(?P<i>\d{2}):(?P<s>\d{2})'; break;
        case 'year': $regex = '(?:(?P<Y>\d{4})|(?P<y>\d{2}))'; break;
      }
      
      if(is_numeric($value)){
        switch($info->type->get()){
          case 'date': $value = date('Y-m-d', $value); break;
          case 'timestamp':
          case 'datetime': $value = date('Y-m-d H:i:s', $value); break;
          case 'time': $value = date('H:i:s', $value); break;
          case 'year': $value = date('Y', $value); break;
        }
      }
      
      if(preg_match("~^$regex$~", $value, $matches) == 1){
        $Y = array_key_exists('Y', $matches) ? $matches['Y'] : null;
        $y = array_key_exists('y', $matches) ? $matches['y'] : null;
        $m = array_key_exists('m', $matches) ? $matches['m'] : null;
        $d = array_key_exists('d', $matches) ? $matches['d'] : null;
        $H = array_key_exists('H', $matches) ? $matches['H'] : null;
        $i = array_key_exists('i', $matches) ? $matches['i'] : null;
        $s = array_key_exists('s', $matches) ? $matches['s'] : null;
        $U = array_key_exists('U', $matches) ? $matches['U'] : null;
      }

      else
      {

        $value = strtotime($value);

        if($value === false){
          throw new \exception\Validation('Value has an invalid date format for insertion into %s.', $column_name);
        }

        else{
          $Y = date('Y', $value);
          $y = date('y', $value);
          $m = date('m', $value);
          $d = date('d', $value);
          $H = date('H', $value);
          $i = date('i', $value);
          $s = date('s', $value);
          $U = date('U', $value);
        }

      }

      switch($info->type->get())
      {
        
        case 'timestamp':
        case 'datetime':
        case 'time':
          
          if($H < 0 || $H > 23){
            throw new \exception\Validation('Hours must be between 0 and 23 for insertion into %s.', $column_name);
          }
          
          if($i < 0 || $i > 59){
            throw new \exception\Validation('Minutes must be between 0 and 59 for insertion into %s.', $column_name);
          }
          
          if($s < 0 || $s > 59){
            throw new \exception\Validation('Seconds must be between 0 and 59 for insertion into %s.', $column_name);
          }
          
          if($info->type->get() === 'time'){
            break;
          }
        
        
        case 'date':
          
          if($Y == 0 && $m == 0 && $d == 0) break;
          
          if($Y > 9999){
            throw new \exception\Validation('The database field "%s" can not store years after the year 9999.', $column_name);
          }
          
          if($m < 1 || $m > 12){
            throw new \exception\Validation('Months must be between 01 and 12 for insertion into %s.', $column_name);
          }
          
          if($d < 1 || $d > 31){
            throw new \exception\Validation('Days must be between 01 and 31 for insertion into %s.', $column_name);
          }
          
          break;
        
      }
      
      switch($info->type->get()){
        case 'date': $value = "$Y-$m-$d"; break;
        case 'timestamp':
        case 'datetime': $value = "$Y-$m-$d $H:$i:$s"; break;
        case 'time': $value = "$H:$i:$s"; break;
        case 'year': $value = is_null($Y) ? $y: $Y; break;
      }
      
    }
    
    //validate enum
    elseif($info->type->get() == 'enum')
    {
      
      if($info->arguments->keyof($value) === false){
        throw new \exception\Validation('Allowed values are \'%s\' for insertion into %s.', $info->arguments->join("', '"), $column_name);
      }
      
    }
    
    //validate set
    elseif($info->type->get() == 'set')
    {
      
      $values = Data($value)->split(',')->trim()->as_array();
      
      foreach($values as $key => $val)
      {
        
        if($info->arguments->keyof($value) === false){
          throw new \exception\Validation('Allowed values are \'%s\' for insertion into %s.', $info->arguments->join("', '"), $column_name);
        }
        
        $values[$key] = tx('Sql')->escape($val);
        
      }
      
      $value = implode(',', $values);
      
    }
    
    return $value;
    
  }
  
  // ORM helper function
  public function table($model_name){
    return tx('Sql')->table($this->component, $model_name);
  }
  
  protected function refresh_labels()
  {
    
    //Start from scratch.
    $labels = array();
    
    //The default is to ucfirst all the validation rule keys.
    foreach(array_keys(static::$validate) as $key){
      $labels[$key] = ucfirst(str_replace('_', ' ', $key));
    }
    
    //Override and compliment those labels with the protected static values.
    //For example to use a custom title or to add a label for something without validation.
    $labels = array_merge($labels, static::$labels);
    
    //Set these labels.
    static::$generatedLabels = $labels;
    
  }
  
  //Gets the field labels, pretty labels by default.
  //If $originals is true, returns the table column names.
  public function labels($originals=false)
  {
    
    $this->refresh_labels();
    return $originals ? array_keys(static::$generatedLabels) : static::$generatedLabels;
    
  }
  
  public function relation_preferences()
  {
    return static::$relation_preferences;
  }
  
  /**
   * Validates the whole model, based on static validation rules.
   * Options:
   *    array $rules - Defines extra rules per field name.
   *    boolean $force_create - Tries to ignore the PK if it has an auto_increment attribute. Otherwise throws programmer exception.
   *    boolean $nullify - When set to true, fields that are valid but empty will be set to NULL (default: false).
   */
  public function validate_model($options=array())
  {
    
    /*
      Workaround for PHP problem.
      Loading other models while running this function breaks the static:: call.
      Therefore keep a reference to the value for the length of this function at least.
    */
    $generatedLabels = $this->labels();
    
    //Allow additional rules to be prepended.
    $ruleSet = array_merge_recursive(
      (isset($options['rules']) ? $options['rules'] : array()),
      static::$validate
    );
    
    //Check if labels are missing for these rules.
    if(isset($options['rules'])){
      foreach($options['rules'] as $col => $rules){
        if(!array_key_exists($col, $generatedLabels)){
          $generatedLabels[$col] = ucfirst(str_replace('_', ' ', $col));
        }
      }
    }
    
    //Filter out what we don't need.
    $data = $this->having(array_keys($generatedLabels));
    
    //Do we nullify?
    $nullify = isset($options['nullify']) && $options['nullify'] === true;
    
    $table_data = $this->table_data();
    
    //See if we need to remove the ID.
    if(isset($options['force_create']) && $options['force_create'] === true){
      
      $keys = $table_data->primary_keys->as_array();
      $first_key = array_shift($keys);
      
      //If we have one PK that is auto_increment.
      if($table_data->auto_increment->is_set() &&
        $table_data->primary_keys->size() == 1 &&
        $first_key === $table_data->auto_increment->get())
      {
        
        //Remove the pk data and validation rules that go with it.
        $data->{$first_key}->set('NULL');
        unset($ruleSet[$first_key]);
        
      }
      
      //This option should not be set otherwise.
      else{
        throw new \exception\Programmer('Tried to force_create on model "%s" where PK is not auto_increment', $this->model());
      }
      
    }

    //Iterate over each rule and collect validation exceptions from it.
    $validationExceptions = array();
    foreach($ruleSet as $key => $rules)
    {
      
      try{
        
        $data->{$key}->validate($generatedLabels[$key], $rules);
        
        if($nullify && $data->{$key}->is_empty() && $table_data->fields[$key]->check('null_allowed')){
          $data->{$key}->set('NULL');
        }
        
      }
      
      catch(\exception\Validation $ex){
        $validationExceptions[] = $ex;
      }
      
    }
    
    //See if things went wrong.
    if(count($validationExceptions) > 0){
      
      $ex = new \exception\ModelValidation('There were validation errors');
      $ex->set_validation_errors($validationExceptions);
      throw $ex;
      
    }
    
    //Store data.
    $this->set($data);
    
    return $this;
    
  }
  
  public function render_form(&$id, $action, array $options=array())
  {
    
    $builder = new \dependencies\forms\FormBuilder($this, array(
      'fields' => isset($options['fields']) ? $options['fields'] : null,
      'relations' => isset($options['relations']) ? $options['relations'] : null,
    ));
    
    $id = $builder->id();
    
    $options = array_merge($options, array(
      'action' => $action
    ));
    
    $builder->render($options);
    
  }
  
}
