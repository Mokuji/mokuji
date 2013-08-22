<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class BaseComponent
{

  protected static $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template');
  protected
    $component,
    $default_permission = 2,
    $permissions = array();
  
  // constructor extracts the component name from the namespace
  public function __construct()
  {
    
    $ns_arr = explode('\\', get_class($this));
    $this->component = $ns_arr[1];
    //$this->extension = strtolower(substr($ns_arr[2], 0, -1));
    
  }
  
  // filter helper function
  public function filters()
  {
    return tx('Data')->filter($this->component);
  }
  
  /**
   * Creates a component specific filter in the session.
   *
   * @param string $key The key under which the value will be available.
   * @param mixed $value The value for the filter.
   *
   * @return self Chaining enabled.
   */
  public function create_filter($key, $value)
  {
    
    //Set the session variable.
    tx('Data')->session->{$this->component}->{$key}->set($value);
    
    //Enable chaining.
    return $this;
    
  }
  
  // model loading helper function
  public function model($model_name)
  {
  
    return tx('Sql')->model($this->component, $model_name);
  
  }
  
  // view loading helper function
  public function view($module_name, $options=array())
  {
    
    return tx('Component')->views($this->component)->get_html($module_name, $options);
    
  }
  
  // module loading helper function
  public function module($module_name, $options=array())
  {
    
    return tx('Component')->modules($this->component)->get_html($module_name, $options);
    
  }
  
  // section loading helper function
  public function section($section, $options=array())
  {
    
    return tx('Component')->sections($this->component)->get_html($section, $options);
    
  }
  
  // ORM helper function
  public function table($model_name, &$id=null)
  {
    
    return tx('Sql')->table($this->component, $model_name, $id);
    
  }
  
  // helper helper function helper($helper, [$arg, ...])
  public function helper($controller)
  {
    
    $args = func_get_args();
    array_shift($args);
    
    return tx('Component')->helpers($this->component)->_call($controller, $args);
    
  }
  
  // calls specified controller with given data as first argument
  public function call($controller, $data=null)
  {
    
    return $this->_call($controller, array(Data($data)));
    
  }
  
  // calls $controller on this instance with specified array passed as argument list
  public function _call($controller, array $args = array())
  {
    
    if(INSTALLING !== true){
      //check defined permissions
      if(array_key_exists($controller, $this->permissions) ? !tx('Account')->check_level($this->permissions[$controller]) : !tx('Account')->check_level($this->default_permission)){
        throw new \exception\Authorisation('You are not authorized to execute this controller.');
      }
    }
    
    //check if the method actually exists
    if(!method_exists($this, $controller)){
      throw new \exception\NotFound('Could not find the controller "%s" in "%s".', $controller, get_class($this));
    }
    
    //prevent calling of reserved controller names
    if(in_array($controller, self::$reserved))
    {
      
      if(DEBUG){
        throw new \exception\Restriction('Illegal use of reserved controller name: ["%s"].', Data(self::$reserved)->map(function($word)use($controller){
          return ($word->get() === $controller ? "<b style=\"color:red\">$word</b>" : $word);
        })->join('", "'));
      }
      
      else{
        throw new \exception\User('You do not have access.');
      }
      
    }
    
    //prevent calling of helper controllers
    if(substr($controller, 0, 1) === '_'){
      if(DEBUG){
        throw new \exception\Restriction('Illigal attempt to call helper function "%s"', $controller);
      }else{
        throw new \exception\User('You do not have access.');
      }
    }
    
    return call_user_func_array(array($this, $controller), $args);
    
  }
  
}
