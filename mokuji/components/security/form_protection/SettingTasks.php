<?php namespace components\security\form_protection; if(!defined('MK')) die('No direct access.');

/**
 * Handles all settings logic, to abstract the process.
 */
abstract class SettingTasks
{
  
  /**
   * Cache our results so we only load the settings once.
   * @var array
   */
  private static $settings;
  
  /**
   * Get all the currently applying settings and their values.
   * @return array
   */
  public static function getSettings()
  {
    
    //When cached...
    if(isset(self::$settings))
      return self::$settings;
    
    //Start with the defaults.
    $settings = SettingTasks::getDefaultSettings();
    
    //Then loop them all to check our config values.
    foreach($settings as $key => $value)
    {
      
      //Look for a setting in our core config tables.
      $userSetting = mk('Config')->user(sprintf('security.form_protection.%s', $key));
      
      //If it's found, override the defaults.
      if($userSetting->is_set())
        $settings[$key] = $userSetting->get();
      
    }
    
    self::$settings = $settings;
    return $settings;
    
  }
  
  /**
   * Locates and loads the default settings.
   * @return array
   */
  public static function getDefaultSettings()
  {
    
    try{
      $json = @file_get_contents(PATH_FRAMEWORK.DS.'config'.DS.'form_protection_defaults.json');
      return json_decode($json, true);
    }
    
    catch(\Exception $ex){
      mk('Logging')->log('Security', 'Form protection', 'Error loading default form protection settings file.');
      throw $ex;
    }
    
  }
  
}