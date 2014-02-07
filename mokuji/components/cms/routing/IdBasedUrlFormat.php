<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

/**
 * The ID based URL format class.
 * Example: /1/about
 * Detects, validates and formats various URLs.
 */
class IdBasedUrlFormat extends UrlFormat
{
  
  const REGEX = '~^/(\d+)(/([\w\-]*))?(/([\w\-\/]*))?(\.html|/)?$~';
  
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
    if(preg_match(self::REGEX, $url, $matches) !== 1)
      return false;
    
    //Now see if the matched ID is any good.
    if(intval($matches[1]) <= 0)
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
    
    //If this is the homepage, don't attempt to parse.
    if($url === '/'){
      $this->useHomepage();
    }
    
    //When it's not the homepage, extract the data from the URL.
    else
    {
      
      //Extract data using the regular expression. Don't error check, because validate() was called.
      @preg_match(self::REGEX, $url, $matches);
      
      //Take the URL information.
      $this->pageId = intval($matches[1]);
      
      if(isset($matches[5]))
        $this->urlExtensions = $this->parseUrlExtensions($matches[5]);
      
    }
    
  }
  
  /**
   * Outputs the current URL data into the format the class provides.
   * @param array $getData The GET data to append to the URL when outputting
   * @return string A formatted version of the URL data.
   */
  public function output($getData=null)
  {
    
    
    $url = URL_BASE.$this->pageId;
    
    if($this->getUrlKey())
    {
      
      $url .= '/'.$this->getUrlKey();
      
      if(count($this->urlExtensions) > 0){
        $url .= '/'.implode('/', $this->urlExtensions);
      }
      
    }
    
    //Add GET data.
    $QS = Data($getData)->without('pid', 'pkey', 'pkey_ext')->as_array();
    if(count($QS) > 0)
      $url .= '?'.http_build_query($QS, null, '&');
    
    return $url;
    
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