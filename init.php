<?php if(!isset($error_handler)) die('No direct access.');

//debug mode if not overwritten by $_GET['debug']
$debug = true;

//define delimiter sign
define('DS', '/');

//define default file-extension
define('EXT', '.php');

//define Tuxion to be true, very useful, obviously the system doesn't work if this is false
define('TX', true);

//define debug mode
define('DEBUG', (array_key_exists('debug', $_GET) && $_GET['debug']==='0' ? false : $debug));

//unset debug related vars
unset($debug, $_GET['debug']);

//set default timezone
date_default_timezone_set('Europe/Amsterdam');

//display errors if debug is true
ini_set('display_errors', (int)DEBUG);
error_reporting(E_ALL|E_STRICT);

header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');/* http://adamyoung.net/IE-Blocking-iFrame-Cookies */
//load config files
if(INSTALLING !== true){
  require_once('config'.DS.'database'.EXT);
  require_once('config'.DS.'email'.EXT);
}
require_once('config'.DS.'exceptions'.EXT);
require_once('config'.DS.'miscelanious'.EXT);

//get current site info when not in install mode
if(INSTALLING !== true)
{
  
  //Allow url-path overrides from other scripts.
  if(isset($_SERVER['x-tx-urlpath'])){
    $url_path = $_SERVER['x-tx-urlpath'];
  }
  
  //When no override is used.
  else{
    $url_path = str_replace('/index.php', '', str_replace('/admin/index.php', '', $_SERVER['PHP_SELF']));
    if(isset($url_path[0]) && $url_path[0] === '/'){ //Not an array, but first string character.
      $url_path = substr($url_path, 1);
    }
  }

  $mysqlConnection = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("MySQL Connection failed to establish");
  
  mysql_select_db(DB_NAME, $mysqlConnection);
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
    die('Failed to load website settings.'.n.@mysql_error($mysqlConnection));

  if(mysql_num_rows($result) === 0)
    die('No site settings found for domain "'.$_SERVER['HTTP_HOST'].'" and url_path "'.$url_path.'".'.n.@mysql_error($mysqlConnection));
  
  $site = mysql_fetch_object($result);
  mysql_close($mysqlConnection);
  
}

//When installing, just assume current site is the default.
else {
  
  $site = new \stdClass();
  $site->id = 0;
  $site->path_base = $_SERVER['DOCUMENT_ROOT'];
  $site->url_path = str_replace('/install/index.php', '', $_SERVER['PHP_SELF']);
  
  if($site->url_path && $site->url_path[0] === '/')
    $site->url_path = substr($site->url_path, 1);
  
}

//Whether we're using HTTPS this pageload or not.
$https = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on';

//set paths based on current site
define('URL_PATH', $site->url_path);

define('PATH_BASE', $site->path_base.(URL_PATH ? '/'.URL_PATH : ''));
define('PATH_SITE', PATH_BASE.DS.'site');
define('PATH_PLUGINS', PATH_BASE.DS.'plugins');
define('PATH_LIBS', PATH_BASE.DS.'libraries');
define('PATH_LOGS', PATH_BASE.DS.'logs');

define('PATH_COMPONENTS', PATH_SITE.DS.'components');
define('PATH_TEMPLATES', PATH_SITE.DS.'templates');
define('PATH_THEMES', PATH_SITE.DS.'themes');
define('PATH_INCLUDES', PATH_SITE.DS.'includes');
define('PATH_SYSTEM', PATH_SITE.DS.'system');
define('PATH_HELPERS', PATH_SITE.DS.'helpers');

define('PATH_SYSTEM_CORE', PATH_SYSTEM.DS.'core');
define('PATH_SYSTEM_DEPENDENCIES', PATH_SYSTEM.DS.'dependencies');
define('PATH_SYSTEM_EXCEPTIONS', PATH_SYSTEM.DS.'exceptions');

define('URL_BASE', ($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.(URL_PATH ? URL_PATH.'/' : ''));
define('URL_SITE', URL_BASE.'site/');
define('URL_PLUGINS', URL_BASE.'plugins/');
define('URL_LIBS', URL_BASE.'libraries/');

define('URL_COMPONENTS', URL_SITE.'components/');
define('URL_TEMPLATES', URL_SITE.'templates/');
define('URL_THEMES', URL_SITE.'themes/');
define('URL_INCLUDES', URL_SITE.'includes/');

//load helpers
foreach(glob(PATH_HELPERS.DS.'[a-z_]*'.EXT) as $helper) require_once($helper); unset($helper);

//set error handler
set_error_handler($error_handler); unset($error_handler);

//set exception handler
set_exception_handler($exception_handler); unset($exception_handler);

//system core
require_once(PATH_SITE.DS.'tx.cms'.DS.'cms'.EXT);

//load site information into core class
tx('Site')->_load($site);
