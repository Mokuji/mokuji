<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

/**
 * The legacy URL format class.
 * Example: /index.php?pid=1
 * Detects, validates and formats various URLs.
 */
class LegacyUrlFormat extends UrlFormat
{
  
  const REGEX = '~^/?(index\.php)?(\?[^\?]*)?$~';
  
  /**
   * Validates the provided URL for formatting errors.
   * @param  string $url The URL to validate the format of.
   * @return boolean Whether or not the format was valid.
   */
  public static function validate($url)
  {
    
    //Instances of UrlFormat are always fine.
    if($url instanceof UrlFormat)
      return true;
    
    //Loading the homepage is always fine.
    if($url === '/')
      return true;
    
    //Check the URL contents.
    if(preg_match(self::REGEX, $url) !== 1)
      return false;
    
    //All good!
    return true;
    
  }
  
  /**
   * Creates a new instance.
   * @param string $url The URL to handle.
   */
  public function __construct($url)
  {
    
    //Instances of UrlFormat are an easy source.
    if($url instanceof UrlFormat){
      $this->fromUrlFormat($url);
      return;
    }
    
    //Just to make sure.
    if(!self::validate($url))
      throw new \exception\InvalidArgument('The URL has an invalid format. Try detecting the format instead.');
    
    //First try the URL as the page ID source.
    $urlObj = url($url);
    $urlData = $urlObj->data;
    $this->pageId = $urlData->pid->get('int');
    
    //If we have a page ID, we can attempt to extract the extensions the same way.
    if($this->pageId > 0){
      
      //Split the extensions by slashes.
      $this->urlExtensions = $this->parseUrlExtensions($urlData->pkey_ext);
      
    }
    
    //If the page ID is not provided, assume the intent is to refer to the homepage.
    else{
      $this->useHomepage();
    }
    
  }
  
  /**
   * Outputs the current URL data into the format the class provides.
   * @param array $getData The GET data to append to the URL when outputting
   * @return string A formatted version of the URL data.
   */
  public function output($getData=null)
  {
    
    $QS = Data($getData)->without('pid', 'pkey', 'pkey_ext');
    $QS->merge(array('pid' => $this->pageId));
    
    $url_key = $this->getUrlKey();
    if(!empty($url_key))
      $QS->merge(array('pkey' => $this->getUrlKey()));
    
    $url_extensions = $this->urlExtensions;
    if(!empty($url_extensions))
      $QS->merge(array('pkey_ext' => implode('/', $this->urlExtensions)));
    
    return URL_BASE."index.php?".http_build_query($QS->as_array(), null, '&');
    
  }
  
  /**
   * Overrides the default getter. Finds the URL-key from the database.
   * @return string
   */
  public function getUrlKey(){
    
    if($this->urlKey)
      return $this->urlKey;
    
    $id = $this->pageId;
    
    $this->urlKey = mk('Sql')->table('cms', 'Pages')
      ->pk($id)
      ->execute_single()
      ->info->{mk('Language')->id}
      ->is('empty', function($thingy)use($id){
        throw new \exception\NotFound('Could not find a page with ID '.$id.'.');
      })->url_key->get('string');
    
    return $this->urlKey;
    
  }
  
}