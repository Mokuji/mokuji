<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Unexpected extends Exception
{

  protected static $ex_code = EX_UNEXPECTED;

}