<?php namespace templates\tx_login; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $template = 'tx_login',
    $updates = array();
  
  public function install_1_0($dummydata, $forced){}
  
}
