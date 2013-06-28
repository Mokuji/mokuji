<?php namespace dependencies\init;

/**
 * A static class that performs atomic tasks to initialize Mokuji.
 */
abstract class Tasks
{
  
  /**
   * Apply the implications of enabling or disabling debugging.
   * @param boolean $debugging Whether or not debugging has been enabled.
   * @return void
   */
  public static function apply_debugging($debugging)
  {
    
    //When debugging is enabled.
    if($debugging){
      ini_set('display_errors', 1);
      error_reporting(E_ALL|E_STRICT);
    }
    
    //When debugging is disabled.
    else{
      ini_set('display_errors', 0);
      error_reporting(E_ALL^E_STRICT);
    }
    
  }
  
  /**
   * Loads the configuration files that apply to the current initialization settings.
   * @param string $root The path to the base of the installation.
   * @param boolean $is_installed Whether or not the installation has been flagged as completely installed.
   * @param boolean $use_database Whether or not to use the database this page load.
   * @return void
   */
  public static function load_configuration_files($root, $is_installed, $use_database)
  {
    
    if($is_installed){
      
      require_once($root.'mokuji'.DS.'config'.DS.'email.php');
      
      if($use_database){
        require_once($root.'mokuji'.DS.'config'.DS.'database.php');
      }
      
    }
    
    require_once($root.'mokuji'.DS.'config'.DS.'miscelanious.php');
    
  }
  
  /**
   * Performs a lookup for the site properties based on the Initializer configuration.
   * @param string $url_path The url_path override given to Initializer.
   * @param boolean $is_installed Whether or not Mokuji has been marked as installed.
   * @param boolean $use_database Whether or not the database should be used this page load.
   * @param boolean $use_multisite Whether or not multi-site support should be provided.
   * @return \stdClass A class containing the sites properties.
   */
  public static function get_site_properties($url_path, $is_installed, $use_database, $use_multisite)
  {
    
    //When running multi-site, try to do this properly.
    if($is_installed && $use_multisite){
      
      if(!$use_database)
        throw new \Exception('Using multi-site support requires the database to be enabled.');
      
      //Create a temporary connection to find the site information.
      $mysqlConnection = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
      
      if(!$mysqlConnection)
        throw new \Exception('Unable to connect to database to find site information.');
      
      if(!mysql_select_db(DB_NAME, $mysqlConnection))
        throw new \Exception('Unable to select database to find site information.');
      
      //Fetch the site settings.
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
        throw new \Exception('Failed to load website properties: '.@mysql_error($mysqlConnection));
      
      if(mysql_num_rows($result) === 0)
        throw new \Exception('No site properties found for domain "'.$_SERVER['HTTP_HOST'].'" and url_path "'.$url_path.'". '.@mysql_error($mysqlConnection));
      
      $site = mysql_fetch_object($result);
      mysql_close($mysqlConnection);
      
      return $site;
      
    }
    
    //No multi-site till we did an install.
    elseif($use_multisite){
      throw new \Exception('Using multi-site support requires Mokuji to be installed.');
    }
    
    //Fallback option (while installing, or not multi-site).
    $site = new \stdClass();
    $site->id = 0;
    $site->path_base = $_SERVER['DOCUMENT_ROOT'];
    $site->url_path = $url_path;
    
    return $site;
    
  }
  
  /**
   * Loads all the system functions.
   * @return void
   */
  public static function load_functions()
  {
    
    foreach(glob(PATH_SYSTEM_FUNCTIONS.DS.'[a-z_]*'.EXT) as $functions)
      require_once($functions);
    
  }
  
  /**
   * Register error handlers for errors and exceptions.
   * @return void
   */
  public static function register_error_handlers()
  {
    
    #TODO: May want to make this configurable for ENV_SHELL and images.
    set_error_handler('error_handler');
    set_exception_handler('exception_handler');
    
  }
  
  /**
   * Performs any fixes needed for proper HTTP(S) functioning.
   * @return void
   */
  public static function http_fixes()
  {
    
    /* http://adamyoung.net/IE-Blocking-iFrame-Cookies */
    header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
    
  }
  
}