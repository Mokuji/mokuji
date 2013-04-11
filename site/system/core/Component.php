<?php namespace core; if(!defined('TX')) die('No direct access.');

/**
 * Provides core features to manage and access components.
 */
class Component
{

  /**
   * Keeps track of a components information that has been loaded.
   */
  private $components;
  
  /**
   * Caches whether components are available and valid.
   */
  private $checks=array();
  
  /**
   * Initializes the class.
   */
  public function __construct()
  {
    
    $this->components = Data();
    
  }
  
  /**
   * Returns an instance of the "Views" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseViews
   */
  public function views($of)
  {
    return $this->load($of, 'Views');
  }
  
  /**
   * Returns an instance of the "Actions" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseComponent
   */
  public function actions($of)
  {
    return $this->load($of, 'Actions');
  }
  
  /**
   * Returns an instance of the "Modules" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseViews
   */
  public function modules($of)
  {
    return $this->load($of, 'Modules');
  }
  
  /**
   * Returns an instance of the "Sections" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseViews
   */
  public function sections($of)
  {
    return $this->load($of, 'Sections');
  }
  
  /**
   * Returns an instance of the "Json" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseComponent
   */
  public function json($of)
  {
    return $this->load($of, 'Json');
  }
  
  /**
   * Returns an instance of the "Helpers" class for the given component.
   * @param String $of The component name.
   * @return \dependencies\BaseComponent
   */
  public function helpers($of)
  {
    
    if(!file_exists(PATH_COMPONENTS.DS.$of.DS.'Helpers'.EXT)){
      throw new \exception\NotFound('Component "%s" does not have a Helpers.php.', $of);
    }
    
    return $this->load($of, 'Helpers');
    
  }
  
  /**
   * Calls the entrance function of the components "EntryPoint" class
   * @param String $component The component name.
   */
  public function enter($component)
  {
    
    $this->check($component);
    
    if(!file_exists(PATH_COMPONENTS.DS.$component.DS.'EntryPoint'.EXT)){
      throw new \exception\NotFound('Component "%s" does not have an EntryPoint and can therefore not be used as system-component.', $component);
    }
    
    $entry = $this->load($component, 'EntryPoint');
    
    if(!method_exists($entry, 'entrance')){
      throw new \exception\NotFound('The EntryPoint of %s does not have an entrance method.');
    }
    
    return $entry->entrance();
    
  }
  
  /**
   * Allows loading components and their parts.
   * @param String $component The component name.
   * @param String $part The optional name of the part to load.
   * @param boolean $instantiate Whether or not to instantiate the requested part.
   * @return mixed Returns null if `$part` is null, a boolean if `$instantiate` is false or the instantiated part if `$instantiate` is true.
   * @throws \exception\NotFound If the loaded file does not contain the expected part.
   */
  public function load($component, $part=null, $instantiate=true)
  {

    $component = data_of($component);
    $part = data_of($part);
    $this->check($component);
    
    //if this component was not used before, we're also going to put the stylesheet and javascript into the html if they exist
    if(!$this->components->{$component}->is_set()){
      if(file_exists(PATH_COMPONENTS.DS."$component/includes/style.css")){
        tx('Ob')->add("<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_COMPONENTS."$component/includes/style.css\" />", 'link', array('tx', 'components', $component));
      }
      if(file_exists(PATH_COMPONENTS.DS."$component/includes/javascript.js")){
        tx('Ob')->add("<script type=\"text/javascript\" src=\"".URL_COMPONENTS."$component/includes/javascript.js\"></script>", 'script', array('tx', 'components', $component));
      }
    }
    
    if(is_null($part)){
      return;
    }
    
    //if the component part was not yet set, now would be the time to include it
    if(!$this->components->{$component}->{$part}->is_set() || $this->components->{$component}->{$part}->is_true() && $instantiate === true)
    {
      
      //Create the file and class name.
      $class = "\\components\\$component\\$part";
      $file = PATH_COMPONENTS.DS.$component.DS.str_replace('\\', DS, $part).EXT;
      
      //Require the file that should contain the class.
      require_once($file);
      
      //Check if the file actually contains this class.
      if(!class_exists($class, false)){
        throw new \exception\NotFound('The file "%s" does not appear to contain the expected "%s"-class.', $file, $class);
      }
      
      //Instantiate the class right away?
      if($instantiate){
        $this->components->{$component}->{$part}->set(new $class);
      }
      
      //Only set a boolean to indicate that the file has been loaded.
      else{
        $this->components->{$component}->{$part}->set(true);
      }
      
    }
    
    //Return the instance (or boolean).
    return $this->components->{$component}->{$part}->get();
    
  }
  
