<?php namespace components\cms\routing; if(!defined('MK')) die('No direct access.');

/**
 * An abstract URL format class.
 * Validates and formats various URLs.
 */
abstract class UrlFormat
{
  
  /**
   * Creates a new instance.
   * @param string $url The URL to handle.
   */
  abstract public function __construct($url);
  
  /**
   * Outputs the current URL data into the format the class provides.
   * @param array $getData The GET data to append to the URL when outputting
   * @return string A formatted version of the URL data.
   */
  abstract public function output($getData=null);
  
  //Standard attributes.
  protected $languageId = null;
  protected $languageShortcode = null;
  protected $pageId = null;
  protected $urlKey = null;
  protected $urlExtensions = array();
  
  //Standard getters and setters.
  public function getLanguageId()
  {
    
    if($this->languageId)
      return $this->languageId;
    
    elseif($this->languageShortcode){
      $this->languageId = $this->shortcodeToId($this->languageShortcode);
    }
    
    return $this->languageId;
    
  }
  
  public function getLanguageShortcode()
  {
    
    if($this->languageShortcode)
      return $this->languageShortcode;
    
    elseif($this->languageId){
      $this->languageShortcode = $this->idToShortcode($this->languageId);
    }
    
    return $this->languageShortcode;
    
  }
  
  public function getPageId(){
    return $this->pageId;
  }
  
  public function getUrlKey(){
    return $this->urlKey;
  }
  
  public function getUrlExtensions(){
    return $this->urlExtensions;
  }
  
  //Standard __toString method.
  public function __toString(){
    return $this->output();
  }
  
  /**
   * Use another UrlFormat object as data source, rather than parsing strings.
   * @param  UrlFormat $url The data source.
   * @return void
   */
  protected function fromUrlFormat(UrlFormat $url){
    $this->pageId = $url->getPageId();
    $this->urlKey = $url->getUrlKey();
    $this->urlExtensions = $url->getUrlExtensions();
    $this->languageId = $url->getLanguageId();
  }

  /**
   * Gets random page from CMS.
   * @return (string) $url Url of page
   */
  protected function getRandomPage()
  {

    //#TODO
    //if(NO PAGES FOR THIS SITE)
    //throw new \exception\Unexpected('Could not parse the homepage URL format: '.$uex->getMessage());
    return mk('Cms')->model('Page')->order('RAND()')->limit(1)->execute_single();

  }
  
  /**
   * If the format is used to load the homepage,
   * determine the information needed from the homepage setting.
   * @return void
   */
  protected function useHomepage()
  {
    
    //That is, if we even have a homepage.
    if(!mk('Config')->user('homepage')->is_set()){
      #TODO: Notify admin.
      #TODO: Set 404 header.
      //Load helper redirect-to-page template.
      echo mk('Component')->views('cms')->get_html('redirect_to_page', array(
        'url' => this::getRandomPage();
        'message' => __('cms', 'No homepage is set. We take you with us on adventure. Let\'s go!')
      ));
      exit;
    }
    
    //Try parse the homepage setting for the URL information (regardless of it's format).
    try{
      $homepage = UrlFormatFactory::detect(mk('Config')->user('homepage')->get());
      $this->fromUrlFormat($homepage);
    }
    catch(\exception\Unexpected $uex){
      #TODO: Admin should be notified of this.
      throw new \exception\Unexpected('Could not parse the homepage URL format: '.$uex->getMessage());
    }
    
  }
  
  /**
   * Parses URL extensions.
   * @param  string $raw
   * @return array
   */
  protected function parseUrlExtensions($raw)
  {
    
    //We have to go deeper!
    raw($raw);
    
    //Split the extensions by slashes.
    $extensions = explode('/', $raw);
    
    //Remove any useless parts.
    for($i = 0; $i < count($extensions); $i++)
    {
      
      $extensions[$i] = trim($extensions[$i]);
      
      if(empty($extensions[$i])){
        array_splice($extensions, $i, 1);
        $i--;
      }
      
    }
    
    return $extensions;
    
  }
  
  /**
   * Gets a language ID based on it's shortcode.
   * @param  string $shortcode
   * @return integer
   */
  protected function shortcodeToId($shortcode)
  {
    
    return mk('Sql')->table('cms', 'Languages')
      ->where('LOWER(`shortcode`)', mk('Sql')->escape(strtolower($shortcode)))
      ->execute_single()
      ->is('empty', function()use($shortcode){
        throw new \exception\NotFound('Could not find a language for shortcode '.strtoupper($shortcode).'.');
      })
      ->id->get('int');
    
  }
  
  /**
   * Gets a language shortcode based on it's ID.
   * @param  integer $id
   * @return string
   */
  protected function idToShortcode($id)
  {
    
    return mk('Sql')->table('cms', 'Languages')
      ->where('id', intval($id))
      ->execute_single()
      ->is('empty', function()use($id){
        throw new \exception\NotFound('Could not find a language for ID '.$id.'.');
      })
      ->shortcode->get('string');
    
  }
  
}