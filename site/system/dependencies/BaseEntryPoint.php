<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class BaseEntryPoint extends BaseComponent
{

  // template([bool $system=false,] [string $template=null,] [string $theme=null,] [array $head_contents=array(),] array $body_contents = array())
  public function template()
  {
    
    //handle arguments
    $args = Data(func_get_args())->as_array();
    
    //is a boolean provided indicating wether to load from /system/ folder?
    $system = ((!empty($args) && is_bool($args[0])) ? array_shift($args) : false);
    
    //is a template name provided?
    $template = ((!empty($args) && (is_string($args[0]) || is_null($args[0]))) ? array_shift($args) : null);
    
    //is a theme name provided?
    $theme = ((!empty($args) && (is_string($args[0]) || is_null($args[0]))) ? array_shift($args) : null);
    
    //contents
    $head_contents = array(); $body_contents = array();
    switch(count($args)){
      case 2: $head_contents = array_shift($args);
      case 1: $body_contents = array_shift($args);
    }
    
    //load default theme?
    if(is_null($theme))
    {
    
      if(is_string($template)){
        $theme = $template;
      }
      
      else{
        $system = true;
        $theme = 'default';
      }
      
    }
    
    //load default template?
    if(is_null($template))
    {
      
      $system = true;
      $template = 'default';
      
    }
    
    return tx('Controller')->load_template(($system ? 'system' : 'custom')."/$template", ($system ? 'system' : 'custom')."/$theme", $body_contents, $head_contents);
    
  }
  
}
