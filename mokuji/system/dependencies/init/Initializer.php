<?php namespace dependencies\init;

require_once('Defines.php');
require_once('Environments.php');
require_once('Tasks.php');

/**
 * A singleton class that allows you to initialize a Mokuji runtime.
 */
class Initializer
{
  
  /**
   * Shell environment.
   */
  const ENV_SHELL = 0;
  
  /**
   * Frontend environment.
   */
  const ENV_FRONTEND = 1;
  
  /**
   * Backend environment.
   */
  const ENV_BACKEND = 2;
  
  /**
   * Install environment.
   */
  const ENV_INSTALL = 3;
  
  /**
   * Minimal environment.
   */
  const ENV_MINIMAL = 4;
  
  /**
   * The instance of this class.
   * @var \dependencies\init\Initializer
   */
  private static $instance;
  
  /**
   * Gets the instance of this class.
   * @return \dependencies\init\Initializer The instance of this class.
   */
  public static function get_instance()
  {
    
    if(!isset(self::$instance))
      self::$instance = new Initializer();
    
    return self::$instance;
    
  }
  
  /**
   * Private constructor to create the instance.
   */
  private function __construct()
  {
    
    //Default timezone.
    date_default_timezone_set('Europe/Amsterdam');
    
    //Set the default configuration values.
    $this->is_installing = false;
    $this->use_multisite = true;
    $this->use_database = true;
    $this->debugging = false;
    
  }
  
  /**
   * Whether or not the current runtime has completed it's installation.
   * @var boolean
   */
  protected $is_installed;
  
  /**
   * The environment to be used in this run.
   * @var integer
   */
  protected $environment;
  
  /**
   * Whether or not to use debugging options for this run.
   * @var boolean
   */
  protected $debugging;
  
  /**
   * Whether or not the database should be used in this run.
   * @var boolean
   */
  protected $use_database;
  
  /**
   * Whether multi-site detection should be used in this run.
   * @var boolean
   */
  protected $use_multisite;
  
  /**
   * Optional url_path override. Allows you to run the environment from different files than the index.php in the root.
   * @var string
   */
  protected $url_path;
  
  /**
   * Where we can find the root of this installation.
   * @var string
   */
  protected $root = '';
  
  /**
   * Allows you to set the root of the environment.
   * @param string $value The path to the root of the environment.
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function set_root($value='')
  {
    
    $this->root = (string)$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set the desired environment type.
   * @param integer $environment The environment to set.
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function set_environment($environment)
  {
    
    //Delegate environment specific checks to the Environments class.
    Environments::on_set($this, $environment);
    
    //Store it if no exceptions were thrown.
    $this->environment = $environment;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set the url_path if it is not the default.
   * @param string $value The url_path to assume of the environment.
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function set_url_path($value)
  {
    
    //Detect starting slashes and strip it.
    if(is_string($value) && strlen($value) > 0 && $value[0] === '/')
      $value = substr($value, 1);
    
    $this->url_path = $value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set whether the database should be enabled or not.
   * @param boolean $value Whether or not to enable the database. Default: true
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function enable_database($value = true)
  {
    
    $this->use_database = !!$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set whether multi-site support should be enabled or not.
   * @param boolean $value Whether or not to enable multi-site support. Default: true
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function enable_multisite($value = true)
  {
    
    $this->use_multisite = !!$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set whether debugging should be enabled or not.
   * @param boolean $value Whether or not to enable debugging. Default: true
   * @return \dependencies\init\Initializer This instance, for chaining.
   */
  public function enable_debugging($value = true)
  {
    
    $this->debugging = !!$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Runs the selected environment with the current settings.
   * @return void
   */
  public function run_environment()
  {
    
    if(!isset($this->environment))
      throw new \Exception('No environment set. Please set or detect the environment.');
    
    //Do this for any environment.
    Defines::persistent_defines();
    Tasks::apply_debugging($this->debugging);
    Tasks::load_configuration_files($this->root, $this->is_installed, $this->use_database);
    
    //Get the site properties.
    $site = Tasks::get_site_properties(
      $this->get_url_path(),
      $this->is_installed(),
      $this->use_database,
      $this->use_multisite
    );
    
    //Whether we're using HTTPS this run or not.
    $https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on';
    
    //Proceed with global initialization logic.
    Defines::map_values($site, $https, $this->is_installed(), $this->debugging);
    Tasks::load_functions();
    
    //Load site information into core class
    mk('Site')->_load($site);
    
    //Environment specific things.
    Environments::on_run($this, $this->environment);
    
  }
  
  /**
   * Detects whether this runtime has been installed.
   * @return boolean Whether this runtime has been installed.
   */
  public function is_installed()
  {
    
    //Check for cached values.
    if(isset($this->is_installed))
      return $this->is_installed;
    
    //Find out and cache.
    $this->is_installed = @is_file($this->root.'mokuji'.DS.'.completed-install');
    
    //Return value.
    return $this->is_installed;
    
  }
  
  /**
   * A getter for the URL path. If no override is set this will try to detect it.
   * @return string The currently assumed URL path.
   */
  public function get_url_path()
  {
    
    //Use the override/cache when available.
    if(isset($this->url_path)){
      $url_path = $this->url_path;
    }
    
    //Otherwise detect, assuming index.php is used from the root.
    else{
      
      $url_path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
      
      if(strlen($url_path) > 0 && $url_path[0] === '/')
        $url_path = substr($url_path, 1);
      
      $this->url_path = $url_path;
      
    }
    
    return $this->url_path;
    
  }
  
}