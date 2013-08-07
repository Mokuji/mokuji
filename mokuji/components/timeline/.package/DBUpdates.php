<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'timeline',
    $updates = array(
      '0.1' => '0.2',
      '0.2' => '0.3',
      
      '0.3' => '0.0.4-alpha', //No DB changes.
      '0.0.4-alpha' => '0.1.0-beta' //No DB changes.
      
    );
  
  public function update_to_0_3($current_version, $forced)
  {
    
    try{
      
      tx('Sql')->query('
        ALTER TABLE `#__timeline_pages`
          ADD `is_past_hidden` bit(1) NOT NULL DEFAULT b\'0\'
      ');
      
    }
    
    catch(\Exception $ex){
      if(!$forced) throw $ex;
    }
    
  }
  
  public function update_to_0_2($current_version, $forced)
  {
    
    try{
      
      tx('Sql')->query('
        ALTER TABLE `#__timeline_pages`
          ADD `force_language` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `timeline_id`
      ');
      
    }
    
    catch(\Exception $ex){
      if(!$forced) throw $ex;
    }
    
  }
  
  public function install_0_1($dummydata, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_timelines`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_pages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_page_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_display_types`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_entries`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_entry_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__timeline_entries_to_timelines`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_timelines` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `is_public` bit(1) NOT NULL DEFAULT b\'1\',
        PRIMARY KEY (`id`),
        KEY `is_public` (`is_public`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_pages` (
        `page_id` int(10) UNSIGNED NOT NULL,
        `timeline_id` int(10) UNSIGNED NOT NULL,
        `display_type_id` int(10) UNSIGNED NOT NULL,
        `items_per_page` TINYINT(3) UNSIGNED NOT NULL DEFAULT 10,
        `is_chronologic` bit(1) NOT NULL DEFAULT b\'0\',
        `is_future_hidden` bit(1) NOT NULL DEFAULT b\'1\',
        PRIMARY KEY (`page_id`),
        KEY `timeline_id` (`timeline_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_page_info` (
        `page_id` int(10) UNSIGNED NOT NULL,
        `language_id` int(10) UNSIGNED NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`page_id`, `language_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_display_types` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `component_name` varchar(255) NOT NULL,
        `section_name` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      INSERT INTO `#__timeline_display_types` (`title`, `component_name`, `section_name`)
      VALUES ("Blogposts", "timeline", "blogposts_entry")
    ');  
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_entries` (
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `type` ENUM("blogpost") NOT NULL DEFAULT "blogpost",
        `dt_publish` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `thumbnail_image_id` int(10) UNSIGNED NULL DEFAULT NULL,
        `author_id` int(10) UNSIGNED NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `dt_publish` (`dt_publish`),
        KEY `author_id` (`author_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__timeline_entry_info` (
        `entry_id` int(10) UNSIGNED NOT NULL,
        `language_id` int(10) UNSIGNED NOT NULL,
        `title` varchar(255) NOT NULL,
        `summary` TEXT NULL DEFAULT NULL,
        `content` LONGTEXT NULL DEFAULT NULL,
        PRIMARY KEY (`entry_id`, `language_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__timeline_entries_to_timelines` (
        `timeline_id` int(10) UNSIGNED NOT NULL,
        `entry_id` int(10) UNSIGNED NOT NULL,
        PRIMARY KEY (`timeline_id`, `entry_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
        
        tx('Component')->helpers('cms')->_call('ensure_pagetypes', array(
          array(
            'name' => 'timeline',
            'title' => 'Timeline component'
          ),
          array(
            'blog' => false
          )
        ));
        
      }
    ); //END - Queue CMS 1.2+
    
  }
  
}
