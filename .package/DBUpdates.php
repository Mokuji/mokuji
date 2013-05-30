<?php namespace core; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $is_core = true,
    $updates = array(
      '3.2.0' => '3.3.0',
      '3.3.0' => '3.3.1',
      '3.3.1' => '3.3.2',
      '3.3.2' => '3.3.3',
      
      '3.3.3' => '0.5.0-beta'
      
    );
  
  public function update_to_0_5_0_beta($current_version, $forced)
  {
    
    //Queue this because it would get it's changes undone in the DB otherwise.
    $this->queue(array(
      'component' => 'update',
      'min_version' => '0.2.0-beta'
      ), function($version){
        
        //Rename the package.
        mk('Component')->helpers('update')->call('rename_component_package', array(
          'component' => '/',
          'old_title' => 'Tuxion CMS core'
        ));
        
      }
    ); //END - Queue
    
  }
  
  public function update_to_3_3_3($current_version, $forced)
  {
    
    try{
      
      //Add language_id column.
      tx('Sql')->query("
        ALTER TABLE `#__core_config`
          ADD `language_id` INT NULL ,
          ADD INDEX ( `language_id` ) 
      ");
      
    }catch(\exception\Sql $ex){
      //When it's not forced, this is a problem.
      //But when forcing, ignore this.
      if(!$forced) throw $ex;
    }
    
  }
  
  public function update_to_3_3_2($current_version, $forced)
  {
    
    try{
      
      //Add title column.
      tx('Sql')->query("
        ALTER TABLE `#__core_languages`
          ADD `title` VARCHAR( 255 ) NOT NULL
      ");
      
      //Update existing languages for their titles.
      tx('Sql')->query("UPDATE `#__core_languages` SET `title`='English' WHERE `code` = 'en-GB'");
      tx('Sql')->query("UPDATE `#__core_languages` SET `title`='French' WHERE `code` = 'fr-FR'");
      tx('Sql')->query("UPDATE `#__core_languages` SET `title`='Dutch' WHERE `code` = 'nl-NL'");
      
    }catch(\exception\Sql $ex){
      //When it's not forced, this is a problem.
      //But when forcing, ignore this.
      if(!$forced) throw $ex;
    }
    
  }
  
  public function update_to_3_3_1($current_version, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_user_logins`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_user_login_shared_sessions`');
    }
    
    //Create the logged-in users table.
    tx('Sql')->query("
      CREATE TABLE `#__core_user_logins` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT(10) UNSIGNED NOT NULL,
        `session_id` CHAR(32) NOT NULL,
        `dt_expiry` TIMESTAMP NULL DEFAULT NULL,
        `IPv4` VARCHAR(15) NOT NULL,
        `user_agent` VARCHAR(255) NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE INDEX `session_id` (`session_id`, `user_id`)
      )
      DEFAULT CHARSET=utf8
      ENGINE=MyISAM
    ");
    
    //Create the shared sessions table.
    tx('Sql')->query("
      CREATE TABLE `#__core_user_login_shared_sessions` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `login_id` INT(10) UNSIGNED NOT NULL,
        `IPv4` VARCHAR(15) NOT NULL,
        `user_agent` VARCHAR(255) NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      )
      DEFAULT CHARSET=utf8
      ENGINE=MyISAM
    ");
    
    //Port the current logged-in user?
    if(tx('Account')->user->login === true)
    {
      
      //Get current login information.
      $info = tx('Sql')->execute_query('SELECT * FROM `#__core_users` WHERE id = '.tx('Account')->user->id)->{0};
      
      //Insert a row for the current logged-in user.
      tx('Sql')->query('
        INSERT INTO `#__core_user_logins` VALUES (
          NULL,
          '.tx('Account')->user->id.',
          \''.tx('Data')->server->REMOTE_ADDR.'\',
          \''.strtotime($info->dt_last_login).'\',
          \''.tx('Session')->id.'\',
          \''.tx('Data')->server->HTTP_USER_AGENT.'\',
          NULL
        )
      ');
      
    }
    
    //Alter the user table.
    try{
      tx('Sql')->query('
        ALTER TABLE `#__core_users`
          DROP COLUMN `session`,
          DROP COLUMN `ipa`,
          DROP COLUMN `dt_last_login`
      ');
    }catch(\exception\Sql $ex){
      //When it's not forced, this is a problem.
      //But when forcing, ignore this.
      if(!$forced) throw $ex;
    }
    
  }
  
  public function install_3_2_0($dummydata, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_config`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_ip_addresses`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_languages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_sites`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_site_domains`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__core_users`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__core_config` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `key` varchar(255) NOT NULL,
        `value` varchar(255) DEFAULT NULL,
        `site_id` int(10) unsigned NOT NULL,
        `autoload` tinyint(1) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`),
        KEY `option_id` (`key`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__core_ip_addresses` (
        `address` varchar(255) NOT NULL,
        `login_level` int(10) unsigned NOT NULL,
        PRIMARY KEY (`address`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__core_languages` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(10) NOT NULL,
        `shortcode` varchar(10) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__core_sites` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `path_base` varchar(255) NOT NULL,
        `url_path` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__core_site_domains` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `site_id` int(10) unsigned NOT NULL,
        `domain` varchar(300) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `domain` (`domain`),
        KEY `site_id` (`site_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__core_users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) DEFAULT NULL,
        `level` int(3) NOT NULL DEFAULT \'1\',
        `session` char(32) DEFAULT NULL,
        `ipa` varchar(15) DEFAULT NULL,
        `hashing_algorithm` varchar(255) DEFAULT NULL,
        `salt` varchar(255) DEFAULT NULL,
        `dt_last_login` datetime DEFAULT NULL,
        `dt_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `username` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `username` (`username`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
  }
  
}

