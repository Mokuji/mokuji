<?php namespace components\update; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'update',
    $updates = array(
      '1.1' => '1.2',
      '1.2' => '0.2.0-beta', //No DB changes.
      '0.2.0-beta' => '0.2.1-beta', //No DB changes.
      '0.2.1-beta' => '0.2.2-beta' //No DB changes.
    );
  
  //Replacing installer for new page view tables.
  public function install_1_2($dummydata, $forced)
  {
    
    if($forced === true){
      //Since we are self-reinstalling, make sure the base class knows to refresh it's cached data about versions.
      $this->clear_cache();
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_packages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_package_versions`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_package_version_changes`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_user_last_reads`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__update_packages` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `type` int(10) unsigned NOT NULL,
        `installed_version` varchar(255) NOT NULL,
        `installed_version_date` date NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `type` (`type`),
        KEY `title` (`title`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_package_versions` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `package_id` int(10) unsigned NOT NULL,
        `version` varchar(255) NOT NULL,
        `date` date NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `package_id` (`package_id`,`date`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_package_version_changes` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `package_version_id` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `url` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `package_update_id` (`package_version_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_user_last_reads` (
        `user_id` int(10) unsigned NOT NULL,
        `last_read` date NOT NULL,
        PRIMARY KEY (`user_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '3.0'
      ), function($version){
        
        tx('Component')->helpers('cms')->_call('ensure_pagetypes', array(
          array(
            'name' => 'update',
            'title' => 'Update management'
          ),
          array(
            'summary' => 'MANAGER'
          )
        ));
        
      }
    ); //END - Queue CMS 3.0+
    
  }
  
  public function update_to_1_2($current_version, $forced)
  {
    
    $comname = $this->component;
     
    //Queue translation token update with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version)use($comname){
          
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'update'")
            ->execute_single();
          
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->execute()
            ->each(function($view)use($comname){
              
              //If tk_title starts with 'COMNAME_' remove it.
              if(strpos($view->tk_title->get('string'), strtoupper($comname.'_')) === 0){
                $view->tk_title->set(
                  substr($view->tk_title->get('string'), (strlen($comname)+1))
                );
              }
              
              //If tk_description starts with 'COMNAME_' remove it.
              if(strpos($view->tk_description->get('string'), strtoupper($comname.'_')) === 0){
                $view->tk_description->set(
                  substr($view->tk_description->get('string'), (strlen($comname)+1))
                );
              }
              
              $view->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
  public function install_1_1($dummydata, $forced)
  {
    
    if($forced === true){
      //Since we are self-reinstalling, make sure the base class knows to refresh it's cached data about versions.
      $this->clear_cache();
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_packages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_package_versions`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_package_version_changes`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__update_user_last_reads`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__update_packages` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `type` int(10) unsigned NOT NULL,
        `installed_version` varchar(255) NOT NULL,
        `installed_version_date` date NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `type` (`type`),
        KEY `title` (`title`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_package_versions` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `package_id` int(10) unsigned NOT NULL,
        `version` varchar(255) NOT NULL,
        `date` date NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `package_id` (`package_id`,`date`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_package_version_changes` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `package_version_id` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `url` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `package_update_id` (`package_version_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__update_user_last_reads` (
        `user_id` int(11) NOT NULL,
        `last_read` date NOT NULL,
        PRIMARY KEY (`user_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          //Look for the update component in the CMS tables.
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'update'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function(){
              
              return tx('Sql')
                ->model('cms', 'Components')
                ->set(array(
                  'name' => 'update',
                  'title' => 'Update management'
                ))
                ->save();
              
            });
          
          //Look for the summary view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'summary'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'summary',
                  'tk_title' => 'UPDATE_SUMMARY_VIEW_TITLE',
                  'tk_description' => 'UPDATE_SUMMARY_VIEW_DESCRIPTION',
                  'is_config' => '1'
                ))
                ->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
}
