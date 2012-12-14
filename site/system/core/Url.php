<?php namespace core; if(!defined('TX')) die('No direct access.');

class Url
{

  const
    ALL = 0,
    SCHEME = 1,
    DOMAIN = 2,
    PATH = 4,
    FILE = 8,
    QUERY = 16,
    ANCHOR = 32;

  public
    $url,
    $referer_url=false,
    $redirected=false,
    $redirect_url=null;

  // parses a string as URL and returns an array of all "url-like" segments present
  public function parse($url, $flags = 0)
  {
    
    $url = data_of($url);
    $flags = data_of($flags);

    if(!is_string($url)){
      throw new \exception\InvalidArgument('Expecting $url to be string. %s given.', ucfirst(gettype($url)));
      return false;
    }
    
    $regex =
      "~^(?!&)". //url can not start with '&'
      "(?:(?P<scheme>[^:/?#]+)(?=://))?". //scheme
      "(?:\://)?". //thingy
      "(?:(?<!\?)(?<=\://)(?P<domain>(?:[a-zA-Z0-9\-]+)(?:\.[a-zA-Z0-9\-\:]+)*))?". //domain (only if it's not in the query string)
      "(?:(?<!\?)(?P<path>/?(?:[^=?#]*/)+))?". //path
      "(?:(?P<file>(?:[^?#]+)(?:\.[^=?#]+)+))?". //file
      "(?:\??(?P<query>(?:[^#]+(?:=[^#]+)?)(?:&(?:amp;)?[^#]+(?:=[^#]+)?)*))?". //query
      "(?:#?(?P<anchor>.+))?$~"; //anchor

    if(!preg_match($regex, $url, $segments)){
      throw new \exception\Unexpected("Oh no! The URL that was given could not be parsed.");
      return false;
    }

    foreach($segments as $key => $val)
    {

      if(is_numeric($key) || (empty($val) && !checkbit(constant('self::'.strtoupper($key)), $flags)) || ($flags > 0 && !checkbit(constant('self::'.strtoupper($key)), $flags))){
        unset($segments[$key]);
      }

    }

    if(count_bits($flags) == 1){
      return (count($segments) == 1 ? current($segments) : false);
    }

    else{
      return $segments;
    }

  }

  // build the url and makes sure all segments will be present in segment by taking server vars
  public function init()
  {
    
    //query string
    $qs = tx('Data')->server->QUERY_STRING->is_set() ? '?'.tx('Data')->server->QUERY_STRING : '';
    
    /** request uri
    * special thanks to:
    *  adrian - for helping me notice the formerly missing ';' at the end of the following line.
    */
    $req_uri = tx('Data')->server->PHP_SELF;
    
    //server
    $server = tx('Data')->server->SERVER_NAME->get();
    
    //secure scheme?
    $secure = (tx('Data')->server->HTTPS->is_set() && (tx('Data')->server->HTTPS->get() == 'on'));
    
    //scheme
    $scheme = strstr(strtolower(tx('Data')->server->SERVER_PROTOCOL->get()), '/', true) . ($secure ? 's' : '');
    
    //port
    $port = ((tx('Data')->server->SERVER_PORT->get() == '80') ? '' : (':'.tx('Data')->server->SERVER_PORT->get()));

    preg_match('~(?:(?<!\?)(?P<path>/?(?:((?![^?#]*=)[^?#])*/)+))?(?:(?P<file>(?:[^\?]+)(?:\.[^\?]+)+))?~', array_get(explode('?', $req_uri), 0), $matches);

    //path
    $path = array_key_exists('path', $matches) ? $matches['path'] : '/';

    //file
    $file = array_key_exists('file', $matches) ? $matches['file'] : '';
    
    //full url
    $url = new \dependencies\Url(array(
      'input' => "$scheme://$server$port$req_uri$qs",
      'output' => "$scheme://$server$port$req_uri$qs",
      'segments' => array(
        'scheme' => $scheme,
        'domain' => "$server$port",
        'path' => $path,
        'file' => $file,
        'query' => tx('Data')->server->QUERY_STRING->get()
      ),
      'external' => false,
      'backend' => tx('Config')->system('backend')->not('set', function(){return false;})->get(),
      'data' => tx('Data')->get->as_array()
    ));
    
    $this->url = $url;
    $this->referer_url = (tx('Data')->server->HTTP_REFERER->is_set() ? url(tx('Data')->server->HTTP_REFERER->get(), true) : false);
    
  }

  public function redirect($url)
  {

    if(headers_sent() && ! tx('Data')->session->tx->debug->check('pause_redirects')){
      throw new \exception\Programmer('Can not redirect after headers have been sent.');
    }

    if(is_string($url)){
      $url = url($url);
    }elseif(!($url instanceof \dependencies\Url)){
      return;
    }

    $this->redirected = true;
    $this->redirect_url = $url;

  }

  public function cancel_redirect()
  {
    $this->redirected = false;
    $this->redirect_url = null;
  }

  public function previous($allow_external=false, $allow_backend_to_frontend=true)
  {

    if($this->referer_url === false){
      return false;
    }

    if($allow_external===false && $this->referer_url->check('external')){
      return false;
    }

    if($allow_backend_to_frontend===false && ($this->referer_url->check('backend') !== $this->url->check('backend'))){
      return false;
    }

    return $this->referer_url;

  }

}
