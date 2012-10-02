<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Error extends \ErrorException
{

  protected $context;
  
  public function __construct($errno, $errstr, $errfile, $errline, $context)
  {
    
    $errnos = array(
      E_ERROR             => 'ERROR',
      E_WARNING           => 'WARNING',
      E_PARSE             => 'PARSING ERROR',
      E_NOTICE            => 'NOTICE',
      E_CORE_ERROR        => 'CORE ERROR',
      E_CORE_WARNING      => 'CORE WARNING',
      E_COMPILE_ERROR     => 'COMPILE ERROR',
      E_COMPILE_WARNING   => 'COMPILE WARNING',
      E_USER_ERROR        => 'USER ERROR',
      E_USER_WARNING      => 'USER WARNING',
      E_USER_NOTICE       => 'USER NOTICE',
      E_STRICT            => 'STRICT NOTICE',
      E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR'
    );
    
    $message = "{$errnos[$errno]}: <b>$errstr</b>";
    
    $this->context = $context;
    
    parent::__construct($message, 0, $errno, $errfile, $errline);
    
  }
  
  public function getContext()
  {
    return $this->context;
  }

}