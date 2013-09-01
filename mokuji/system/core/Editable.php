<?php namespace core; if(!defined('TX')) die('No direct access.');

class Editable
{

  public function init()
  {
  
    define('EDITABLE', (tx('Data')->session->tx->editable->is_set() && tx('Account')->check_level(2) ? tx('Data')->session->tx->editable->get() : false));
  
  }
  
}