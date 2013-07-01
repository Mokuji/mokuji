<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Table extends Successable
{

  private
    $component=false,
    $model=false,

    $working_model,
    $models=array(),

    $select=array(),
    $distinct=false,
    $hierarchy=array(),
    $from=array(),
    $joins=array(),

    $where = '',
    $group=array(),
    $having = '',
    $order=array(),
    $limit,
    
    $applied_sks=array();


  ###
  ###  SYSTEM
  ###

  // Constructor setting the first model to use.
  public function __construct($component, $model, &$id=null, &$models=null)
  {

    $this->component = $component;

    if(!is_null($models)){
      $this->models =& $models;
    }

    $this->add($model, $id);

  }

  // Fill the referenced variable with the name of the primary model for retrieval (mainly useful in subqueries)
  public function __invoke(&$id=null)
  {
    $id = $this->model;
    return $this;
  }



  ###
  ###  HIGH LEVEL PUBLIC FUNCTIONS
  ###
  
  //Call a helper function to do complex table operations.
  public function helper($component, $name)
  {
    
    $args = func_get_args();
    $component = array_shift($args);
    $name = array_shift($args);
    
    tx('Component')->helpers($component)->_call('table__'.$name, array_merge(array($this), $args));
    return $this;
    
  }
  
  //Make a distinct select statement (if that's not already the case).
  public function distinct($value=true)
  {
    $this->distinct = $value !== false;
    return $this;
  }
  
  // filter by primary keys
  public function pk()
  {

    $values = array_flatten(func_get_args());
    $working_model = $this->models[$this->working_model]['path'];
    $pk_fields = $working_model::table_data()->primary_keys->as_array();

    //trace($pk_fields);

    if(count($values) !== count($pk_fields)){
      throw new \exception\InvalidArgument('The number of values given does not match the amount of primary key fields. The primary key fields are: %s. You gave %s values.', implode(', ', $pk_fields), func_num_args());
      return $this;
    }

    foreach($pk_fields as $pk){
      $this->where($pk, current($values));
      next($values);
    }

    return $this;

  }

  //filter by secondary keys
  public function sk()
  {
    
    $values = array_flatten(func_get_args());
    $working_model = $this->models[$this->working_model]['path'];
    $sk_fields = $working_model::model_data('secondary_keys');
    
    if(count($values) !== count($sk_fields)){
      throw new \exception\InvalidArgument('The number of values given does not match the amount of primary key fields. The primary key fields are: %s. You gave %s values.', implode(', ', $pk_fields), func_num_args());
      return $this;
    }
    
    foreach($sk_fields as $sk){
      $this->applied_sks[$sk] = current($values);
      if(!is_null($sk)) $this->where($sk, current($values));
      next($values);
    }
    
    return $this;
    
  }

  /**
   * Filter by parent' primary key assuming a hierarchical table structure.
   * 
   * @param boolean $include_parent Whether to include the parent node that matches the
   *                                given primary key(s). This parameter can be omitted
   *                                and will default to false.
   * 
   * @param integer|array $value The value for the primary key to match against, or array
   *                             of primary keys to match against shared primary key.
   * 
   * @param integer ... The above parameter can be repeated indefinitely in order to
   *                    achieve providing values for every primary key in case of shared
   *                    primary keys.
   *
   * @return self Chaining enabled.
   */
  public function parent_pk()
  {
    
    //We start by assuming that every given argument is a primary key.
    $values = array_flatten(func_get_args());
    
    //If the first given value is a boolean, steal it for the include_parent option.
    $include_parent = (count($values) > 0 && is_bool($values[0]) ? array_shift($values) : false);
    
    //Make sure we've got hierarchy enabled.
    $this->add_hierarchy();
    
    //Get info about the model that serves as parent for the hierarchy.
    $parent_model = $this->models[$this->hierarchy[$this->working_model]['parent']];
    
    //Get the name of the class.
    $model = $parent_model['path'];
    
    //Get primary keys from this model.
    $pk_fields = $model::table_data()->primary_keys->as_array();
    
    //Make sure the amount of primary keys matches the given amount.
    if(count($values) !== count($pk_fields)){
      throw new \exception\InvalidArgument(
        'The number of values given does not match the amount of primary key fields. '.
        'The primary key fields are: %s. You gave %s values.',
        implode(', ', $pk_fields), func_num_args()
      );
    }
    
    //Iterate the primary keys.
    foreach($pk_fields as $pk)
    {
      
      //The model' primary key must be equal to its respective given value.
      $this->where("{$parent_model['id']}.$pk", current($values));
      
      //If we don't include the parent, we add another rule:
      //The primary key of the main model can not be one the given value.
      if(!$include_parent){
        $this->where("{$this->working_model}.$pk", '!', current($values));
      }
      
      //Add primary key information to the hierarchy data.
      $this->hierarchy[$this->working_model]['root_pks'][$pk] = current($values);
      
      //Move the cursor.
      next($values);
      
    }
    
    //The root of the hierarchy will now be equal to the parent of the hierarchy.
    $this->hierarchy[$this->working_model]['root'] = $this->hierarchy[$this->working_model]['parent'];
    
    //Enable chaining.
    return $this;

  }

  /**
   * Make this query hierarchical.
   * 
   * Adds stuff to the query needed to use a hierarchy based on hierarchy information
   * available in the working model.
   * 
   * @return self Chaining enabled.
   */
  public function add_hierarchy()
  {
    
    //Get the ID of the working model.
    $id = $this->working_model;
    
    //Do nothing if this ID is already used for a hierarchy.
    if(array_key_exists($id, $this->hierarchy)){
      return $this;
    }
    
    //Get the class name of the working model.
    $model = $this->models[$id]['path'];
    
    //Make sure the model has hierarchy fields defined.
    if(!(array_key_exists('left', $model::model_data('hierarchy')) && array_key_exists('right', $model::model_data('hierarchy')))){
      throw new \exception\NotFound("Not all hierarchy fields (left and right) have been defined in %s.", $model);
    }
    
    //Store hierarchy info in the hierarchy data for the working model.
    $this->hierarchy[$id] = $model::model_data('hierarchy');
    
    //Add the working model to the FROM clause a second time to use as a parent node.
    $this->from($this->models[$id]['name'], $parent);
    
    //Store the parent node in the hierarchy data.
    $this->hierarchy[$id]['parent'] = $parent;
    
    //Create the filters that make this a hierarchical query.
    $this->where(tx('Sql')->conditions()
    ->add('left', array($this->hierarchy[$id]['left'], '>=', "$parent.{$this->hierarchy[$id]['left']}"))
    ->add('right', array($this->hierarchy[$id]['right'], '<=', "$parent.{$this->hierarchy[$id]['right']}"))
    ->combine('h', array('left', 'right'))
    ->utilize('h'));
    
    //Get the name of the main model.
    $pmodel = $this->models[$this->model]['path'];
    
    //Group the main model by primary keys.
    $this->workwith($this->model)
    ->group($pmodel::table_data()->primary_keys->as_array())
    ->workwith($id);
    
    //Order the results by hierarchical structure.
    $this->order($this->hierarchy[$id]['left']);
    
    //Enable chaining.
    return $this;
    
  }

  // add a depth field based on hierarchy
  public function add_absolute_depth($as='abs_depth')
  {
    
    $this->add_hierarchy();

    $model_name = $this->models[$this->working_model]['name'];
    $model = $this->models[$this->working_model]['path'];
    $hierarchy = $model::model_data('hierarchy');
    $pks = $model::table_data()->primary_keys->as_array();
    $sks = $model::model_data('secondary_keys');
    
    $this->subquery($sq, $this->component, $model_name);

    $sq($ancestors)
      ->select("COUNT(*)", 'depth')
      ->add($model_name, $leaf)
      ->where("$ancestors.{$hierarchy['left']}", '<=', $hierarchy['left'])
      ->where("$ancestors.{$hierarchy['right']}", '>=', $hierarchy['right']);

    foreach($pks as $pk){
      $sq->group($pk);
      $sq->select($pk, 'leaf_'.$pk);
    }
        
    foreach($sks as $sk)
    {
      if($this->applied_sks[$sk]){
        $sq->where("$ancestors.$sk", $this->applied_sks[$sk]);
      }
    }

    $this->from($sq, $id);
    $this->select("$id.depth", $as);

    foreach($pks as $k => $pk){
      $this->pk("$id.leaf_$pk");
    }
    
    $this->hierarchy[$this->working_model]['abs_depth'] = $id;

    return $this;

  }

  // add a depth field based on hierarchy
  public function add_relative_depth($as='rel_depth')
  {

    $this->add_hierarchy();

    if(!array_key_exists('root', $this->hierarchy[$this->working_model])){
      throw new \exception\Restriction('Can only add a relative depth after a parent has been appointed as rootnode. Use ->parent_pk() to do this.');
    }

    $model_name = $this->models[$this->hierarchy[$this->working_model]['root']]['name'];
    $model = $this->models[$this->hierarchy[$this->working_model]['root']]['path'];
    $hierarchy = $model::model_data('hierarchy');
    $pks = $model::table_data()->primary_keys->as_array();

    $this->subquery($sq, $this->component, $model_name);

    $sq($ancestors)
      ->select("COUNT(*)", 'depth')
      ->add($model_name, $leaf)
      ->where("$ancestors.{$hierarchy['left']}", '<=', $hierarchy['left'])
      ->where("$ancestors.{$hierarchy['right']}", '>=', $hierarchy['right'])
      ->add($model_name, $parent)
      ->where("$ancestors.{$hierarchy['left']}", '>', $hierarchy['left'])
      ->where("$ancestors.{$hierarchy['right']}", '<', $hierarchy['right']);
    foreach($this->hierarchy[$this->working_model]['root_pks'] as $pk=>$val){
      $sq->where($pk, $val);
    }

    foreach($pks as $pk){
      $sq->group("$leaf.$pk");
      $sq->select("$leaf.$pk", "leaf_$pk");
      //$sq->select("$parent.$pk", "parent_$pk");
    }

    $this->from($sq, $id);
    $this->select("$id.depth", $as);

    foreach($pks as $k => $pk){
      $this->pk("$id.leaf_$pk");
      //$this->pk("$id.parent_$pk");
    }

    $this->hierarchy[$this->working_model]['rel_depth'] = $id;

    return $this;

  }

  // exclude all nodes with a depth greater than given value
  public function max_depth($gt)
  {

    $this->add_hierarchy();

    if(array_key_exists('rel_depth', $this->hierarchy[$this->working_model])){
      $d = $this->hierarchy[$this->working_model]['rel_depth'];
    }

    elseif(array_key_exists('abs_depth', $this->hierarchy[$this->working_model])){
      $d = $this->hierarchy[$this->working_model]['abs_depth'];
    }

    else{
      throw new \exception\Programmer("You must first register a depth field before adding a max depth.");
    }

    $this->where("{$d}.depth", '<=', $gt);

    return $this;

  }

  // Sets join type to INNER
  public function inner()
  {
    return $this->set_jointype('INNER');
  }

  // Sets join type to LEFT
  public function left()
  {
    return $this->set_jointype('LEFT');
  }

  // Sets join type to RIGHT
  public function right()
  {
    return $this->set_jointype('RIGHT');
  }

  // give a names of filters that when set are added to the WHERE clause
  public function filter()
  {

    if(func_num_args() == 1 && is_array(func_get_arg(0)))
    {

      foreach(func_get_arg(0) as $filter => $column){
        call_user_func(array($this, 'filter'), $filter, $column);
      }

    }

    elseif(func_num_args() == 2 && is_string(func_get_arg(0)))
    {

      $filter = tx('Data')->filter($this->component)->{func_get_arg(0)};

      if($filter->is_set()){
        $this->where(func_get_arg(1), $filter);
      }

    }

    else{
      throw new \exception\InvalidArgument('The ->filter() function accepts one or two arguments, an array containing filters or a filter name and matching column name.');
    }

    return $this;

  }



  ###
  ###  LOW LEVEL PUBLIC FUNCTIONS
  ###

  // Add a model and make it the working model
  public function add($model, &$id=null)
  {
    $this->from($model, $id);
    $this->workwith($id);
    return $this;
  }

  // Set the working model
  public function workwith($id)
  {

    if(!array_key_exists($id, $this->models)){
      throw new \exception\NotFound("Failed to set working model to '%s'. No model with that identifier found.", $id);
      return $this;
    }

    $this->working_model = $id;
    return $this;

  }

  // Adds a column to the SELECT clause
  public function select($content, $as=null)
  {

    if(is_null($as)){
      $this->select[$content] = $this->prepare($content);
    }

    else
    {

      if(array_key_exists($as, $this->select)){
        throw new \exception\Restriction("Alias '%s' already in use.", $as);
      }

      $this->select[$as] = $this->prepare($content);

    }

    return $this;

  }

  // Add a model to the FROM clause
  public function from($model, &$id=null)
  {

    $info = $this->get_model_info($model);
    $id = $info['id'];

    // set primary model
    if($this->model === false){
      $this->model = $id;
    }

    $this->models[$id] = $info;
    $this->from[] = array('model'=>$id);
    return $this;

  }

  // Join a foreign model
  public function join($model_name, &$id=null, $join_conditions=null)
  {
    
    raw($model_name);
    
    //Check for proper conditions.
    if($join_conditions && !$join_conditions instanceof \Closure){
      throw new \exception\InvalidArgument('The join conditions must be a Closure');
    }
    
    // initial join is always on the working model
    $target = $this->models[$this->working_model];
    
    //In case of a join condition, we do a direct join (not several hops).
    if($join_conditions){
      
      $src = $target;
      
      //When we have join conditions, we can use the __CURRENT__ reference.
      if($model_name === '__CURRENT__'){
        $target = $this->get_model_info("{$target['component']}.{$target['name']}");
      }
      else{
        $target = $this->get_model_info($model_name);
      }
      
      //Add target to the models.
      $this->models[$target['id']] = $target;
      
      //collect join information
      $conditions = tx('Sql')->conditions();
      $join_conditions($src['id'], $target['id'], $conditions);
      $info = array(
        'model' => $target['id'],
        'conditions' => $conditions
      );
      
      //add the new information to out global join array so it can be used to build the query with
      $this->joins[$src['id']][] = $info;
      
      //set the &$id to the last target id
      $id = $target['id'];
      
      return $this;
      
    }
    
    //we keep following the directions the models give us, until the right model has been joined
    do
    {

      //reset jointype
      $join_type = null;

      //do we have a relation to the foreign model?
      if(!array_key_exists($model_name, $target['relations'])){
        throw new \exception\NotFound("No relations to %s have been defined in %s. Join failed.", $model_name, $target['path']);
      }

      //is it in the right format?
      if(!(is_string(key($target['relations'][$model_name])) && is_string(current($target['relations'][$model_name])))){
        throw new \exception\InvalidArgument('Relations to %s defined in %s have an invalid format.', $model_name, $target['path']);
      }
      
      //get local information
      $local_info = $this->get_column_info($target['id'].'.'.key($target['relations'][$model_name]));

      //get foreign information
      $foreign_array = explode('.', current($target['relations'][$model_name]));
      $foreign_array_count = count($foreign_array);

      //validate foreign field
      if($foreign_array_count < 2 || $foreign_array_count > 3){
        throw new \exception\InvalidArgument(
          'The foreign column in the relation to %s defined in %s has an invalid format. Expected format '.
          'is: "[ComponentName.]ModelName.column_name". Given value is: "%s"', $model_name, $target['path'], current($target['relations'][$model_name])
        );
      }

      //check if a jointype was provided
      $join_type = next($target['relations'][$model_name]);

      //Set new target.
      //Either ComponentName.ModelName or ModelName.
      $target = $this->get_model_info($foreign_array_count == 3 ? $foreign_array[0].'.'.$foreign_array[1] : $foreign_array[0]);
      
      //check if the foreign model is the same as the local model
      if($local_info['model'] === $target['id']){
        throw new \exception\Programmer("A connection to %s has been defined in %s using itself as foreign model. Not good.", $model_name, $this->models[$local_info['model']]['path']);
      }

      //add the new target to our models
      $this->models[$target['id']] = $target;

      //get information about the foreign column
      $foreign_info = $this->get_column_info($target['id'].'.'.$foreign_array[$foreign_array_count == 3 ? 2 : 1]);

      //collect join information
      $info = array(
        'model' => $foreign_info['model'],
        'local' => $this->prepare_column($local_info),
        'foreign' => $this->prepare_column($foreign_info)
      );

      //add join type if it was set
      if(is_string($join_type)){
        if(substr($join_type, -5) != ' JOIN'){
          $join_type .= ' JOIN';
        }
        $info['type'] = $join_type;
      }

      //add the new information to out global join array so it can be used to build the query with
      $this->joins[$local_info['model']][] = $info;

    }
    while($target['name'] != $model_name);

    //set the &$id to the last target id
    $id = $target['id'];
    
    return $this;

  }

  // Sets join type for the latest join()
  public function set_jointype($type)
  {

    if(count($this->joins) < 1){
      throw new \exception\Programmer('Can not set jointype of nonexistant join.');
      return $this;
    }

    $keys = array_keys($this->joins);
    $last_join_model = array_pop($keys);
    $keys = array_keys($this->joins[$last_join_model]);
    $last_join = array_pop($keys);

    $type = ucfirst($type);

    if(substr($type, -5) != ' JOIN'){
      $type .= ' JOIN';
    }

    $this->joins[$last_join_model][$last_join]['type'] = $type;

    return $this;

  }

  // The where function filters data for us
  public function where()
  {

    $where = call_user_func_array(array($this, 'whaving'), func_get_args());
    if($where !== false) $this->where .= " AND $where";

    return $this;

  }

  // Group by (column [, 'ASC'|'DESC'])
  public function group($column, $direction=false)
  {
    raw($column, $direction);
    $this->group = array_merge($this->group, $this->grourder($column, $direction));
    return $this;
  }

  // Filters for groups. Only to be used in combination with a group function.
  public function having()
  {

    $having = call_user_func_array(array($this, 'whaving'), func_get_args());
    if($having !== false) $this->having .= " AND $having";

    return $this;

  }

  // Order by (column [, 'ASC'|'DESC'])
  public function order($column, $direction=false)
  {
    raw($column, $direction);
    $this->order = array_merge($this->order, $this->grourder($column, $direction));
    return $this;
  }

  // Set limit (amount_of_rows [, offset])
  public function limit($rowcount, $offset=null)
  {

    raw($rowcount, $offset);

    if(!is_numeric($rowcount)){
      throw new \exception\InvalidArgument('Expecting $rowcount to be numeric. "%s" of type %s given.', $rowcount, gettype($rowcount));
    }

    $this->limit = "$rowcount".(is_int($offset) ? " OFFSET $offset" : '');

    return $this;

  }

  // Execute gathered conditions as query and return resultset
  public function execute($as=null)
  {

    if(is_string($as))
    {

      if(!array_key_exists($as, $this->models)){
        throw new \exception\NotFound("Failed to execute as '%s'. No model with that identifier found.", $as);
        return false;
      }

      $as = $this->models[$as];

    }

    else{
      $as = $this->models[$this->model];
    }

    $result = tx('Sql')->query($this->query("`{$as['id']}`.*"));
    $model = $as['path'];

    return new \dependencies\Resultset($result, $model);

  }

  // Count the amount of rows that would be returned by the query
  public function count()
  {
    
    return tx('Sql')->execute_scalar("SELECT COUNT(*) FROM (".$this->query("`{$this->model}`.*").") as WouldYouBeSoKindAsToCountMyRecords")
      ->is('empty', function(){return 0;});
    
  }

  // execute the query and return the first model in the resultset only
  public function execute_single($as=null)
  {

    $this->limit(1);
    $result = $this->execute($as);
    return $result->idx(0);

  }

  // print the query like it would be when executed (for debugging purposes)
  public function write($as=null)
  {
    
    if(is_string($as))
    {

      if(!array_key_exists($as, $this->models)){
        throw new \exception\NotFound("Failed to execute as '%s'. No model with that identifier found.", $as);
        return false;
      }

      $as = $this->models[$as];

    }

    else{
      $as = $this->models[$this->model];
    }

    echo $this->query("`{$as['id']}`.*");
    return $this;

  }

  // deletes the matching rows from the database
  public function delete($model_name = null)
  {

    throw new \exception\Deprecated('Table::delete()');

    $model_name = (empty($model_name) ? $this->models[$this->working_model]['name'] : $model_name);
    
    $from = 'FROM';
    $d = ' ';
    
    foreach($this->from as $val)
    {
      
      $from .= $d.$this->models[$val['model']]['table'];
      $join = $val['model'];
      
      while(array_key_exists($join, $this->joins))
      {
        
        foreach($this->joins[$join] as $join_info)
        {
          
          if(!array_key_exists('type', $join_info)){
            $join_info['type'] = 'LEFT JOIN';
          }
          
          $from .=
            " {$join_info['type']} {$this->models[$join_info['model']]['table']} AS `{$this->models[$join_info['model']]['id']}`".
            " ON {$join_info['local']} = {$join_info['foreign']}";
          
        }
        
        $join = $join_info['model'];
        
      }
      
      $d = ', ';
      
    }
    
    $query =
      'DELETE '.$from.
      ' WHERE 1'.$this->where;
    // if(count($this->group) > 0) $query .=
      // ' GROUP BY '.implode(', ', $this->group).
      // ' HAVING 1'.$this->having;
    // if(count($this->order) > 0) $query .=
      // ' ORDER BY '.implode(', ', $this->order);
    // if(!empty($this->limit)) $query .=
      // ' LIMIT '.$this->limit;

    echo $query;
    tx('Sql')->execute_non_query($query);

  }

  // creates a new query in the context of this one
  public function subquery(&$q)
  {

    $args = func_get_args();
    array_shift($args);

    switch(count($args)){

      //only a model name has been given
      case 1:
        $component = $this->component;
        $model = $args[0];
        $builder = null;
        break;

      case 2:

        //a model name and a builder have been given
        if($args[1] instanceof \Closure){
          $component = $this->component;
          $model = $args[0];
          $builder = $args[1];
        }

        //a model name and component name have been given
        else{
          $component = $args[0];
          $model = $args[1];
          $builder = null;
        }

        break;

      //a model name, component name and builder have been given
      case 3:
        $component = $args[0];
        $model = $args[1];
        $builder = $args[2];
        break;
    }

    $q = new Table($component, $model, $id, $this->models);

    if(is_callable($builder)){
      $builder($q);
    }

    return $this;

  }


  ###
  ###  LOW LEVEL PRIVATE FUNCTIONS
  ###

  // create the query
  public function query($all=null)
  {

    if(is_null($all)){
      $select = 'SELECT '.($this->distinct ? 'DISTINCT ' : '').current($this->select);
    }

    else
    {

      $select = 'SELECT '.($this->distinct ? 'DISTINCT ' : '').$all;

      foreach($this->select as $as => $content)
      {

        $select .= ", $content";

        if(is_string($as)){
          $select .= " AS `$as`";
        }

      }

    }

    $from = 'FROM';
    $d = ' ';

    foreach($this->from as $val)
    {

      $from .= $d.$this->models[$val['model']]['table']." AS `{$val['model']}`";
      $join = $val['model'];

      while(array_key_exists($join, $this->joins))
      {

        foreach($this->joins[$join] as $join_info)
        {

          if(!array_key_exists('type', $join_info)){
            $join_info['type'] = 'LEFT JOIN';
          }
          
          if(isset($join_info['conditions'])){
            $from .=
              " LEFT JOIN {$this->models[$join_info['model']]['table']} AS `{$this->models[$join_info['model']]['id']}`".
              " ON ".$this->conditions_to_comparisons($join_info['conditions']);
          }
          
          else{
            $from .=
              " {$join_info['type']} {$this->models[$join_info['model']]['table']} AS `{$this->models[$join_info['model']]['id']}`".
              " ON {$join_info['local']} = {$join_info['foreign']}";
          }

        }

        $join = $join_info['model'];

      }

      $d = ', ';

    }

    $where = 'WHERE 1'.$this->where;

    $group = (count($this->group) > 0) ? 'GROUP BY '.implode(', ', $this->group).' HAVING 1'.$this->having : '';

    $order = (count($this->order) > 0) ? 'ORDER BY '.implode(', ', $this->order) : '';

    $limit = (!empty($this->limit)) ? 'LIMIT '.$this->limit : '';

    return "$select $from $where $group $order $limit";

  }

  // used internally to return the query as subquery
  private function _get_subquery()
  {

    if(count($this->select) !== 1){
      throw new \exception\Programmer('You must choose a field to ->select() when applying this query as subquery.');
      return "'<error>'";
    }

    return '('.$this->query().')';

  }

  // used internally to return the query as subquery for use in the FROM clause
  public function _get_model_subquery()
  {

    return array(
      'component' => $this->component,
      'name' => $this->models[$this->model]['name'],
      'table' => '('.$this->query("`{$this->model}`.*").')',
      'path' => $this->models[$this->model]['path'],
      'relations' => $this->models[$this->model]['relations'],
      'id' => uniqid($this->models[$this->model]['name'])
    );

  }

  // used to convert given arguments to a WHERE or HAVING string
  private function arguments_to_comparisons()
  {
    
    if(func_num_args() < 2){
      throw new \exception\Programmer('Single argument not implemented yet.');
      return;
    }

    if(is_data(func_get_arg(0)) && !func_get_arg(0)->is_set()){
      return false;
    }

    $column = $this->prepare(func_get_arg(0));
    $compare = (func_num_args() > 2 ? func_get_arg(1) : '=');
    $value = func_get_arg(func_num_args()-1);
    
    if(!in_array($compare, array('=', '>', '<', '>=', '<=', '!', '|', '!|', ''))){
      throw new \exception\InvalidArgument("Invalid comparison type given (%s).", $compare);
      return;
    }
    
    raw($value);
    
    //if the given value is an array
    if(is_array($value)){
      if(empty($value)){
        $compare = '=';
        $value = 0;
      }else{
        $compare = ($compare === '!' ? 'NOT ' : '').'IN';
      }
    }

    //if the value is NULL
    elseif($value === 'NULL' || is_null($value)){
      $compare = 'IS'.($compare === '!' ? ' NOT' : '');
    }

    switch($compare){
      case '!':
        $compare = '!=';
        break;
      case '|':
        $compare = 'LIKE';
        break;
      case '!|':
        $compare = 'NOT LIKE';
        break;
    }
    
    $value = $this->prepare($value);
    
    return "($column $compare $value)";

  }

  // used to convert a given Conditions object to a WHERE or HAVING string
  private function conditions_to_comparisons(Conditions $conditions)
  {

    $return = '';

    $i = 0;
    foreach($conditions->_get() as $condition){
      $return .= ($i > 0 ? " AND " : '').$this->compose_condition($condition);
      $i++;
    }

    return "$return";

  }

  // used to convert a given Conditions object to a WHERE or HAVING string
  private function compose_condition(array $condition)
  {

    $connectors = array('AND', 'OR');
    $return = '';

    if($condition['type'] == 'comparison'){
      $return .= $this->arguments_to_comparisons($condition['column'], $condition['comparitor'], $condition['value']);
    }

    elseif($condition['type'] == 'combination')
    {

      $connector = (in_array(ucfirst($condition['connector']), $connectors) ? ucfirst($condition['connector']) : 'AND');
      $j=0;

      $return .= "(";
      foreach($condition['conditions'] as $sub){
        $return .= ($j > 0 ? " $connector " : '').$this->compose_condition($sub);
        $j++;
      }
      $return .= ")";

    }

    return $return;

  }

  // combine where and having because they are similar
  private function whaving()
  {

    //we check if function arguments insinuate "quick syntax"
    if(func_num_args() > 1){
      $whaving = call_user_func_array(array($this, 'arguments_to_comparisons'), func_get_args());
    }

    else
    {

      if(!(is_object(func_get_arg(0)) && func_get_arg(0) instanceof Conditions)){
        throw new \exception\InvalidArgument("Invalid argument given.");
        return false;
      }

      $whaving = $this->conditions_to_comparisons(func_get_arg(0));

    }

    return (empty($whaving) ? false : $whaving);

  }

  // combine group and order because they are similar
  private function grourder($c, $d)
  {
    //we create the return array
    $r = array();

    //and define which values are allowed to use as direction
    $da = array(
      'ASC'=>array('ASC', 'asc', false),
      'DESC'=>array('DESC', 'desc', true)
    );

    //we search through the arrays at depth 1 to see if a valid direction was given
    //if so, we get the lowest level key of the array the value was in, and use it as direction
    if($n = array_search_recursive($d, $da, 1, true)){
      $d = reset($n);
    }

    //if we find that the direction is any other format, we use the default, which is ASC
    else{
      $d = 'ASC';
    }

    //if column is RAND, order by RAND()
    if($c === 'RAND()'){
      $r[] = 'RAND()';
    }

    //if column is a string, we check if it's a valid column name
    elseif(is_string($c)){
      $r[] = $this->prepare_column($c).' '.$d;
    }

    //if it's an array, we exepct that it is an array of column names
    elseif(is_array($c))
    {

      foreach($c as $col)
      {

        //and we're sure if the values inside are strings
        if(is_string($col)){
          $r[] = $this->prepare_column($col).' '.$d;
        }

        //however, if we wanted a specific direction, a sub-array with the following format should have been given "array($column, $direction)"
        elseif(is_array($col) && count($col) == 2 && array_search_recursive($d, $da, 1, true) !== false){
          $r[] = $this->prepare_column($col[0]).' '.($col[1] ? $col[1] : $d);
        }

        //anything else is wrong
        else{
          throw new \exception\InvalidArgument('Invalid arguments given.');
        }

      }

    }

    //anything else is wrong
    else{
      throw new \exception\InvalidArgument('Expecting string or array. %s given.', ucfirst(gettype($c)));
    }

    return $r;

  }



  ###
  ###  INPUT CONVERTERS
  ###

  // get information about a column based on input
  private function get_column_info($input)
  {

    $info = array();

    //strip " ` "s
    $input = trim($input, '`');

    $column_array = explode('.', $input);

    // trace($column_array, $this->select);
    //count the parts and..
    switch(count($column_array))
    {

      // if there's only one part
      case 1:

        $info['component'] = $this->models[$this->working_model]['component'];

        if(!array_key_exists($column_array[0], $this->select)){
          $info['model'] = $this->working_model;
        }

        $info['name'] = $column_array[0];

        break;

      //if there's two parts
      case 2:
        $info['component'] = $this->models[$this->working_model]['component'];
        $info['model'] = $column_array[0];
        $info['name'] = $column_array[1];
        break;

      //if there's three parts, one should be the column name, the other one the model name and the last one the component name
      case 3:
        $info['component'] = $column_array[0];
        $info['model'] = $column_array[1];
        $info['name'] = $column_array[2];
        break;

      //any more parts are just too much for us
      default:
        throw new \exception\InvalidArgument("Given column identifier (%s) can consist of no more than 3 parts (component name, model name, column name)", $input);
        return false;

    }

    return $info;

  }

  // convert input to a proper column name
  private function prepare_column($column)
  {
    $info = is_array($column) ? $column : $this->get_column_info($column);
    return (array_key_exists('model', $info) ? "`{$info['model']}`." : '').($info['name'] === '*' ? '*' : "`{$info['name']}`");
  }

  // get information about a model
  private function get_model_info($input)
  {

    $info = array();

    // if this is in fact a table object, we will treat is as a subquery
    if(is_object($input) && $input instanceof Table)
    {

      $info = $input->_get_model_subquery();

    }

    elseif(is_string($input))
    {

      //first we check if a component name was given
      switch(substr_count($input, '.'))
      {

        case 0:
          $info['component'] = $this->component;
          $info['name'] = ucfirst($input);
          break;

        case 1:
          $model_array = explode('.', $input);
          $info['component'] = strtolower($model_array[0]);
          $info['name'] = ucfirst($model_array[1]);
          break;

        default:
          throw new \exception\InvalidArgument('Expecting $input to consits of no more that 2 parts, a component and a model separated by a dot. %s Parts given.', substr_count($input, '.')+1);

      }

      $model = load_model($info['component'], $info['name']);

      $info['path'] = $model;
      $info['table'] = $model::model_data('table_name');
      $info['relations'] = $model::model_data('relations');
      $info['id'] = str_replace('.', '_', uniqid($info['name'], true));

    }

    return $info;

  }

  // convert text to proper, safe text
  private function prepare_text($text)
  {
    $text = trim($text, '\'');
    return "'$text'";
  }

  // detect what input could be, and prepare it for insertion into the query
  private function prepare($input)
  {

    $input = data_of($input);

    //if this is a Table object, we are going to get the subquery from it
    if(is_object($input) && $input instanceof Table){
      $input = $input->_get_subquery();
    }

    //if it is an array, we'll turn it into a comma separated list
    elseif(is_array($input))
    {
      $a = array();
      foreach($input as $val){
        $a[] = $this->prepare($val);
      }
      return '('.implode(', ', $a).')';
    }

    //maybe it's null
    elseif(strtoupper($input) === 'NULL' || $input === null){
      return 'NULL';
    }

    elseif(is_numeric($input)){
      $input = $this->prepare_text($input);
    }

    //otherwise, we should test what it could be
    elseif(is_string($input))
    {
      
      //could it be a column?
      if(preg_match('~^([\`a-zA-Z0-9_\.]+|\*)$~', $input, $column) > 0){
        $input = $this->prepare_column($column['1']);
      }

      //maybe its text containing column names or simple text
      elseif((substr_count($input, '`') > 0) || (substr_count($input, '\'') > 0) || (substr_count($input, '*') > 0)){
        $input = preg_replace(
          array('~\'([^\']*)(?<!\\\)\'~ie',    '~(?!\')`(.*?)`(?!\')~ie'),
          array("\$this->prepare_text('\\1')", "\$this->prepare_column('\\1')"),
          $input
        );
      }

      //its probably just plain text without any bells or whistles :(
      else{
        $input = $this->prepare_text($input);
      }

    }

    return $input;

  }

}
