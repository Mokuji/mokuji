<?php namespace templates\underduck; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $template = 'underduck',
    $updates = array(
      '1.0' => '0.1.1-beta',
      '0.1.1-beta' => '0.1.2-beta' //No DB updates.
    );
  
  public function install_1_0($dummydata, $forced)
  {
    
    if($forced === true){
      
      //Remove any entries first.
      tx('Sql')
        ->table('cms', 'Templates')
        ->where('name', "'underduck'")
        ->execute()
        ->each(function($template){
          $template->delete();
        });
      
    }
    
    tx('Sql')
      ->model('cms', 'Templates')
      ->set(array(
        'name' => 'underduck',
        'title' => 'Underduck'
      ))
      ->save();
    
  }
  
}
