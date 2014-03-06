<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

/**
 * The simple keys URL format class.
 * Example: /about
 * Detects, validates and formats various URLs.
 */
class SimpleKeysUrlFormat extends UrlFormat
{
  
  const REGEX = '~^/([\w\-]{3,})(/?([\w\/\-]*))?$~';
  
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
    
    //Instances of UrlFormat are OK when they can produce a valid URL-key.
    if($url instanceof UrlFormat)
    {
      
      $key = $url->getUrlKey();

      try{
        if(empty($key)) return false;
      }
      
      catch(\Exception $ex){
        return false;
      }
      
      //Should be at least 3 characters and not an integer.
      return strlen($key) >= 3 && ((string)intval($key) !== (string)$key);
      
    }
    
    //Loading the homepage is always fine.
    if($url === '/')
      return true;
    
    //Check the URL contents.
    if(preg_match(self::REGEX, $url, $matches) !== 1)
      return false;
    
    //The matched URL-key should not be an integer.
    if((string)intval($matches[1]) === (string)$matches[1])
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
    
    //Just to make sure.
    if(!self::validate($url))
      throw new \exception\InvalidArgument('The URL has an invalid format. Try detecting the format instead.');
    
    //Instances of UrlFormat are an easy source.
    if($url instanceof UrlFormat){
      $this->fromUrlFormat($url);
      return;
    }
    
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
      $this->urlKey = trim($matches[1]);
      
      if(isset($matches[3]))
        $this->urlExtensions = $this->parseUrlExtensions($matches[3]);
      
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
    
    $url = URL_BASE.$this->urlKey;
    
    if(count($this->urlExtensions) > 0){
      $url .= '/'.implode('/', $this->urlExtensions);
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
    
    /*
      
      Perhaps a different source already cached this for us.
      
      Note: this prevents the URL-key based retrieval from determining a language.
      However, if the source that set the pageId (because it wasn't this class),
      was not already deterministic about the language, the URL-key is an arbitrary value
      generated based on the current language and the language will still not be deterministic.
      
      In other words, it's pointless to look for deterministic language ID's in this case.
      
    */
    if($this->pageId)
      return $this->pageId;
    
    //If the results are cached, use that.
    if(array_key_exists(strtolower($this->urlKey), self::$urlKeyMatches))
      return self::$urlKeyMatches[strtolower($this->urlKey)];
    
    //Detect page
    $matches = mk('Sql')->table('cms', 'PageInfo')
      ->where('LOWER(`url_key`)', mk('Sql')->escape(strtolower($this->urlKey)))
      ->execute();
    
    //No matches means we can't find a page.
    if($matches->size() === 0){
      throw new \exception\NotFound('Could not find a page for this URL key.');
    }
    
    //One match makes life easy.
    //Note: this makes for a deterministic language ID.
    elseif($matches->size() === 1){
      $this->languageId = $matches->{0}->language_id->get('int');
      self::$urlKeyMatches[strtolower($this->urlKey)] = $matches->{0}->page_id->get('int');
    }
    
    //More than one match needs some attention.
    else
    {
      
      //Find out how many different page ID's are referenced.
      $ids = array();
      foreach($matches as $match){
        $ids[$match->page_id->get('int')] = true;
      }
      $ids = array_keys($ids);
      
      //If the matches point to the same page (multi-language), that's fine.
      if(count($ids) === 1){
        self::$urlKeyMatches[strtolower($this->urlKey)] = $ids[0];
      }
      
      //Apparently we have a URL-key that points to multiple pages.
      else{
        
        //Arbitrarily pick the one with the lowest ID and notify an Admin of the problem.
        sort($ids);
        self::$urlKeyMatches[strtolower($this->urlKey)] = $ids[0];
        
        #TODO: Notify admin of this problem.
        
      }
      
    }
    
    return self::$urlKeyMatches[strtolower($this->urlKey)];
    
  }
  
  public function getLanguageId()
  {
    
    //This checks if the URL-key is deterministic about it.
    $this->getPageId();
    
    //Business as usual.
    return parent::getLanguageId();
    
  }
  
  public function getLanguageShortcode()
  {
    
    //This checks if the URL-key is deterministic about it.
    $this->getPageId();
    
    //Business as usual.
    return parent::getLanguageShortcode();
    
  }
  
}