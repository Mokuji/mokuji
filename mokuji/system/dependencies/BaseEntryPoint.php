<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class BaseEntryPoint extends BaseComponent
{

  /**
   * Load a template.
   * 
   * Loads a template of the given name, with a theme of the given name with given content
   * for the <head> tag and given content for the <body> tag. All parameters are optional,
   * and can be left out.
   * 
   * @param string $template (optional) The name of the template to load.
   * @param string $theme    (optional) The name of the theme to load.
   * @param array  $head_contents (optional) An array of content for injection into the <head> tag.
   * @param array  $body_contents (optional) An array of content for injection into the <body> tag.
   *
   * @return string The resulting HTML.
   */
  public function template()
  {
    
    //handle arguments
    $args = Data(func_get_args())->as_array();
    
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
        $theme = 'default';
      }
      
    }
    
    //load default template?
    if(is_null($template)){
      $template = 'default';
    }
    
    //Return the resulting HTML.
    return tx('Controller')->load_template($template, $theme, $body_contents, $head_contents);
    
  }
  
}
