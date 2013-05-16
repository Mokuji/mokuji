<?php namespace components\security; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'security',
    $updates = array(
    );
  
  public function install_0_1($dummydata, $forced)
  {
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '3.0'
      ), function($version){
        
        //Ensures the mail component and mailing view.
        tx('Component')->helpers('cms')->_call('ensure_pagetypes', array(
          array(
            'name' => 'security',
            'title' => 'Security component'
          ),
          array(
            'settings_security' => 'SETTINGS'
          )
        ));
        
      }
    ); //END - Queue CMS 3.0+
    
  }
  
}

