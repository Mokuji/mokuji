<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'account',
    $updates = array(
      '1.2' => '1.3',
      '1.3' => '1.4',
      '1.4' => '0.2.0-beta', //No DB changes.
      '0.2.0-beta' => '0.2.1-beta' //No DB changes.
    );
  
  public function update_to_1_4($current_version, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_password_reset_tokens`');
    }
    
    tx('Sql')->query("
      CREATE TABLE `#__account_password_reset_tokens` (
        `user_id` INT(10) UNSIGNED NOT NULL,
        `token` varchar(255) NOT NULL,
        `IPv4` varchar(15) NOT NULL,
        `user_agent` varchar(255) NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `dt_expiry` TIMESTAMP NOT NULL,
        PRIMARY KEY (`user_id`),
        UNIQUE INDEX `token` (`token`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ");
    
  }
  
  //Add new installer, since pretty much nothing changed except the pagetype registering.
  public function install_1_3($dummydata, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_accounts_to_user_groups`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_user_groups`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_user_info`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__account_accounts_to_user_groups` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(10) unsigned NOT NULL,
        `user_group_id` int(10) unsigned NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`,`user_group_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__account_user_groups` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__account_user_info` (
        `user_id` int(10) unsigned NOT NULL,
        `avatar_image_id` int(10) unsigned DEFAULT NULL,
        `username` varchar(255) DEFAULT NULL,
        `name` varchar(255) DEFAULT NULL,
        `preposition` varchar(255) DEFAULT NULL,
        `family_name` varchar(255) DEFAULT NULL,
        `status` int(10) unsigned NOT NULL DEFAULT \'1\',
        `claim_key` varchar(255) DEFAULT NULL,
        `comments` text,
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
            'name' => 'account',
            'title' => 'Account management'
          ),
          array(
            'accounts' => 'MANAGER',
            'profile' => 'PAGETYPE'
          )
        ));
        
      }
    ); //END - Queue CMS 3.0+
    
  }
  
  //This one will be deprecated soon.
  public function update_to_1_3($current_version, $forced)
  {
    
    tx('Logging')->log('Account', 'DEPRECATED', 'Used deprecated update_to_1_3 function.');
    
    $comname = $this->component;
    
    //Queue translation token update with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version)use($comname){
          
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'account'")
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
  
  //This one will be deprecated soon.
  public function install_1_2($dummydata, $forced)
  {
    
    tx('Logging')->log('Account', 'DEPRECATED', 'Used deprecated install_1_2 function.');
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_accounts_to_user_groups`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_user_groups`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__account_user_info`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__account_accounts_to_user_groups` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `user_group_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`,`user_group_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__account_user_groups` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__account_user_info` (
        `user_id` int(11) NOT NULL COMMENT \'cms_users::id\',
        `avatar_image_id` int(11) DEFAULT NULL,
        `username` varchar(255) DEFAULT NULL,
        `name` varchar(255) DEFAULT NULL,
        `preposition` varchar(255) DEFAULT NULL,
        `family_name` varchar(255) DEFAULT NULL,
        `status` int(11) NOT NULL DEFAULT \'1\',
        `claim_key` varchar(255) DEFAULT NULL,
        `comments` text,
        PRIMARY KEY (`user_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          //Look for the account component in the CMS tables.
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'account'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function(){
              
              return tx('Sql')
                ->model('cms', 'Components')
                ->set(array(
                  'name' => 'account',
                  'title' => 'Account management'
                ))
                ->save();
              
            });
          
          //Look for the accounts view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'accounts'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'accounts',
                  'tk_title' => 'ACCOUNT_ACCOUNTS_VIEW_TITLE',
                  'tk_description' => 'ACCOUNT_ACCOUNTS_VIEW_DESCRIPTION',
                  'is_config' => '1'
                ))
                ->save();
              
            });
          
          //Look for the profile view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'profile'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'profile',
                  'tk_title' => 'ACCOUNT_PROFILE_VIEW_TITLE',
                  'tk_description' => 'ACCOUNT_PROFILE_VIEW_DESCRIPTION',
                  'is_config' => '0'
                ))
                ->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
}