  /**
   * Validates a component's folder structure.
   * @param String $component_name The name of the component.
   * @return boolean
   * @throws \exception\InvalidArgument If the component name is empty.
   * @throws \exception\InvalidArgument If the component name contains invalid characters.
   * @throws \exception\FileMissing If the component does not exist.
   * @throws \exception\FileMissing If the component does not have Actions, Modules, Views or Sections.
   * @throws \exception\FileMissing If the component does not have includes, models or templates.
   * @throws \exception\FileMissing If the component does not have frontend, backend or global templates.
   */
  public function check($component_name)
  {
    
    raw($component_name);
    
    if(array_key_exists($component_name, $this->checks) && $this->checks[$component_name] === true){
      return $this->checks[$component_name];
    }
      
    if(empty($component_name)){
      throw new \exception\InvalidArgument("Component name can not be empty");
    }
    
    if(!preg_match('~[a-z_]+~', $component_name)){
      throw new \exception\InvalidArgument('Component name contains invalid characters.');
    }
    
    if(!is_dir(PATH_COMPONENTS.DS.$component_name)){
      throw new \exception\FileMissing("Component '%s' does not exist.", $component_name);
    }
    
    foreach(array('Actions', 'Modules', 'Views', 'Sections') as $part){
      if(!is_file(PATH_COMPONENTS.DS.$component_name.DS.$part.EXT)){
        throw new \exception\FileMissing("Component '%s' does not have the '%s'.", $component_name, $part.EXT);
      }
    }
    
    foreach(array('includes', 'models', 'templates') as $dir){
      if(!is_dir(PATH_COMPONENTS.DS.$component_name.DS.$dir)){
        throw new \exception\FileMissing("Component '%s' does not have a '%s' directory.", $component_name, $dir);
      }
    }
    
    foreach(array('frontend', 'backend', 'global') as $dir){
      if(!is_dir(PATH_COMPONENTS.DS.$component_name.DS.'templates'.DS.$dir)){
        throw new \exception\FileMissing("Component '%s' does not have a '%s' directory in the templates.", $component_name, $dir);
      }
    }
    
    // foreach(array('img', 'view_icons') as $dir){
      // if(!is_dir(PATH_COMPONENTS.DS.$component_name.DS.'includes'.DS.$dir)){
        // $valid = false;
        // throw new \exception\FileMissing("Component '%s' does not have a '%s' directory in the includes.", $component_name, $dir);
      // }
    // }
    
    // foreach(array('javascript.js', 'style.css') as $include){
      // if(!is_file(PATH_COMPONENTS.DS.$component_name.DS.'includes'.DS.$include)){
        // $valid = false;
        // throw new \exception\FileMissing("Component '%s' does not have a '%s' file in the includes.", $component_name, $include);
      // }
    // }
    
    return $this->checks[$component_name] = true;
  
  }
  
  /**
   * Checks whether a component is available and has a valid structure.
   * @param String $component_name The name of the component.
   * @return boolean
   */
  public function available($component_name)
  {
    
    try{
      $this->check($component_name);
      return true;
    }
    catch(\exception\Exception $e){
      return false;
    }
    
  }
  
}
