<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

/**
 * The language and keys URL format class.
 * Example: /en/about
 * Detects, validates and formats various URLs.
 */
class LanguageAndKeysUrlFormat extends UrlFormat
{
  
  const REGEX = '~^/([A-Za-z]{2})(/([\w\-]{3,}))?(/([\w\/\-]*))?$~';
  
  /**
   * Caches the page ID matches for different URL-keys.
   * Array keys are lowercase URL-keys. Values are page IDs (integer).
   * @var array
   */
  protected static $urlKeyMatches = array();
  
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
    
    //Loading the homepage with just a language shortcode is fine as well.
    //Note: this requires the URL extensions to be empty as well.
    if(empty($matches[2]) && empty($matches[5])){
      return true;
    }
    
    //The URL-key should not be null if the URL extensions IS set.
    elseif(empty($matches[3])){
      return false;
    }
    
    //The matched URL-key should not be an integer.
    if((string)intval($matches[3]) === (string)$matches[3])
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
      
      //Should the URL-key be left unset, use the homepage in the targeted language.
      if(!isset($matches[3]) || empty($matches[3]))
      {
        $this->useHomepage();
      }
      
      //Otherwise take the data from the URL.
      else
      {
        
        if(isset($matches[3]))
          $this->urlKey = trim($matches[3]);
        
        if(isset($matches[5]))
          $this->urlExtensions = $this->parseUrlExtensions($matches[5]);
        
      }
      
      //Take the URL's language.
      $this->languageId = $this->shortcodeToId($matches[1]); //Doing this validates the shortcode.
      $this->languageShortcode = strtoupper($matches[1]);
      
      /*
        The page ID is not provided by the URL format.
        Instead the getPageId() function locates the page based on the urlKey.
      */
      
    }
    
  }
  
  /**
   * Outputs the current URL data into the format the class provides.
   * @param array $getData The GET data to append to the URL when outputting
   * @return string A formatted version of the URL data.
   */
  public function output($getData=null)
  {
    
    if($this->getLanguageShortcode())
      $short = $this->getLanguageShortcode();
    else
      $short = $this->idToShortcode(mk('Language')->id);
    
    $url = URL_BASE.strtolower($short);
    
    if($this->urlKey)
    {
      
      $url .= '/'.$this->urlKey;
      
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
   * Overrides the standard getter.
   * Attempts to locate the page based on the current URL-key and globally caches the results.
   * @return integer
   */
  public function getPageId()
  {
    
    //Perhaps a different source already cached this for us.
    if($this->pageId)
      return $this->pageId;
    
    $key = strtolower($this->getLanguageShortcode()).'/'.strtolower($this->urlKey);
    
    //If the results are cached, use that.
    if(array_key_exists($key, self::$urlKeyMatches))
      return self::$urlKeyMatches[$key];
    
    //Detect page
    $matches = mk('Sql')->table('cms', 'PageInfo')
      ->where('language_id', mk('Sql')->escape($this->getLanguageId()))
      ->where('LOWER(`url_key`)', mk('Sql')->escape(strtolower($this->urlKey)))
      ->order('page_id')
      ->execute();
    
    //No matches means we can't find a page.
    if($matches->size() === 0){
      throw new \exception\NotFound('Could not find a page for this language and URL key.');
    }
    
    //One match makes life easy.
    elseif($matches->size() === 1){
      self::$urlKeyMatches[$key] = $matches->{0}->page_id->get('int');
    }
    
    //Apparently we have a URL-key that points to multiple pages.
    else
    {
      
      //Arbitrarily pick the one with the lowest ID and notify an Admin of the problem.
      self::$urlKeyMatches[$key] = $matches->{0}->page_id->get('int');
      
      #TODO: Notify admin of this problem.
      
    }
    
    return self::$urlKeyMatches[$key];
    
  }
  
}