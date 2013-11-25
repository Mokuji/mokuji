<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

#TODO: Make an attempt to correct the urlKey based on the page ID?

/**
 * An abstract URL format factory.
 * Detects, validates and formats various URLs.
 */
abstract class UrlFormatFactory
{
  
  /**
   * Formats a given URL to the preferred format.
   * @param  mixed $url The URL to format. Must be either string or UrlFormat.
   * @param  boolean &$cast A boolean that indicates whether or not the URL has been cast in a new format.
   * @param  boolean &$homepage Whether or not the URL got defaulted to to the homepage.
   * @return UrlFormat The format class handling this URL.
   */
  public static function format($url, &$cast=null, &$homepage=null)
  {
    
    //Let the detector validate and parse the data.
    $format = self::detect($url, $homepage);
    
    //Cast it to the preferred format, if needed.
    $formatClass = self::getPrefferedFormatClassName();
    $cast = get_class($format) !== $formatClass;
    if($cast){
      $format = new $formatClass($format);
    }
    
    return $format;
    
  }
  
  /**
   * Detects the URL format of the provided URL.
   * @param  mixed $url The URL to detect the format of. Must be either string or UrlFormat.
   * @param  boolean &$homepage Whether or not the URL got defaulted to the homepage.
   * @return UrlFormat The format class handling this URL.
   */
  public static function detect($url, &$homepage=null)
  {
    
    raw($url);
    
    $homepage = false;
    
    //What was passed is already formatted.
    if($url instanceof UrlFormat)
      return $url;
    
    //Check data type.
    if(!is_string($url))
      throw new \exception\InvalidArgument('The URL must be a string or UrlFormat instance.');
    
    //Parse the URL for it's query string data.
    $urlObj = url($url);
    $urlData = $urlObj->data;
    
    //See if it's legacy formatted early on.
    //This prevents /?pid=1 from being seen as / and referring to the homepage.
    if($urlData->pid->is_set() && LegacyUrlFormat::validate($url))
      return new LegacyUrlFormat($url);
    
    //Strips the query string if any.
    $base_url = explode('?', $url)[0];
    
    //If we are loading the homepage, recurse.
    if($base_url === '/'){
      $homepage = true;
      return UrlFormatFactory::detect(mk('Config')->user('homepage')->get());
    }
    
    //Detect in order of likeliness that it is used.
    if(SimpleKeysUrlFormat::validate($base_url))
      return new SimpleKeysUrlFormat($base_url);
    
    if(LanguageAndKeysUrlFormat::validate($base_url))
      return new LanguageAndKeysUrlFormat($base_url);
    
    if(IdBasedUrlFormat::validate($base_url))
      return new IdBasedUrlFormat($base_url);
    
    //Legacy format should keep the query string.
    if(LegacyUrlFormat::validate($url))
      return new LegacyUrlFormat($url);
    
    //Don't attempt any fallback methods when the format is unknown.
    throw new \exception\InvalidArgument('The provided URL does not match any known format.');
    
  }
  
  /**
   * Validates the provided URL for formatting errors.
   * @param  mixed $url The URL to validate the format of. Must be either string or UrlFormat.
   * @return boolean Whether or not the format was valid.
   */
  public static function validate($url)
  {
    
    raw($url);
    
    //UrlFormats may not let the constructor complete for incorrectly formatted things.
    //Therefore instances are always valid.
    if($url instanceof UrlFormat)
      return true;
    
    //Check data type.
    if(!is_string($url))
      throw new \exception\InvalidArgument('The URL must be a string or UrlFormat instance.');
    
    //Strips the query string if any.
    $base_url = explode('?', $url)[0];
    $urlObj = url($url);
    $urlData = $urlObj->data;
    
    //If a PID is set in the GET parameters, try and validate it as legacy first.
    if($urlData->pid->is_set() && LegacyUrlFormat::validate($url))
      return true;
    
    //Validate in order of likeliness that it is used.
    return
      SimpleKeysUrlFormat::validate($url) ||
      LanguageAndKeysUrlFormat::validate($url) ||
      IdBasedUrlFormat::validate($url) ||
      LegacyUrlFormat::validate($url);
    
  }
  
  private static function getPrefferedFormatClassName(){
    switch(mk('Config')->user('cms_url_format')->get()){
      default:
      case 'SIMPLE_KEYS':       return 'components\\cms\\routing\\SimpleKeysUrlFormat';
      case 'LANGUAGE_AND_KEYS': return 'components\\cms\\routing\\LanguageAndKeysUrlFormat';
      case 'ID_BASED':          return 'components\\cms\\routing\\IdBasedUrlFormat';
      case 'LEGACY':            return 'components\\cms\\routing\\LegacyUrlFormat';
    }
  }
  
}