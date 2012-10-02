<?php namespace exception; if(!defined('TX')) die('No direct access.');

class FileMissing extends NotFound
{

  protected static $ex_code = EX_FILEMISSING;

}