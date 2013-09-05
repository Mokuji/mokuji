<?php namespace exception; if(!defined('TX')) die('No direct access.');

class InvalidArgument extends Programmer
{

  protected static $ex_code = EX_INVALIDARGUMENT;
  
}