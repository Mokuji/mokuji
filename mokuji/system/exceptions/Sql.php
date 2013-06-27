<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Sql extends Unexpected
{

  protected static $ex_code = EX_SQL;

}