<?php namespace components\update; if(!defined('TX')) die('No direct access.');

use components\update\tasks\CoreUpdates;

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'install' => 0 //Uses INSTALLING constant for authorization
    );
  
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
      'install_steps' => CoreUpdates::need_core_upgrade() ?
        array(
          array(
            'title' => 'Introduction',
            'section' => 'update/upgrade_intro'
          ),
          array(
            'title' => 'Transfer configuration',
            'section' => 'update/upgrade_config'
          ),
          array(
            'title' => 'Transfer files',
            'section' => 'update/upgrade_files'
          ),
          array(
            'title' => 'Upgrade packages',
            'section' => 'update/upgrade_packages'
          ),
          array(
            'title' => 'Check file references',
            'section' => 'update/upgrade_file_references'
          )
        ) :
        array(
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
