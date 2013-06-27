<?php namespace dependencies;

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
   * The instance of this class.
   * @var \dependencies\Initializer
   */
  private static $instance;
  
  /**
   * Gets the instance of this class.
   * @return \dependencies\Initializer The instance of this class.
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
   * @return \dependencies\Initializer This instance, for chaining.
   */
  public function set_root($value='')
  {
    
    $this->root = (string)$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set the desired environment type.
   * @param integer $environment The environment to set.
   * @return \dependencies\Initializer This instance, for chaining.
   */
  public function set_environment($environment)
  {
    
    switch($environment){
      
      #TODO: Build shell support.
      case Initializer::ENV_SHELL:
        throw new \Exception('The shell environment is not supported yet. If you have a usecase for it, please tell us.');
      
      //Frontend and backend currently have no requirements.
      case Initializer::ENV_FRONTEND:
      case Initializer::ENV_BACKEND:
        $this->environment = $environment;
        break;
      
      default:
        throw new \Exception('Unknown environment: '.$environment);
      
    }
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set the url_path if it is not the default.
   * @param string $value The url_path to assume of the environment.
   * @return \dependencies\Initializer This instance, for chaining.
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
   * @return \dependencies\Initializer This instance, for chaining.
   */
  public function enable_database($value = true)
  {
    
    $this->use_database = !!$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set whether multi-site support should be enabled or not.
   * @param boolean $value Whether or not to enable multi-site support. Default: true
   * @return \dependencies\Initializer This instance, for chaining.
   */
  public function enable_multisite($value = true)
  {
    
    $this->use_multisite = !!$value;
    
    return $this; //Chaining.
    
  }
  
  /**
   * Allows you to set whether debugging should be enabled or not.
   * @param boolean $value Whether or not to enable debugging. Default: true
   * @return \dependencies\Initializer This instance, for chaining.
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
    $this
      ->define_persistent_values()
      ->apply_debug()
      ->load_config();
    
    $site = $this->get_site_settings();
    
    $this
      ->map_path_definitions($site)
      ->load_functions()
      ->register_error_handlers()
      ->apply_site_settings($site);
    
    //Environment specific things.
    switch($this->environment){
      
      case Initializer::ENV_FRONTEND:
        $this->http_fixes();
        
        mk('Session');    //start session
        
        //config
        mk('Config')->system('backend', false);
        mk('Config')->system('component', 'cms');
        
        mk('Url');        //initiate url class
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Frontend Pageload', mk('Url')->url->input, true);
        
        mk('Account');    //check account details and progress user activity
        mk('Data');       //start filtering data
        mk('Language');   //set language
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Frontend Pageload', 'SUCCEEDED');
        
        break;
      
      case Initializer::ENV_BACKEND:
        $this->http_fixes();
        
        mk('Session');    //start session
        
        //config
        mk('Config')->system('backend', true);
        mk('Config')->system('component', 'cms');
        
        mk('Url');        //initiate url class
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Backend Pageload', mk('Url')->url->input, true);
        
        mk('Account');    //check account details and progress user activity
        mk('Data');       //start filtering data
        mk('Language');   //set language
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Backend Pageload', 'SUCCEEDED');
        
        break;
      
    }
    
  }
  
  /**
   * Detects whether this runtime has been installed.
   * @return boolean Whether this runtime has been installed.
   */
  public function is_installed()
  {
    
    if(isset($this->is_installed))
      return $this->is_installed;
    
    $this->is_installed = @is_file($this->root.'mokuji'.DS.'.completed-install');
    
    return $this->is_installed;
    
  }
  
  private function define_persistent_values()
  {
    
    define('MK', true);       //Everyone should know we have arrived.
    define('TX', true);       //Backwards compatibility.
    
    define('DS', '/');        //Delimiter sign.
    define('EXT', '.php');    //Default file-extension.
    
    define('br', "<br />\n"); //Anti-boredom snippet.
    define('n', "\n");        //Anti-boredom snippet.
    define('t', "  ");        //Anti-laziness snippet.
    
    //Default timezone.
    date_default_timezone_set('Europe/Amsterdam');
    
    //For lack of a better place to do this.
    define('INSTALLING', !$this->is_installed());
    
    //God knows why we ever did this. Removing ASAP.
    define('EX_ERROR', 1);
    define('EX_EXCEPTION', 2);
    define('EX_EXPECTED', 4);
    define('EX_UNEXPECTED', 8);
    define('EX_AUTHORISATION', 16);
    define('EX_EMPTYRESULT', 32);
    define('EX_VALIDATION', 64);
    define('EX_USER', 128);
    define('EX_PROGRAMMER', 256);
    define('EX_SQL', 512);
    define('EX_CONNECTION', 1024);
    define('EX_INVALIDARGUMENT', 2048);
    define('EX_DEPRECATED', 4096);
    define('EX_RESTRICTION', 8192);
    define('EX_NOTFOUND', 16384);
    define('EX_FILEMISSING', 32768);
    define('EX_INPUTMISSING', 65536);
    define('EX_MODEL_VALIDATION', 131072);
    
    return $this; //Chaining.
    
  }
  
  private function apply_debug()
  {
    
    //When debugging is enabled.
    if($this->debugging){
      define('DEBUG', true);
      ini_set('display_errors', 1);
      error_reporting(E_ALL|E_STRICT);
    }
    
    //When debugging is disabled.
    else{
      define('DEBUG', false);
      ini_set('display_errors', 0);
      error_reporting(E_ALL^E_STRICT);
    }
    
    return $this; //Chaining.
    
  }
  
  private function load_config()
  {
    
    if($this->is_installed()){
      
      require_once($this->root.'mokuji'.DS.'config'.DS.'email.php');
      
      if($this->use_database){
        require_once($this->root.'mokuji'.DS.'config'.DS.'database.php');
      }
      
    }
    
    require_once($this->root.'mokuji'.DS.'config'.DS.'miscelanious.php');
    
    return $this; //Chaining.
    
  }
  
  private function get_url_path()
  {
    
    //Use the override when available.
    if(isset($this->url_path)){
      $url_path = $this->url_path;
    }
    
    //Otherwise detect, assuming index.php is used from the root.
    else{
      
      $url_path = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
      
      if(strlen($url_path) > 0 && $url_path[0] === '/')
        $url_path = substr($url_path, 1);
      
    }
    
    return $url_path;
    
  }
  
  private function get_site_settings()
  {
    
    //When running multi-site, try to do this properly.
    if($this->is_installed() && $this->use_multisite){
      
      if(!$this->use_database)
        throw new \Exception('Using multi-site support requires the database to be enabled.');
      
      //Create a temporary connection to find the site information.
      $mysqlConnection = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
      
      if(!$mysqlConnection)
        throw new \Exception('Unable to connect to database to find site information.');
      
      if(!mysql_select_db(DB_NAME, $mysqlConnection))
        throw new \Exception('Unable to select database to find site information.');
      
      $url_path = $this->get_url_path();
      
      $result = mysql_query(
        "SELECT s.*, d.`domain`".
        "FROM `".DB_PREFIX."core_sites` s ".
          "JOIN `".DB_PREFIX."core_site_domains` d ON s.id = d.site_id ".
        "WHERE (d.`domain`='{$_SERVER['HTTP_HOST']}' OR d.`domain`='*') ".
          "AND s.`url_path`='$url_path' ".
        "ORDER BY `domain` DESC ".
        "LIMIT 1",
        $mysqlConnection);
      
      if($result === false)
        throw new \Exception('Failed to load website settings: '.@mysql_error($mysqlConnection));
      
      if(mysql_num_rows($result) === 0)
        throw new \Exception('No site settings found for domain "'.$_SERVER['HTTP_HOST'].'" and url_path "'.$url_path.'". '.@mysql_error($mysqlConnection));
      
      $site = mysql_fetch_object($result);
      mysql_close($mysqlConnection);
      
      return $site;
      
    }
    
    //No multi-site till we did an install.
    elseif($this->use_multisite){
      throw new \Exception('Using multi-site support requires Mokuji to be installed.');
    }
    
    //Fallback option (while installing, or not multi-site).
    $site = new \stdClass();
    $site->id = 0;
    $site->path_base = $_SERVER['DOCUMENT_ROOT'];
    $site->url_path = $this->get_url_path();
        
    return $site;
    
  }
  
  private function map_path_definitions($site)
  {
    
    //Whether we're using HTTPS this run or not.
    $https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on';
    
    //Set paths based on current site
    define('URL_PATH', $site->url_path);
    
    define('PATH_BASE', $site->path_base.(URL_PATH ? '/'.URL_PATH : ''));
    define('PATH_PLUGINS', PATH_BASE.DS.'mokuji'.DS.'plugins');
    define('PATH_COMPONENTS', PATH_BASE.DS.'mokuji'.DS.'components');
    define('PATH_TEMPLATES', PATH_BASE.DS.'mokuji'.DS.'templates');
    define('PATH_THEMES', PATH_BASE.DS.'mokuji'.DS.'themes');
    define('PATH_SYSTEM', PATH_BASE.DS.'mokuji'.DS.'system');
    define('PATH_LOGS', PATH_BASE.DS.'mokuji'.DS.'logs');
    
    define('PATH_SYSTEM_ASSETS', PATH_SYSTEM.DS.'assets');
    define('PATH_SYSTEM_FUNCTIONS', PATH_SYSTEM.DS.'functions');
    define('PATH_SYSTEM_CORE', PATH_SYSTEM.DS.'core');
    define('PATH_SYSTEM_DEPENDENCIES', PATH_SYSTEM.DS.'dependencies');
    define('PATH_SYSTEM_EXCEPTIONS', PATH_SYSTEM.DS.'exceptions');
    
    define('URL_BASE', ($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.(URL_PATH ? URL_PATH.'/' : ''));
    define('URL_PLUGINS', URL_BASE.'mokuji/plugins/');
    define('URL_COMPONENTS', URL_BASE.'mokuji/components/');
    define('URL_TEMPLATES', URL_BASE.'mokuji/templates/');
    define('URL_THEMES', URL_BASE.'mokuji/themes/');
    define('URL_SYSTEM_ASSETS', URL_BASE.'mokuji/system/assets/');
    
    //Backwards compatibility. Best not use them.
    define('PATH_INCLUDES', PATH_SYSTEM_ASSETS);
    define('PATH_HELPERS', PATH_SYSTEM_FUNCTIONS);
    define('URL_INCLUDES', URL_SYSTEM_ASSETS);
    
    return $this; //Chaining.
    
  }
  
  private function load_functions()
  {
    
    foreach(glob(PATH_SYSTEM_FUNCTIONS.DS.'[a-z_]*'.EXT) as $functions) require_once($functions); unset($functions);
    
    return $this; //Chaining.
    
  }
  
  private function register_error_handlers()
  {
    
    #TODO: May want to make this configurable for ENV_SHELL and images.
    set_error_handler('error_handler');
    set_exception_handler('exception_handler');
    
    return $this; //Chaining.
    
  }
  
  private function apply_site_settings($site)
  {
    
    //Load site information into core class
    mk('Site')->_load($site);
    
    return $this; //Chaining.
    
  }
  
  private function http_fixes()
  {
    header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');/* http://adamyoung.net/IE-Blocking-iFrame-Cookies */
  }
  
}