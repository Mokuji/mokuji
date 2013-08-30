<?php namespace core; if(!defined('TX')) die('No direct access.');

use \PDO;

class Sql
{
  private 
    $connection,
    $prefix;
  
  //Getter for prefix.
  public function get_prefix() { return $this->prefix; }
  
  // Open database connection.
  public function __construct()
  {
    if(INSTALLING !== true){
      $this->connection = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
      $this->prefix = DB_PREFIX;
    }
  }
  
  public function set_connection_data($host, $user, $pass, $name, $prefix)
  {
    
    if(INSTALLING === true && !isset($this->connection)){
      $this->connection = new PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
      $this->prefix = $prefix;
    } else {
      throw new \exception\Programmer('Connection data has already been set by the config files.');
    }
    
  }
  
  // Executes a query and does not return any results.
  public function execute_non_query($query)
  {
    $this->query($query);
  }
  
  // Executes a query and returns a multidimentional array of results.
  public function execute_query($query)
  {
    return new \dependencies\Resultset($this->query($query));
  }
  
  // Executes a query and returns one value from one one column on one row.
  public function execute_single($query)
  {
    $result = $this->execute_query($query);
    return $result->idx(0);
  }
  
  // Executes a query and returns one value from one one column on one row.
  public function execute_scalar($query)
  {
    $result = $this->execute_query($query);
    return $result->idx(0)->idx(0);
  }
  
  // Gets the last inserted auto_increment id.
  public function get_insert_id()
  {
    return $this->connection->lastInsertId();
  }
  
  // Creates a new table object based on given model.
  public function table($component_name, $model_name, &$id=null)
  {
    return new \dependencies\Table($component_name, $model_name, $id);
  }
  
  // Creates a new table object based on given model to be used as subquery returning the given column names.
  public function sub_table($component_name, $model_name, array $select)
  {
    return new \dependencies\Table($component_name, $model_name, $select);
  }
  
  public function model($component_name, $model_name)
  {
    $model = load_model($component_name, $model_name);
    return new $model();
  }
  
  public function query($query)
  {

    $query = str_replace('#__', $this->prefix, $query);
    $result = $this->connection->query($query);
    
    if($result === false){
      $error = $this->connection->errorInfo();
      throw new \exception\Sql("%s in query: <b>%s</b>", $error[2], $query);
      return false;
    }
    
    return $result;
    
  }
  
  public function conditions(&$c=null)
  {
    $c =  new \dependencies\Conditions();
    return $c;
  }
  
  public function make_query()
  {
    
    //handle arguments
    $args = func_get_args();
    $query = array_shift($args);
    $args = array_flatten($args);
    $that = $this;
    
    if(substr_count($query, "'") > 0 || substr_count($query, '"') > 0){
      throw new \exception\Restriction('Query may not contain quotes.');
    }
    
    $query = preg_replace_callback('~\?~', function()use($that, &$args){
      return $that->escape(array_shift($args));
    }, $query, -1, $c);
    
    return $query;
    
  }
  
  public function escape($value)
  {

    while(is_object($value))
    {
      
      if($value instanceof \dependencies\Data){
        $value = $value->is_leafnode() ? $value->get() : $value->serialized();
      }
      
      elseif($value instanceof \Closure){
        $value = $value();
      }
      
      else{
        $value = serialize($value);
      }
      
    }
    
    switch(strtolower(gettype($value))){
      case 'string': $value = (($value == 'NULL') ? 'NULL' : $this->connection->quote($value)); break;
      case 'integer': case 'double': break;
      case 'boolean': $value = (($value == true) ? 1 : 0); break;
      case 'null': $value = 'NULL'; break;
    }
    
    return $value;
    
  }
  
}
