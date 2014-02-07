<?php namespace dependencies\init;

/**
 * A static class that allows you to initialize Mokuji defines.
 */
abstract class Defines
{
  
  /**
   * Initializes the persistent defined values.
   * They are the ones that don't change at all.
   * @return void
   */
  public static function persistent_defines()
  {
    
    define('MK', true);       //Everyone should know we have arrived.
    define('TX', true);       //Backwards compatibility.
    
    define('DS', '/');        //Delimiter sign.
    define('EXT', '.php');    //Default file-extension.
    
    define('br', "<br />\n"); //Anti-boredom snippet.
    define('n', "\n");        //Anti-boredom snippet.
    define('t', "  ");        //Anti-laziness snippet.
    
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
    
  }
  
  
  /**
   * Initializes the mapped defined values.
   * They are the ones that may differ per page load.
   * @return void
   */
  public static function map_values($site, $https, $is_installed, $debugging)
  {
    
    define('INSTALLING', !$is_installed);
    define('DEBUG', !!$debugging);
    
    //Set paths based on current site
    define('URL_PATH', $site->url_path);
    
    define('PATH_BASE', $site->path_base.(URL_PATH ? '/'.URL_PATH : ''));
    define('PATH_FRAMEWORK', PATH_BASE.DS.'mokuji');
    
    define('PATH_PLUGINS', PATH_FRAMEWORK.DS.'plugins');
    define('PATH_COMPONENTS', PATH_FRAMEWORK.DS.'components');
    define('PATH_TEMPLATES', PATH_FRAMEWORK.DS.'templates');
    define('PATH_THEMES', PATH_FRAMEWORK.DS.'themes');
    define('PATH_SYSTEM', PATH_FRAMEWORK.DS.'system');
    define('PATH_LOGS', PATH_FRAMEWORK.DS.'logs');
    
    define('PATH_SYSTEM_ASSETS', PATH_SYSTEM.DS.'assets');
    define('PATH_SYSTEM_FUNCTIONS', PATH_SYSTEM.DS.'functions');
    define('PATH_SYSTEM_CORE', PATH_SYSTEM.DS.'core');
    define('PATH_SYSTEM_DEPENDENCIES', PATH_SYSTEM.DS.'dependencies');
    define('PATH_SYSTEM_EXCEPTIONS', PATH_SYSTEM.DS.'exceptions');
    
    //Problematic for CLI.
    if(isset($_SERVER['HTTP_HOST'])){
      define('URL_BASE', ($https ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.(URL_PATH ? URL_PATH.'/' : ''));
      define('URL_FRAMEWORK', URL_BASE.'mokuji/');
      
      define('URL_PLUGINS', URL_FRAMEWORK.'plugins/');
      define('URL_COMPONENTS', URL_FRAMEWORK.'components/');
      define('URL_TEMPLATES', URL_FRAMEWORK.'templates/');
      define('URL_THEMES', URL_FRAMEWORK.'themes/');
      define('URL_SYSTEM_ASSETS', URL_FRAMEWORK.'system/assets/');
    }
    
    //Backwards compatibility. Best not use them.
    define('PATH_INCLUDES', PATH_SYSTEM_ASSETS);
    define('PATH_HELPERS', PATH_SYSTEM_FUNCTIONS);
    
    if(isset($_SERVER['HTTP_HOST'])){
      define('URL_INCLUDES', URL_SYSTEM_ASSETS);
    }
    
  }
  
}