<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class BaseViews extends BaseComponent
{

  public function get_html($view, $options=array())
  {
  
    if(func_num_args() > 2){
      throw new \exception\Deprecated('BaseViews::get_html() called with more than 2 arguments.');
    }
  
    // get raw data
    $view = data_of($view);
    
    // create appropriate prefix based on the nature of this view (view, module or section)
    $s = "\\components\\{$this->component}\\Sections";
    $m = "\\components\\{$this->component}\\Modules";
    $prefix = ($this instanceof $s ? '__' : ($this instanceof $m ? '_' : ''));
    unset($s, $m);
    
    // we expect the template for the view to be in either the /backend/ or /frontend/ directories
    $path_view = PATH_COMPONENTS.DS.$this->component.DS.'templates'.DS.(tx('Config')->system()->check('backend') || EDITABLE ? 'backend' : 'frontend').DS.$prefix.$view.EXT;
    
    // if it was not, we get it from the /global/ directory
    if(!is_file($path_view)){
      $path_view = PATH_COMPONENTS.DS.$this->component.DS.'templates'.DS.'global'.DS.$prefix.$view.EXT;
    }
    
    // execute the method to retrieve view-data
    $options = Data($options);
    $html = $this->call($view, $options);
    
    // if the template does not exist in any of the directories, we return the raw view data
    if(!is_file($path_view)){
      return Data($html)->__toString();
    }
    
    // if the template does exist, we define the variables that will be available in the template, and then return the html
    $html = Data($html);
    $data = array(
      
      $view => $html,
      
      'paths' => Data(array(
        'components' => URL_COMPONENTS,
        'component' => URL_COMPONENTS.$this->component.'/'
      )),
      
      'names' => Data(array(
        'component' => $this->component,
        'controller' => $view
      )),
      
      'options' => $options,
      'messages' => tx('Controller')->get_messages(),
      'data' => $html
      
    );
    
    return load_html($path_view, $data);

  }
  
}
