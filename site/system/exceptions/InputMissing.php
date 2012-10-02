<?php namespace exception; if(!defined('TX')) die('No direct access.');

class InputMissing extends NotFound
{

  protected static $ex_code = EX_INPUTMISSING;

}