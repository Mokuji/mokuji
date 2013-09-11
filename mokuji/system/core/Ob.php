<?php namespace core; if(!defined('TX')) die('No direct access.');

class Ob
{
  
  private
    $buffers=array(),
    $retrieved=array(),
    $meta,
    $link,
    $style,
    $script;
  
  public function __construct()
  {
    $this->meta = Data();
    $this->link = Data();
    $this->style = Data();
    $this->script = Data();
  }
  
  // checks if there are any buffers left unclosed
  public function __destruct()
  {
  
    if(count($this->buffers) > 0){
      throw new \exception\Programmer('There are %s output buffers left unclosed.', count($this->buffers));
    }
  
  }
  
  // opens an output buffer for meta tags
  public function meta()
  {
    
    if(func_num_args() < 1){
      throw new \exception\InvalidArgument('Expecting at least one argument to use as id.');
      return;
    }
    
    if(in_array('meta', $this->retrieved)){
      throw new \exception\Restriction('Meta data was already retrieved.');
    }
    
    $this->buffers[] = array(
      'type' => 'meta',
      'id' => func_get_args()
    );
    
    ob_start();
    
  }
  
  // opens an output buffer for link tags
  public function link()
  {
    
    if(func_num_args() < 1){
      throw new \exception\InvalidArgument('Expecting at least one argument to use as id.');
      return;
    }
    
    if(in_array('link', $this->retrieved)){
      throw new \exception\Restriction('Links were already retrieved.');
    }
    
    $this->buffers[] = array(
      'type' => 'link',
      'id' => func_get_args()
    );
    
    ob_start();
    
  }
  
  // opens an output buffer for style tags
  public function style()
  {
    
    if(func_num_args() < 1){
      throw new \exception\InvalidArgument('Expecting at least one argument to use as id.');
      return;
    }
    
    if(in_array('style', $this->retrieved)){
      throw new \exception\Restriction('Style was already retrieved.');
    }
    
    $this->buffers[] = array(
      'type' => 'style',
      'id' => func_get_args()
    );
    
    ob_start();
    
  }
  
  // opens an output buffer for script tags
  public function script()
  {
    
    if(func_num_args() < 1){
      throw new \exception\InvalidArgument('Expecting at least one argument to use as id.');
      return;
    }
    
    if(in_array('script', $this->retrieved)){
      throw new \exception\Restriction('scripts were already retrieved.');
    }
    
    $this->buffers[] = array(
      'type' => 'script',
      'id' => func_get_args()
    );
    
    ob_start();
    
  }
  
  // closes the last output buffer and saves the output
  public function end()
  {
    
    if(count($this->buffers) < 1){
      throw new \exception\Programmer('There are no active output buffers.');
    }
    
    $last = array_pop($this->buffers);
    $this->add(ob_get_contents(), $last['type'], $last['id']);
    ob_end_clean();
    
    return $this;
    
  }
  
  // adds content to one of the output storages
  public function add($content, $type, $id)
  {
  
    if(!in_array($type, array('meta', 'link', 'style', 'script'))){
      throw new \exception\InvalidArgument("Expecting 'meta', 'link', 'style' or 'script'. %s given.", $type);
    }
    
    return $this->{$type}->extract($id)->is('set')->failure(function($d)use($content){
      $d->set($content);
    });
  
  }
  
  // gets content from one of the output storages
  public function get($type)
  {
    
    if(!in_array($type, array('meta', 'link', 'style', 'script'))){
      throw new \exception\InvalidArgument("Expecting 'meta', 'link', 'style' or 'script'. %s given.", $type);
    }
    
    $this->retrieved[$type] = $type;
    
    return $this->{$type};
    
  }
  
}