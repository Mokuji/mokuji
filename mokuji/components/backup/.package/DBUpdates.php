<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'backup',
    $updates = array(
    );
  
  public function install_0_1_0_beta($dummydata, $forced)
  {
    
    if($forced === true){
      mk('Sql')->query('DROP TABLE IF EXISTS `#__backup_profiles`');
    }
    
    mk('Sql')->query('
      CREATE TABLE `#__backup_profiles` (
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `table_selection` ENUM(\'ALL\', \'PREFIXED\') NOT NULL,
        `table_drop` BIT(1) NOT NULL,
        `table_structure` BIT(1) NOT NULL,
        `table_data` BIT(1) NOT NULL,
        `table_rows_per_insert` int(10) unsigned NOT NULL DEFAULT \'50\',
        `output_include_comments` BIT(1) NOT NULL,
        PRIMARY KEY (`name`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    mk('Sql')
      ->model('backup', 'Profiles')
      ->set(array(
        'name' => 'default',
        'title' => 'Default backup profile',
        'table_selection' => 'PREFIXED',
        'table_drop' => true,
        'table_structure' => true,
        'table_data' => true,
        'table_rows_per_insert' => 20,
        'output_include_comments' => true
      ))
      ->save();
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '0.4.1-beta'
      ), function($version){
          
          mk('Component')->helpers('cms')->_call('ensure_pagetypes', array(
            array(
              'name' => 'backup',
              'title' => 'Backup'
            ),
            array(
              'backup_profiles' => 'SETTINGS'
            )
          ));
          
        }); //END - Queue CMS
    
  }
  
}

