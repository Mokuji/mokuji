<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Url extends \dependencies\Data
{

  // consructor creates variables and set's the rules
  public function __construct($url=null, array $options = array())
  {
    
    if(!(is_string($url) || is_array($url))){
      throw new \exception\InvalidArgument('Expecting $url to be string or array. %s given.', ucfirst(gettype($url)));
    }
    
    
    if(is_array($url)){
      $this->set($url);
    }
    elseif(is_string($url)){
      $this->input->set($url);
      $this->_build_url($url, $options);
    }
    
  }
  
  public function __toString()
  {
    return $this->output->get();
  }
  
  public function compare(Url $url)
  {
    
    return $this->output->get() === $url->output->get();
    
  }
  
  public function rebuild_output()
  {
    
    $this->output->set(
      $this->segments->scheme.'://'.
      $this->segments->domain.
      $this->segments->path.
      ($this->segments->file->is_set() ? $this->segments->file : '').
      ($this->segments->query->is_set() ? '?'.$this->segments->query : '').
      ($this->segments->anchor->is_set() ? '#'.$this->segments->anchor : '')
    );
    
  }
  
  private function _build_url($string, array $options=array())
  {
  
    $options = array_merge(array(
      'build_on_redirect' => false,
      'discard_old_querystring' => false,
      'keep_module_id' => false
    ), $options);
    
    
    $old_url = (($options['build_on_redirect'] && tx('Url')->redirected) ? tx('Url')->redirect_url : tx('Url')->url);
  
    ##
    ## parse input to segments
    ##
    $segments = tx('Url')->parse($string);
    
    ##
    ## scheme segment
    ##
    $this->segments->scheme->set(array_key_exists('scheme', $segments) ? $segments['scheme'] : $old_url->segments->scheme);

    ##
    ## domain segment (and externallity)
    ##
    $this->segments->domain->set(array_key_exists('domain', $segments) ? $segments['domain'] : $old_url->segments->domain);
    
    if(tx('Url')->url instanceof \dependencies\Url)
    {
      
      if($this->segments->domain->get() != tx('Url')->url->segments->domain->get()){
        $this->external->set(true);
      }
      else{
        $this->external->set(false);
      }
      
    }
    else{
      $this->external->set(false);
    }
    
    ##
    ## path segment (and backend)
    ##
    if(array_key_exists('path', $segments))
    {
      
      
      if($this->check('external')){
        $this->segments->path->set($segments['path']);
        $this->backend->set(false);
      }
      
      else
      {
        
        $prefix = ((substr($segments['path'], 0, 1) === '/') 
          ? (URL_PATH != '' && (substr($segments['path'], 1, strlen(URL_PATH)) !== URL_PATH || is_dir(PATH_BASE.DS.URL_PATH)) ? '/'.URL_PATH : '') 
          : $old_url->segments->path->get()
        );
        
        $this->segments->path->set($prefix.$segments['path']);
        
        if(strpos($this->segments->path->get(), '/'.(URL_PATH != '' ? URL_PATH.'/' : '').'admin/') === 0){
          $this->backend->set(true);
        }else{
          $this->backend->set(false);
        }
        
      }
      
    }
    
    else{
      $this->segments->path->set($this->check('external') ? '/' : $old_url->segments->path);
      $this->backend->set($this->check('external') ? false : $old_url->backend);
    }
    
    ##
    ## file segments
    ##
    $this->segments->file->set(array_key_exists('file', $segments) ? $segments['file'] : $old_url->segments->file);
    
    ##
    ## query segment (and data)
    ##
    $given_data = array();
    if(array_key_exists('query', $segments)){
      parse_str($segments['query'], $given_data);
    }
    
    if($options['discard_old_querystring'] || $this->check('external')){
      $data = $given_data;
    }
    
    else{
      $data = array_merge($old_url->data->as_array(), $given_data);
    }
    
    if(count($data) > 0)
    {
      
      $keep = array();
      
      foreach($data as $key => $val)
      {
        if(($val==='NULL' || is_null($val)) || is_numeric($key)){
          unset($data[$key]);
        }
        if($val==='KEEP'){
          $keep[] = $key;
          $data[$key] = $old_url->data->{$key}->is_leafnode() ? $old_url->data->{$key}->get() : $old_url->data->{$key}->as_array();
        }
      }
      
      if(array_key_exists('mid', $data) && $options['keep_module_id'] !== true && !array_key_exists('mid', $given_data) && !$options['build_on_redirect'] && !in_array('mid', $keep)){
        unset($data['mid']);
      }
      
      if(array_key_exists('section', $data) && !array_key_exists('section', $given_data) && !$options['build_on_redirect'] && !in_array('section', $keep)){
        unset($data['section']);
      }
      
      if(array_key_exists('html', $data) && !array_key_exists('html', $given_data) && !$options['build_on_redirect'] && !in_array('html', $keep)){
        unset($data['html']);
      }
      
      if(array_key_exists('tx_target', $data) && !array_key_exists('tx_target', $given_data) && !$options['build_on_redirect'] && !in_array('tx_target', $keep)){
        unset($data['tx_target']);
      }
      
    }
    
    $this->segments->query->set((count($data)>0) ? http_build_query($data, null, '&') : null);
    $this->data->set($data);
    
    ##
    ## anchor segment
    ##
    if(array_key_exists('anchor', $segments)){
      
      //prettify hash "querystring"
      $anchor = str_replace(array('&', '='), array('/', '/'), $segments['anchor']);
      
      //add "pretty" hash slash if not already present
      if(substr($anchor, 0, 1) !== '/'){
        $anchor = "$anchor/";
      }
      
      $this->segments->anchor->set($anchor);
      
    }
    
    ##
    ## backtrace
    ##
    //$this->debug->backtrace = callstack();
    
    
    ##
    ## create output
    ##
    $this->rebuild_output();
    
  }

}
