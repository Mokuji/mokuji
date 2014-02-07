<?php namespace components\account\classes; if(!defined('TX')) die('No direct access.');

use \ReflectionClass;

class ControllerFactory
{
  
  /**
   * Singleton container.
   * @var self
   */
  private static $instance;
  
  /**
   * Singleton getter.
   *
   * @return self The singleton.
   */
  public static function getInstance()
  {
    
    if(!(self::$instance instanceof self)){
      self::$instance = new self;
    }
    
    return self::$instance;
    
  }
  
  /**
   * Contains the name of the component.
   * @var string
   */
  private $componentName = 'account';
  
  /**
   * The instance cache.
   * @var controllers\base\Controller[]
   */
  private $controllers = array();
  
  /**
   * Private constructor.
   */
  private function __construct()
  {
    
    // Because this class resides in Account for now, there's no need to detect the component name.
    // $ns_arr = explode('\\', get_class($this));
    // $this->componentName = $ns_arr[1];
    
  }
  
  /**
   * Redirect property gets to the getController method.
   *
   * @param string $key
   *
   * @return controllers\base\Controller An instance of a controller.
   */
  public function __get($key)
  {
    
    return $this->getController($key);
    
  }
  
  /**
   * Forward calls to getController.
   *
   * @param string $key The name of the controller.
   * @param array $params The parameters for the controllers constructor.
   *
   * @return controllers\base\Controller An instance of a controller.
   */
  public function __call($key, array $params)
  {
    
    return $this->getController($key, false, $params);
    
  }
  
  /**
   * Get a controller instance from the cache.
   *
   * @param string $name The class name of the controller.
   * @param boolean $forceNew Create a new instance regardless of cache.
   * @param array $parameters Parameters to pass to the controller.
   *
   * @return controllers\base\Controller An instance of a controller.
   */
  public function getController($name, $forceNew = false, array $parameters = array())
  {
    
    //Make a fully qualified class name.
    $class = "\\components\\{$this->componentName}\\controllers\\{$name}Controller";
    
    //Create a Reflection.
    $reflection = new ReflectionClass($class);
    
    //Force a new instance?
    if($forceNew){
      return $reflection->newInstanceArgs($parameters);
    }
    
    //Create a key.
    $key = "{$name}::".hash('md5', serialize($parameters));
    
    //Return from cache?
    if(array_key_exists($key, $this->controllers)){
      return $this->controllers[$key];
    }
    
    //Create and return new instance.
    $this->controllers[$key] = $r = $reflection->newInstanceArgs($parameters);
    return $r;
    
  }
  
}
