<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Connection extends Unexpected
{

  protected static $ex_code = EX_CONNECTION;

}