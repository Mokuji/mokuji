<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Expected extends Exception
{

  protected static $ex_code = EX_EXPECTED;

}