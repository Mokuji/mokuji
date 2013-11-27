<?php namespace components\account\controllers\base; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseComponent;
use \dependencies\BaseViews;
use \dependencies\Data;
use \dependencies\Validator;
use \exception\Validation as ValidationException;

class Controller extends BaseComponent
{
  
  /**
   * Contains the object that we're loading a view from.
   * @var BaseViews
   */
  private $viewObject;
  
  /**
   * Contains the name of the view.
   * @var string
   */
  private $viewName;
  
  /**
   * Contains data gathered by the controller.
   * @var Data
   */
  protected $data;
  
  /**
   * Initialize with an optional viewObject and viewName.
   *
   * @param BaseViews $viewObject
   * @param string $viewName
   */
  public function __construct(BaseViews $viewObject = null, $viewName = null)
  {
    
    $this->viewObject = $viewObject;
    $this->viewName = $viewName;
    $this->data = new Data;
    
  }
  
  /**
   * Return the data.
   *
   * @return Data
   */
  public function getData()
  {
    
    return $this->data;
    
  }
  
  /**
   * Renders the view, passing along the data.
   *
   * @return string The resulting HTML.
   */
  public function renderView()
  {
    
    //Must have a view.
    if(!$this->hasView()){
      throw new \exception\InputMissing("No view defined.");
    }
    
    //Render the view.
    return $this->viewObject->get_html($this->viewName, $this->getData());
    
  }
  
  /**
   * Return true if a viewObject and viewName have been set on this controller.
   *
   * @return boolean
   */
  public function hasView()
  {
    
    return ($this->viewObject instanceof BaseViews && is_string($this->viewName));
    
  }
  
  /**
   * Validate data.
   *
   * @param mixed $data The data to validate.
   * @param string $title A friendly name for the data.
   * @param array $rules The validation rules.
   * @param boolean $translate Whether to translate. Defaults to true.
   *
   * @throws ValidationException If validation fails.
   *
   * @return mixed The given data, sanitized by the validator.
   */
  public function validate($data, $title, array $rules, $translate = true)
  {
    
    //Create the validator.
    $validator = new Validator($data, $rules, $translate);
    
    //If the validator failed..
    if($validator->failure())
    {
      
      //Gather errors.
      $errors = $validator->errors();
      
      //Iterate over them, appending each individual message to a single sentence.
      for($i = 0, $total = count($errors), $sep = '', $msg = ''; $i < $total; $i++){
        $msg .= $sep.lcfirst($errors[$i]);
        $sep = ', ';
        if($i == $total-2) $sep = ' and ';
      }
      
      //Finish the sentence by upper-casing the first letter and appending a period.
      $message = ucfirst($msg).'.';
      
      //Create the validation exception.
      $e = new ValidationException("'%s' has an invalid format: %s", ucfirst($title), $message);
      $e->key('data');
      $e->value($data);
      $e->title($title);
      $e->errors($errors);
      
      //Throw it.
      throw $e;
      
    }
    
    //Return sanitized data.
    return $validator->get_data();
    
  }
  
}
