<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

use \Closure;

/**
 * The Table class, Mokuji's query-builder.
 *
 * @method {self} where1() where1(string $column, string $comparator, string $value)
 *
 *         Adds to the WHERE clause by providing a column in the format of
 *         `"[<model_id>.]<column_name>"`. The comparator may be omitted in which case
 *         `"="` is implied and `$value` takes its place in the argument order. Possible
 *         comparators are:
 *
 *         * `"="`: Equals
 *         * `">"`: More than
 *         * `"<"`: Less than
 *         * `">="`: More than or equals
 *         * `"<="`: Less than or equals
 *         * `"!"`: Doesn't equal
 *         * `"|"`: Contains
 *         * `"!|"`: Doesn't contain
 *         * `"IN"`: List contains
 *         * `"NOT IN"`: List doesn't contain
 *
 *         `$value` Contains the value to compare to.
 *
 * @method {self} where2() where2(Conditions $conditions)
 *
 *         Adds to the WHERE clause by providing a conditions object. See
 *         {@link Conditions} to find out how it can be used.
 *
 */
class Table extends Successable
{
  
  /**
   * Contains the component name after construction.
   * @see self::__construct()
   * @var string
   */
  private $component;
  
  /**
   * Contains the internal ID of the main model this instance was constructed with.
   * @see self::__construct()
   * @var string
   */
  private $model=false;
  
  /**
   * Contains the internal ID of the model that operations will be applied to.
   * @see self::workwith()
   * @var string
   */
  private $working_model;
  
  /**
   * Contains an associative array with model information using the models internal ID's as keys.
   * @see self::add()
   * @var array
   */
  private $models=array();
  
  /**
   * Contains unprocessed information for building the SELECT clause.
   * @see self::select()
   * @see self::from()
   * @see self::distinct()
   * @var array
   */
  private $select=array();
  
  /**
   * Contains whether the SELECT clause will be DISTINCT.
   * @see self::distinct()
   * @see self::select()
   * @var boolean
   */
  private $distinct=false;
  
  /**
   * Contains unprocessed information to build the SQL statements that make the results hierarchical.
   * @see self::parent_pk()
   * @see self::add_hierarchy()
   * @see self::add_relative_depth()
   * @see self::add_absolute_depth()
   * @see self::max_depth()
   * @var array
   */
  private $hierarchy=array();
  
  /**
   * Contains unprocessed information for building the FROM clause.
   * @see self::from()
   * @see self::select()
   * @var array
   */
  private $from=array();
  
  /**
   * Contains unprocessed information for building the JOIN clause.
   * @see self::join()
   * @see self::inner()
   * @see self::left()
   * @see self::right()
   * @var array
   */
  private $joins=array();
  
  /**
   * Contains the preprocessed WHERE clause.
   * @see self::where()
   * @see self::pk()
   * @see self::sk()
   * @see self::parent_pk()
   * @see self::filter()
   * @var string
   */
  private $where = '';
  
  /**
   * Contains unprocessed information for building the GROUP BY clause.
   * @see self::group()
   * @var array
   */
  private $group=array();
  
  /**
   * Contains the preprocessed HAVING clause.
   * @see self::having()
   * @see self::where()
   * @var string
   */
  private $having = '';
  
  /**
   * Contains unprocessed information for building the ORDER BY clause.
   * @see self::order()
   * @var array
   */
  private $order=array();
  
  /**
   * Contains the preprocessed LIMIT clause.
   * @see self::limit()
   * @see self::execute_single()
   * @var string
   */
  private $limit;
  
  /**
   * Contains the array of secondary keys on which the query results are filtered.
   * @see self::sk()
   * @var array
   */
  private $applied_sks=array();


  ###
  ###  SYSTEM
  ###
  
  /**
   * Constructs a Table object.
   *
   * @param string $component The name of the component to look for the model in.
   * @param string $model The name of the model to find.
   * @param string $id An out-parameter that will receive the internal ID that was assigned to the model.
   * @param array $models A reference to an array like {@link self::$models} to use instead of own models.
   *
   * @api
   */
  public function __construct($component, $model, &$id=null, &$models=null)
  {
    
    //Set the component name.
    $this->component = $component;
    
    //Use external array of models?
    if(!is_null($models)){
      $this->models =& $models;
    }
    
    //Add the main model to the query.
    $this->add($model, $id);
    
  }
  
  /**
   * Invoke this class like a function to attain the internal ID of the main model.
   *
   * This is useful when the Table was constructed elsewhere and the internal ID can no
   * longer be obtained via {@link self::__construct()}.
   *
   * @param string $id An out-parameter receiving the internal ID of the main model.
   *
   * @return self Chaining enabled.
   *
   * @api
   */
  public function __invoke(&$id=null)
  {
    $id = $this->model;
    return $this;
  }



