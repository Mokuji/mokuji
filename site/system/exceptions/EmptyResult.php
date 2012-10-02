<?php namespace exception; if(!defined('TX')) die('No direct access.');

class EmptyResult extends Expected
{

  protected static $ex_code = EX_EMPTYRESULT;

}