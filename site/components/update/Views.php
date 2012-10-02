<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected function summary($options)
  {
    
    //Get last read value.
    tx('Sql')
      ->table('update', 'UserLastReads')
      ->pk(tx('Account')->user->id)
      ->execute_single()
      
      //Make a new entry if it doesn't exist yet.
      ->is('empty', function(){
        return tx('Sql')
          ->model('update', 'UserLastReads')
          ->set(array('user_id' => tx('Account')->user->id));
      })
      
      //Store current date.
      ->last_read->set(time())->back()
      ->save();
    
    //Return latest 8 updates.
    return array(
      'latest_updates' => tx('Sql')
        ->table('update', 'PackageVersions')
        ->order('date', 'DESC')
        ->order('version', 'DESC')
        ->limit(8)
        ->execute()
    );
    
  }
  
  protected function install()
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    return array(
      'steps' => array(
        array(
          'title' => 'Introduction',
          'section' => 'update/install_intro'
        ),
        array(
          'title' => 'Database configuration',
          'section' => 'update/install_db'
        ),
        array(
          'title' => 'Site configuration',
          'section' => 'update/install_site'
        ),
        array(
          'title' => 'Creating admin user',
          'section' => 'update/install_admin'
        )
      )
    );
    
  }
  
}
