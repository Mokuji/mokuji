<?php namespace exception; if(!defined('TX')) die('No direct access.');

class ModelValidation extends Validation
{

  protected static $ex_code = EX_MODEL_VALIDATION;
  
  public $errors = array();
  
  public function add_validation_error(Validation $error)
  {
    array_push($this->errors, $error);
  }
  
  public function set_validation_errors($errors)
  {
    $this->errors = $errors;
  }

}
