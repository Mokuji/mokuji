<?php namespace templates\minimal; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $template = 'minimal',
    $updates = array(
      '1.0' => '0.1.1-beta'
    );
  
  public function install_1_0($dummydata, $forced)
  {
    
    if($forced === true){
      
      //Remove any entries first.
      tx('Sql')
        ->table('cms', 'Templates')
        ->where('name', "'minimal'")
        ->execute()
        ->each(function($template){
          $template->delete();
        });
      
    }
    
    tx('Sql')
      ->model('cms', 'Templates')
      ->set(array(
        'name' => 'minimal',
        'title' => 'Minimal'
      ))
      ->save();
    
  }
  
}