  ###
  ###  HIGH LEVEL PUBLIC FUNCTIONS
  ###
  
  /**
   * Call a helper function to do complex table operations.
   *
   * @param string $component The name of the component that has the helper function.
   * @param string $name The name of the helper function to call. Note that this is the
   *                     name _without_ the `table__` prefix that it must have in the
   *                     component's Helpers class.
   *
   * @param mixed argument An argument to pass to the helper function.
   *
   * @param mixed ... The previous argument can be repeated indefinitely to add more
   *                  arguments for the helper function.
   *
   * @return self Chaining enabled.
   *
   * @api
   */
  public function helper($component, $name)
  {
    
    //Shift the function arguments off the passing arguments.
    $args = func_get_args();
    $component = array_shift($args);
    $name = array_shift($args);
    
    //Call the helper function, passing any arguments left on to it.
    tx('Component')->helpers($component)->_call('table__'.$name, array_merge(array($this), $args));
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Make the SELECT clause a DISTINCT select clause.
   *
   * @param boolean $value Can be set to false to disable distinct select.
   *
   * @return self Chaining enabled.
   *
   * @see self::select()
   * @api
   */
  public function distinct($value=true)
  {
    $this->distinct = $value !== false;
    return $this;
  }
  
  /**
   * Filter by primary keys.
   *
   * The amount of primary keys given must be exactly equal to the amount of primary keys
   * in the table. This method adds a statement to the WHERE clause for each primary key.
   * Settings this will therefore result in a single result in most cases, and works well
   * together with {@link self::execute_single()}
   *
   * @param mixed primary_key The first value for the first primary key, or array of
   *                          values for the first x primary keys.
   *
   * @param mixed ... The previous argument can be repeated indefinitely to add more
   *                  primary keys.
   *
   * @throws \exception\InvalidArgument If The number of given keys doesn't match the
   *                                    amount of primary keys defined in the model.
   *
   * @return self Chaining enabled.
   *
   * @see self::sk() Filter by secondary key.
   * @see self::where() Filter by anything.
   * @see self::execute_single() Executes the query and returns the first result.
   * @api
   */
  public function pk()
  {
    
    //Prepare variables.
    $values = array_flatten(func_get_args());
    $working_model = $this->models[$this->working_model]['path'];
    $pk_fields = $working_model::table_data()->primary_keys->as_array();
    
    //Make sure the amount of keys given is correct.
    if(count($values) !== count($pk_fields)){
      throw new \exception\InvalidArgument(
        'The number of values given does not match the amount of primary key fields. '.
        'The primary key fields are: %s. You gave %s values.',
        implode(', ', $pk_fields), func_num_args()
      );
    }
    
    //Iterate the primary keys in the model, adding filters for each of them to the WHERE clause.
    foreach($pk_fields as $pk){
      $this->where($pk, current($values));
      next($values);
    }

    //Enable chaining.
    return $this;

  }
  
  /**
   * Filter by secondary keys.
   *
   * This works the same as {@link self::pk()}, except it adds filters for the secondary
   * keys defined in the model. Secondary keys are not unique, and therefore filtering by
   * them does not imply a single result like primary key filtering does.
   *
   * @param mixed secondary_key The first value for the first secondary key, or array of
   *                            values for the first x secondary keys.
   *
   * @param mixed ... The previous argument can be repeated indefinitely to add more
   *                  secondary keys.
   *
   * @throws \exception\InvalidArgument If The number of given keys doesn't match the
   *                                    amount of secondary keys defined in the model.
   *
   * @return self Chaining enabled.
   *
   * @see self::pk() Filter by primary key.
   * @see self::where() Filter by anything.
   * @api
   */
  public function sk()
  {
    
    //Prepare variables.
    $values = array_flatten(func_get_args());
    $working_model = $this->models[$this->working_model]['path'];
    $sk_fields = $working_model::model_data('secondary_keys');
    
    //Make sure the amount of keys given is correct.
    if(count($values) !== count($sk_fields)){
      throw new \exception\InvalidArgument(
        'The number of values given does not match the amount of secondary key fields. '.
        'The secondary key fields are: %s. You gave %s values.',
        implode(', ', $sk_fields), func_num_args()
      );
    }
    
    //Iterate the secondary keys in the model, adding filters for each of them to the WHERE clause.
    foreach($sk_fields as $sk){
      $this->applied_sks[$sk] = current($values);
      if(!is_null($sk)) $this->where($sk, current($values));
      next($values);
    }
    
    //Enable chaining.
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
   * @param integer ... The previous parameter can be repeated indefinitely in order to
   *                    achieve providing values for every primary key in case of shared
   *                    primary keys.
   *
   * @return self Chaining enabled.
   *
   * @see self::pk() Filter by normal primary key.
   * @see self::add_hierarchy() Add hierarchy to the query.
   * @api
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
   * defined in the current working model.
   *
   * This method is mostly used internally by all the methods that depend on the hierarchical structure.
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
  
  /**
   * Add a depth field based on hierarchy.
   *
   * The depth field added by this method contains will contain the depth _relative to the
   * root node_, therefore making it "absolute".
   *
   * @param string $as The field name that the absolute depth variable will become
   *                   available under. Defaults to `abs_depth`.
   *
   * @return self Chaining enabled.
   *
   * @see self::add_relative_depth() Adds a depth field relative the the parent node.
   * @api
   */
  public function add_absolute_depth($as='abs_depth')
  {
    
    //Make sure hierarchy is added.
    $this->add_hierarchy();
    
    //Prepare variables.
    $model_name = $this->models[$this->working_model]['name'];
    $model = $this->models[$this->working_model]['path'];
    $hierarchy = $model::model_data('hierarchy');
    $pks = $model::table_data()->primary_keys->as_array();
    $sks = $model::model_data('secondary_keys');
    
    //Add a sub-query that we will use to track each rows hierarchical ancestors.
    $this->subquery($sq, $this->component, $model_name);
    
    //Make that sub-query.
    $sq($ancestors)
    ->select("COUNT(*)", 'depth')
    ->add($model_name, $leaf)
    ->where("$ancestors.{$hierarchy['left']}", '<=', $hierarchy['left'])
    ->where("$ancestors.{$hierarchy['right']}", '>=', $hierarchy['right']);
    
    //Iterate the working models primary keys to group by them, and select them as leaf-nodes.
    foreach($pks as $pk){
      $sq->group($pk);
      $sq->select($pk, 'leaf_'.$pk);
    }
    
    //Iterate over the secondary keys, and if they're applied, add filters for them to the ancestor-query.
    foreach($sks as $sk){
      if($this->applied_sks[$sk]){
        $sq->where("$ancestors.$sk", $this->applied_sks[$sk]);
      }
    }
    
    //Add the sub-query to the FROM clause, and select the depth from it.
    $this->from($sq, $id);
    $this->select("$id.depth", $as);
    
    //Set the primary keys in each row to the primary keys of the leafs.
    foreach($pks as $k => $pk){
      $this->pk("$id.leaf_$pk");
    }
    
    //Add the absolute depth field to the hierarchy information array for later use.
    $this->hierarchy[$this->working_model]['abs_depth'] = $id;
    
    //Enable chaining.
    return $this;

  }
  
  /**
   * Add a depth field based on hierarchy.
   *
   * The depth field added by this method contains will contain the depth _relative to the
   * parent node_, therefore this method requires you to appoint a parent node first. This
   * can be done using {@link self::parent_pk()}.
   *
   * @param string $as The field name that the relative depth variable will become
   *                   available under. Defaults to `rel_depth`.
   *
   * @throws \exception\Restriction If No parent node was appointed beforehand.
   *
   * @return self Chaining Enabled.
   *
   * @see self::add_absolute_depth() Adds a depth field relative to the root node.
   * @see self::parent_pk() Appoints a parent node by providing its primary key(s).
   * @api
   */
  public function add_relative_depth($as='rel_depth')
  {
    
    //Make sure hierarchy fields are available.
    $this->add_hierarchy();
    
    //Make sure a parent node was appointed.
    if(!array_key_exists('root', $this->hierarchy[$this->working_model])){
      throw new \exception\Restriction('Can only add a relative depth after a parent has been appointed as rootnode. Use ->parent_pk() to do this.');
    }
    
    //Prepare variables.
    $model_name = $this->models[$this->hierarchy[$this->working_model]['root']]['name'];
    $model = $this->models[$this->hierarchy[$this->working_model]['root']]['path'];
    $hierarchy = $model::model_data('hierarchy');
    $pks = $model::table_data()->primary_keys->as_array();
    
    //Create the sub-query that will keep track of each rows ancestors.
    $this->subquery($sq, $this->component, $model_name);
    
    //Build the ancestor query.
    $sq($ancestors)
    ->select("COUNT(*)", 'depth')
    ->add($model_name, $leaf)
    ->where("$ancestors.{$hierarchy['left']}", '<=', $hierarchy['left'])
    ->where("$ancestors.{$hierarchy['right']}", '>=', $hierarchy['right'])
    ->add($model_name, $parent)
    ->where("$ancestors.{$hierarchy['left']}", '>', $hierarchy['left'])
    ->where("$ancestors.{$hierarchy['right']}", '<', $hierarchy['right']);
    
    //Add primary keys to the query.
    foreach($this->hierarchy[$this->working_model]['root_pks'] as $pk=>$val){
      $sq->where($pk, $val);
    }
    
    //Add primary keys to the query.
    foreach($pks as $pk){
      $sq->group("$leaf.$pk");
      $sq->select("$leaf.$pk", "leaf_$pk");
    }
    
    //Add the sub-query to the FROM clause and select the depth field from it.
    $this->from($sq, $id);
    $this->select("$id.depth", $as);
    
    //Set the primary keys in each row to the primary keys of the leafs.
    foreach($pks as $k => $pk){
      $this->pk("$id.leaf_$pk");
    }
    
    //Add the absolute depth field to the hierarchy information array for later use.
    $this->hierarchy[$this->working_model]['rel_depth'] = $id;
    
    //Enable chaining.
    return $this;

  }
  
  /**
   * Exclude all nodes with a depth greater than given value.
   *
   * "Depth" in this method refers to either the relative depth or absolute depth fields
   * added by the respective methods; {@link self::add_absolute_depth()} or
   * {@link self::add_relative_depth()}. When both fields are present, relative depth will
   * be used.
   *
   * @param integer $gt The number of maximum depth.
   *
   * @return self Chaining enabled.
   *
   * @see self::add_absolute_depth() Adds a depth field relative to the root node.
   * @see self::add_relative_depth() Adds a depth field relative to the parent node.
   * @api
   */
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
  
  /**
   * Sets join type of the last join to "INNER".
   *
   * This is an alias for `$this->set_jointype('INNER')`.
   *
   * @return self Chaining enabled.
   *
   * @see self::left() Set join type to "LEFT".
   * @see self::right() Set join type to "RIGHT".
   * @api
   */
  public function inner()
  {
    return $this->set_jointype('INNER');
  }

  /**
   * Sets join type of the last join to "LEFT".
   *
   * This is an alias for `$this->set_jointype('LEFT')`.
   *
   * @return self Chaining enabled.
   *
   * @see self::inner() Set join type to "INNER".
   * @see self::right() Set join type to "RIGHT".
   * @api
   */
  public function left()
  {
    return $this->set_jointype('LEFT');
  }
  
  /**
   * Sets join type of the last join to "RIGHT".
   *
   * This is an alias for `$this->set_jointype('RIGHT')`.
   *
   * @return self Chaining enabled.
   *
   * @see self::inner() Set join type to "INNER".
   * @see self::left() Set join type to "LEFT".
   * @api
   */
  public function right()
  {
    return $this->set_jointype('RIGHT');
  }
  
  /**
   * Add statements to the WHERE clause automatically for given component filters.
   *
   * Components filters are current GET parameters, merged with the filters set in the
   * session for the component.
   *
   * @param array|string filter_name The name of the filter variable, alternatively this
   *                                 can be an array containing filter_name's as keys and
   *                                 column_names as values.
   *
   * @param string column_name The column name that needs to make use of the filter. This
   *                           is ignored when the first argument is an array.
   *
   * @throws \exception\InvalidArgument If the arguments have an unexpected format.
   *
   * @return self Chaining enabled.
   *
   * @see \core\Data::filter() for more information on what the filter variables are.
   * @see self::where() Add to the where clause directly.
   * @api
   */
  public function filter()
  {
    
    //Handle an array of filters by recursively calling this method.
    if(func_num_args() == 1 && is_array(func_get_arg(0))){
      foreach(func_get_arg(0) as $filter => $column){
        call_user_func(array($this, 'filter'), $filter, $column);
      }
    }
    
    //Handle a key to key pair.
    elseif(func_num_args() == 2 && is_string(func_get_arg(0)))
    {
      
      //Reference the filter variable.
      $filter = tx('Data')->filter($this->component)->{func_get_arg(0)};
      
      //Add the filter to the WHERE clause if it is set.
      if($filter->is_set()){
        $this->where(func_get_arg(1), $filter);
      }
      
    }
    
    //Invalid arguments.
    else{
      throw new \exception\InvalidArgument(
        'The ->filter() function accepts one or two arguments, an array containing '.
        'filters or a filter name and matching column name.'
      );
    }
    
    //Enable chaining.
    return $this;

  }
  
  
  
  ###
  ###  LOW LEVEL PUBLIC FUNCTIONS
  ###
  
  /**
   * Add a model and make it the working model.
   *
   * This adds a model to the FROM clause, and makes it the new working right away.
   *
   * @param mixed $model See {@link self::get_model_info()} to find out what can be given.
   * @param string $id This is an out-parameter that will receive the internal ID assigned to the new model.
   *
   * @return self Chaining enabled.
   *
   * @see self::select() Add something to the SELECT clause.
   * @see self::workwith() Set a model as the working model.
   * @api
   */
  public function add($model, &$id=null)
  {
    $this->from($model, $id);
    $this->workwith($id);
    return $this;
  }
  
  /**
   * Set the working model.
   *
   * @param string $id The internal ID of the model to set as working model.
   *
   * @return self Chaining enabled.
   *
   * @see self::add() Add a model.
   */
  public function workwith($id)
  {

    if(!array_key_exists($id, $this->models)){
      throw new \exception\NotFound("Failed to set working model to '%s'. No model with that identifier found.", $id);
      return $this;
    }

    $this->working_model = $id;
    return $this;

  }
  
  /**
   * Adds a column to the SELECT clause.
   *
   * @param mixed $content See {@link self::prepare()} to find out what can be given here.
   * @param string $as An optional alias to select this content by.
   *
   * @throws \exception\Restriction If The given alias is already in use.
   *
   * @return self Chaining enabled.
   *
   * @see self::from() Where do you select from?
   * @see self::prepare() How given content is prepared.
   * @api
   */
  public function select($content, $as=null)
  {
    
    //Use the content as an alias?
    if(is_null($as)){
      $as = $content;
    }
    
    //Make sure the alias is not yet in use.
    if(array_key_exists($as, $this->select)){
      throw new \exception\Restriction("Alias '%s' already in use.", $as);
    }
    
    //Prepare the content and add it to the select array.
    $this->select[$as] = $this->prepare($content);
    
    //Enable chaining.
    return $this;
    
  }
  
  /**
   * Add a model to the FROM clause.
   *
   * @param mixed $model See {@link self::get_model_info()} to see what can be given here.
   * @param string $id An out-parameter which will receive the internal ID of the model.
   *
   * @return self Chaining enabled.
   *
   * @see self::select() Select something from the model.
   * @see self::add() Add a new model to a FROM clause and make it the working model.
   * @api
   */
  public function from($model, &$id=null)
  {
    
    //Prepare variables.
    $info = $this->get_model_info($model);
    $id = $info['id'];

    //First added model becomes the primary model.
    if($this->model === false){
      $this->model = $id;
    }
    
    //Store the model in the FROM array.
    $this->models[$id] = $info;
    $this->from[] = array('model'=>$id);
    
    //Enable chaining.
    return $this;

  }
  
  /**
   * Join a foreign model onto the working model.
   *
   * This method uses the `relations` information available on the local model or foreign
   * model classes to determine which tables to join on which keys in order to join the
   * model of the given name.
   *
   * You can define these relations in your model by setting the static `$relations`
   * property in the model class to an array, formatted as follows:
   *
   * ```php
   * static $relations = array(
   *   "<foreign_model_name>" => array(
   *     "<local_column_name>" => "<join_model_name>.<join_column_name>"[,
   *     "<join_type>"]
   *   )
   * );
   * ```
   *
   * - `<foreign_model_name>`: The model that can be joined.
   * - `<local_column_name>`: The column name in this model that the join column will be linked to.
   * - `<join_model_name>`: The first model to join in order to get to the foreign model.
   * - `<join_column_name>`: The name of the column that links to the local column.
   *
   * In most cases, the `<join_model_name>` will be equal to the `<foreign_model_name>`
   * for a direct join path. They can however differ to create a longer path of joins, in
   * this case, the `<join_model_name>` will be joined at first and `join()` will look
   * into that model for further relations with the eventual `<foreign_model_name>`. This
   * is useful for joining a foreign model through a link table that has 2 foreign keys.
   *
   * @param string $model_name The name of the foreign model. Can be set to
   *                           `"__CURRENT__"` in order to use the current working model
   *                           when `$join_conditions` is provided.
   *
   * @param string $id The out-parameter which will receive the internal ID that gets
   *                   assigned to the model.
   *
   * @param \Closure $join_conditions An optional closure which can modify the Conditions
   *                                  object in order to change the "ON" clause of this
   *                                  join. This closure is executed once when generating
   *                                  the ON clause and will receive the following
   *                                  arguments: The internal ID of the local model, the
   *                                  internal ID of the foreign model, and the Conditions
   *                                  object. See {@link Conditions} to find out how the
   *                                  object can be modified.
   *
   * @return self Chaining enabled.
   *
   * @see Conditions The Conditions class used to create the ON clause and modifiable by `$join_conditions`.
   * @see self::workwith() Change the working model.
   * @api
   */
  public function join($model_name, &$id=null, Closure $join_conditions=null)
  {
    
    raw($model_name);
    
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
  
  /**
   * Sets join type for the latest JOIN.
   *
   * @param string $type Any of the following: `"LEFT"`, `"RIGHT"`, `"INNER"`.
   *
   * @return self Chaining enabled.
   *
   * @see self::left() Short for `join("LEFT")`.
   * @see self::right() Short for `join("RIGHT")`.
   * @see self::inner() Short for `join("INNER")`.
   */
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
  
  /**
   * Add to the WHERE clause.
   *
   * This method can be used in 2 different ways. Please refer to `where1` and `where2` for the documentation.
   *
   * @return self Chaining enabled.
   *
   * @see self::where1() Add a single statement to the WHERE clause by providing filters.
   * @see self::where2() Add a complex statement to the WHERE clause by providing a Conditions object.
   * @see self::filter() Add statements to the WHERE clause automatically for given filters.
   * @api
   */
  public function where()
  {

    $where = call_user_func_array(array($this, 'whaving'), func_get_args());
    if($where !== false) $this->where .= " AND $where";

    return $this;

  }
  
  /**
   * Group by the given column in the working model.
   *
   * @param string $column The column identifier.
   * @param string|false $direction Optional direction; `"ASC"` or `"DESC"`.
   *
   * @return self Chaining enabled.
   *
   * @see self::workwith() Change the working model.
   * @api
   */
  public function group($column, $direction=false)
  {
    raw($column, $direction);
    $this->group = array_merge($this->group, $this->grourder($column, $direction));
    return $this;
  }
  
  /**
   * Add to the HAVING clause.
   *
   * Adds to the HAVING clause in the exact same way that `$this->where()` adds to there
   * WHERE clause. Please refer to the `where()` documentation for use of this method.
   *
   * @return self Chaining enabled.
   *
   * @see self::where() More documentation on the use of the `where` and `having` methods.
   * @api
   */
  public function having()
  {

    $having = call_user_func_array(array($this, 'whaving'), func_get_args());
    if($having !== false) $this->having .= " AND $having";

    return $this;

  }
  
  /**
   * Order by the given column in the working model.
   *
   * @param string $column The column identifier.
   * @param string|false $direction Optional direction; `"ASC"` or `"DESC"`.
   *
   * @return self Chaining enabled.
   *
   * @see self::workwith() Change the working model.
   * @api
   */
  public function order($column, $direction=false)
  {
    raw($column, $direction);
    $this->order = array_merge($this->order, $this->grourder($column, $direction));
    return $this;
  }
  
  /**
   * Limit the amount of rows returned.
   *
   * @param integer $rowcount The maximum amount of rows allowed.
   * @param integer $offset An optional offset. Rows before the offset will not be included.
   *
   * @return self Chaining enabled.
   *
   * @see self::execute_single() Automatically limit to a single row and execute.
   * @api
   */
  public function limit($rowcount, $offset=null)
  {

    raw($rowcount, $offset);

    if(!is_numeric($rowcount)){
      throw new \exception\InvalidArgument('Expecting $rowcount to be numeric. "%s" of type %s given.', $rowcount, gettype($rowcount));
    }

    $this->limit = "$rowcount".(is_int($offset) ? " OFFSET $offset" : '');

    return $this;

  }
  
  /**
   * Execute the query.
   *
   * @param string $as An optional model ID in which the results will be returned.
   *
   * @throws \exception\NotFound If the given model ID does not point to a known model.
   * @throws \exception\Sql If an SQL error occurs.
   *
   * @return Resultset The wrapper with the result of the query.
   *
   * @see self::execute_single() Execute and return the first result directly.
   * @see self::count() Execute the query, returning the amount of rows affected.
   * @api
   */
  public function execute($as=null)
  {
    
    $result = tx('Sql')->query($this->getQuery($as, $model));
    
    //Return the result set.
    return new \dependencies\Resultset($result, $model);
    
  }
  
  /**
   * Execute the query, returning the amount of rows affected.
   *
   * @return Data An instance of Data wrapping an integer containing the amount of rows.
   * @api
   */
  public function count()
  {
    
    return tx('Sql')->execute_scalar("SELECT COUNT(*) FROM (".$this->query("`{$this->model}`.*").") as WouldYouBeSoKindAsToCountMyRecords")
      ->is('empty', function(){return 0;});
    
  }
  
  /**
   * Execute and return the first result directly.
   *
   * This method also automatically adds a limit of 1.
   *
   * @param string $as An optional model ID in which the results will be returned.
   *
   * @throws \exception\NotFound If the given model ID does not point to a known model.
   * @throws \exception\Sql If an SQL error occurs.
   *
   * @return BaseModel The model that contains the first row.
   *
   * @see self::execute() Execute normally.
   * @api
   */
  public function execute_single($as=null)
  {

    $this->limit(1);
    $result = $this->execute($as);
    return $result->idx(0);

  }
  
  /**
   * Works the same as execute_single, except that it will create an empty model if there was no result.
   *
   * @param string $as
   *
   * @return BaseModel A model.
   */
  public function execute_model($as=null)
  {
    
    $result = $this->execute_single($as);
    
    if($result->is_empty()){
      $minfo = $this->models[(is_string($as) ? $as : $this->model)];
      $model = load_model($minfo['component'], $minfo['name']);
      return new $model;
    }
    
    return $result;
    
  }
  
  /**
   * Print the query to the output.
   *
   * **This method may be used for debugging purposed and it is not recommended to have it
   * in any final code.**
   *
   * @param string $as An optional model ID in which the results will be returned.
   *
   * @throws \exception\NotFound If the given model ID does not point to a known model.
   * @throws \exception\Sql If an SQL error occurs.
   *
   * @return self Chaining enabled.
   */
  public function write($as=null)
  {
    
    echo $this->getQuery($as);
    return $this;

  }
  
  /**
   * Generate and return the query as a string.
   *
   * @param string $as An optional model ID in which the results will be returned.
   * @param array $model An out-parameter that receives model meta-data.
   *
   * @throws \exception\NotFound If the given model ID does not point to a known model.
   * @throws \exception\Sql If an SQL error occurs.
   *
   * @return string The query.
   * @api
   */
  public function getQuery($as=null, &$model=null)
  {
    
    //Use the working model?
    $as = (is_null($as) ? $this->model : $as);
    
    //Make sure the model exists.
    if(!array_key_exists($as, $this->models)){
      throw new \exception\NotFound("Failed to execute as '%s'. No model with that identifier found.", $as);
    }
    
    //Do the work.
    $as = $this->models[$as];
    $model = $as['path'];
    
    //Generate and return the result.
    return $this->query("`{$as['id']}`.*");
        
  }

  /**
   * Creates a new query in the context of this one.
   *
   * @param self $q An out-parameter which will receive the Table object that represents the sub-query.
   *
   * @param string $component The name of the component in which to look for the model.
   *                          This parameter can be omitted, in which case it defaults to
   *                          the component used by this Table.
   *
   * @param string $model The name of the model that the sub-query will use.
   *
   * @param \Closure $builder An optional Closure which will be called with the Table
   *                          (sub-query) object as a parameter, allowing for the
   *                          sub-query to be built right away.
   *
   * @return self Chaining enabled.
   *
   * @see self::__construct() Internally, `subquery()` passes on its parameters to the constructor.
   * @api
   */
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

  /**
   * Builds the query
   *
   * @param string $all Column to select.
   *
   * @return string The query.
   */
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

  /**
   * Build the query and return it for use as a sub-query.
   *
   * @throws \exception\Programmer If no columns have been explicitly selected in the query.
   *
   * @return string
   */
  private function _get_subquery()
  {

    if(count($this->select) !== 1){
      throw new \exception\Programmer('You must choose a field to ->select() when applying this query as subquery.');
    }

    return '('.$this->query().')';

  }

  /**
   * Returns the query inside a `model_info` array, so it can be used as if it's a model.
   *
   * @return array
   */
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

  /**
   * Used to convert given arguments to a WHERE or HAVING string.
   *
   * @param string $column The name of the column to compare against.
   * @param string $comparator The type of comparison to make. Can be omitted.
   * @param mixed $value The value to compare against.
   *
   * @return string The finished comparison-string.
   *
   * @see self::where()
   * @see self::having()
   */
  private function arguments_to_comparisons()
  {
    
    //Ensure we have two arguments.
    if(func_num_args() < 2){
      throw new \exception\InvalidArgument('Need at least two arguments.');
    }
    
    //Fail if the first argument is non-set data.
    if(is_data(func_get_arg(0)) && !func_get_arg(0)->is_set()){
      return false;
    }
    
    //Prepare arguments.
    $column = $this->prepare(func_get_arg(0));
    $compare = (func_num_args() > 2 ? func_get_arg(1) : '=');
    $value = func_get_arg(func_num_args()-1);

    //The comparator must be one of the following.
    if(!in_array($compare, array('=', '>', '<', '>=', '<=', '!', '|', '!|', '', 'IN', 'NOT IN'))){
      throw new \exception\InvalidArgument("Invalid comparison type given (%s).", $compare);
    }
    
    //Convert comparator to work with array-values.
    if(is_array($value))
    {
      
      //Empty arrays will be interpreted as 0.
      if(empty($value)){
        $compare = '=';
        $value = 0;
      }
      
      //Filled arrays will become lists, so the comparator will become IN.
      else{
        $compare = ($compare === '!' ? 'NOT ' : '').'IN';
      }
      
    }

    //Convert comparator to work with NULL.
    elseif($value === 'NULL' || is_null($value)){
      $compare = 'IS'.($compare === '!' ? ' NOT' : '');
    }
    
    //Convert custom syntax.
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
    
    //Prepare the value.
    $value = $this->prepare($value);
    
    //Build and return the comparison.
    return "($column $compare $value)";

  }

  /**
   * Used to convert a given Conditions object to a WHERE or HAVING string.
   *
   * @param Conditions $conditions The Conditions object to use.
   *
   * @return string The resulting comparison-string.
   *
   * @see Conditions
   * @see self::where()
   * @see self::having()
   */
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

  /**
   * Converts an array to a comparison-string.
   *
   * Used by `conditions_to_comparisons` in order to convert Condition formatted arrays to
   * comparison formatted strings.
   *
   * @param array $condition
   *
   * @return string Comparison.
   *
   * @see self::conditions_to_comparisons() The master method.
   */
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

  /**
   * Combine where and having because they are similar in syntax.
   *
   * @return string The resulting MySQL.
   *
   * @see self::where()
   * @see self::having()
   */
  private function whaving()
  {

    //Do the function arguments imply "quick syntax"?
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

  /**
   * Combine group and order because they are similar in syntax.
   *
   * @param string $c Column name.
   * @param string $d Direction.
   *
   * @return string The resulting MySQL.
   *
   * @see self::group()
   * @see self::order()
   */
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

  /**
   * Normalizes a string representing a column into an array of meta-data.
   *
   * @param string $input Columns have the following format:
   *                      `"[[<component_name>.]<model_name>.]<column_name>"`.
   *
   *                      * `<column_name>`: The name of the column. This has to be present in the string.
   *                      * `<model_name>`: An optional alternative model may be prepended
   *                        to the column-name using a `.` as separator. This has to be
   *                        an internal model ID!
   *                      * `<component_name>`: If the model name was given, an optional
   *                        component name may be prepended to that using a `.`, in which
   *                        case this component will be used to look for the model in.
   *
   * @return array An associative array with the following keys:
   *
   *               * `component`: The name of the component.
   *               * `model`: The internal ID of the model.
   *               * `name`: The name of the column.
   */
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

  /**
   * Normalizes several different inputs which represent a column into a string.
   *
   * @param string|array $column
   *
   * @return string
   *
   * @see self::prepare() The master method.
   */
  public function prepare_column($column)
  {
    $info = is_array($column) ? $column : $this->get_column_info($column);
    return (array_key_exists('model', $info) ? "`{$info['model']}`." : '').($info['name'] === '*' ? '*' : "`{$info['name']}`");
  }

  /**
   * Normalizes several different inputs that represent a model to an array of meta-data.
   *
   * @param Table|string $input When given input is a table, its
   *                            `_get_model_subquery`-method will be used to attain the
   *                            array of meta-data. When it is a string, it must have the
   *                            following format: `"[<component_name>.]<model_name>"`.
   *
   *                            * `<component_name>`: The name of the component that houses
   *                              the model.
   *                            * `<model_name>`: The name of the model (class name).
   *
   * @return array An array with the following keys:
   *
   *               * `component`: The name of the component that houses the model.
   *               * `name`: The name of the model.
   *               * `path`: The full class-name of the model.
   *               * `table`: The table name corresponding to the model.
   *               * `relations`: Cached inter-tabular relations defined in the model.
   *               * `id`: The internal ID assigned to the model.
   *
   * @see self::_get_model_subquery() Get the same meta-data, using a sub-query as model.
   */
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
          throw new \exception\InvalidArgument(
            'Expecting $input to consist of no more that 2 parts, a component and a model '.
            'separated by a dot. %s Parts given.', substr_count($input, '.')+1
          );

      }

      $model = load_model($info['component'], $info['name']);

      $info['path'] = $model;
      $info['table'] = $model::model_data('table_name');
      $info['relations'] = $model::model_data('relations');
      $info['id'] = str_replace('.', '_', uniqid($info['name'], true));

    }

    return $info;

  }

  /**
   * Sanitizes and normalizes text-input.
   *
   * @param string $text
   *
   * @return string
   */
  public function prepare_text($text)
  {
    $text = trim($text, '\'');
    return "'$text'";
  }

  /**
   * Detect what input could be, and prepare it for insertion into the query.
   *
   * @param Table|array|string|integer $input
   *        * `Table`: Will be used as a sub-query.
   *        * `array`: Will be converted to a comma-separated list of values.
   *        * `"NULL"`: Will become `NULL`.
   *        * `integer`: And numeric strings will be used as numbers.
   *        * `string`: Words with periods and text between (\`)-marks will be used as a
   *          column-identifier, and parsed by `self::get_column_info()`. Text between
   *          quotation-marks, or with spaces or special characters will be interpreted as
   *          plain-text, and sanitized by `self::prepare_text()`.
   *
   * @return string The prepared value.
   */
  private function prepare($input)
  {

    $that = $this;
    $input = data_of($input);

    //if this is a Table object, we are going to get the subquery from it
    if($input instanceof Table){
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
        $input = preg_replace_callback('~\'([^\']*)(?<!\\\)\'~i', function($matches)use($that){
          return $that->prepare_text($matches[1]);
        }, $input);
        $input = preg_replace_callback('~(?!\')`(.*?)`(?!\')~i', function($matches)use($that){
          return $that->prepare_column($matches[1]);
        }, $input);
      }

      //its probably just plain text without any bells or whistles :(
      else{
        $input = $this->prepare_text($input);
      }

    }

    return $input;

  }

}
