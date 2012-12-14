<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'cms',
    $updates = array(
      '1.1' => '1.2',
      '1.2' => '1.3',
      '1.3' => '1.4',
      '1.4' => '2.0'
    );
  
  public function update_to_2_0($current_version, $forced)
  {
    
    try{
      
      tx('Sql')->query('
        ALTER TABLE `#__cms_page`
          CHANGE `keywords` `notes` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL 
      ');
      
      tx('Sql')->query('
        ALTER TABLE `#__cms_page_info`
          ADD `description` TEXT NULL,
          ADD `keywords` VARCHAR( 255 ) NULL,
          ADD `url_key` VARCHAR( 255 ) NULL,
          ADD `og_title` VARCHAR( 255 ) NULL,
          ADD `og_description` TEXT NULL,
          ADD `og_keywords` VARCHAR( 255 ) NULL,
          ADD `tw_title` VARCHAR( 255 ) NULL,
          ADD `tw_description` TEXT NULL,
          ADD `tw_author` VARCHAR( 255 ) NULL,
          ADD `gp_author` VARCHAR( 255 ) NULL,
          ADD INDEX ( `page_id` ),
          ADD INDEX ( `language_id` )
      ');
      
      
    }catch(\exception\Sql $ex){
      //When it's not forced, this is a problem.
      //But when forcing, ignore this.
      if(!$forced) throw $ex;
    }
    
  }
  
  public function update_to_1_4($current_version, $forced)
  {
    
    $component = tx('Sql')
      ->table('cms', 'Components')
      ->where('name', "'{$this->component}'")
      ->execute_single();
    
    tx('Sql')
      ->table('cms', 'ComponentViews')
      ->where('com_id', $component->id)
      ->execute()
      ->each(function($view){
        
        //If tk_title starts with 'COMNAME_' remove it.
        if(strpos($view->tk_title->get('string'), strtoupper($this->component.'_')) === 0){
          $view->tk_title->set(
            substr($view->tk_title->get('string'), (strlen($this->component)+1))
          );
        }
        
        //If tk_description starts with 'COMNAME_' remove it.
        if(strpos($view->tk_description->get('string'), strtoupper($this->component.'_')) === 0){
          $view->tk_description->set(
            substr($view->tk_description->get('string'), (strlen($this->component)+1))
          );
        }
        
        $view->save();
        
      });
    
  }
  
  public function update_to_1_3($current_version, $forced)
  {
    
    tx('Sql')->query('
      ALTER TABLE  `#__cms_options`
        DROP INDEX  `key`
    ');
    
  }
  
  public function update_to_1_2($current_version, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_module_custom_names`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_view_custom_names`');
    }
    
    tx('Sql')->query('RENAME TABLE `#__cms_component_module_info` TO `#__cms_component_module_custom_names`');
    tx('Sql')->query('RENAME TABLE `#__cms_component_view_info` TO `#__cms_component_view_custom_names`');
    
    tx('Sql')->query('
      ALTER TABLE  `#__cms_component_modules`
        ADD  `tk_title` VARCHAR( 255 ) NOT NULL AFTER  `name` ,
        ADD  `tk_description` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `tk_title`
    ');
    
    tx('Sql')->query('
      ALTER TABLE  `#__cms_component_views`
        ADD  `tk_title` VARCHAR( 255 ) NOT NULL AFTER  `name` ,
        ADD  `tk_description` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `tk_title`
    ');
    
  }
  
  public function install_1_2($dummydata, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_components`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_modules`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_module_custom_names`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_views`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_component_view_custom_names`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_layouts`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_layout_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_menu_links`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_modules`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_modules_to_collections`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_modules_to_modulepage`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_modules_to_pages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_module_collections`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_options`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_options_link`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_option_sets`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_pages`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_page_group_permissions`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_page_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_templates`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__cms_themes`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__cms_components` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `name` (`name`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_component_modules` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `com_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `tk_title` VARCHAR( 255 ) NOT NULL,
        `tk_description` VARCHAR( 255 ) NULL DEFAULT NULL,
        `thumbnail` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_component_module_custom_names` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `lang_id` int(11) NOT NULL,
        `com_module_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` longtext NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_component_views` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `com_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `tk_title` VARCHAR( 255 ) NOT NULL,
        `tk_description` VARCHAR( 255 ) NULL DEFAULT NULL,
        `thumbnail` int(11) DEFAULT NULL,
        `is_config` tinyint(1) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_component_view_custom_names` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `lang_id` int(11) NOT NULL,
        `com_view_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` longtext NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_layouts` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `lft` int(11) NOT NULL,
        `rgt` int(11) NOT NULL,
        `size` int(11) DEFAULT NULL,
        `split` char(1) DEFAULT NULL,
        `content_type` char(1) DEFAULT NULL,
        `content_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `lft` (`lft`),
        UNIQUE KEY `rgt` (`rgt`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_layout_info` (
        `layout_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`layout_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_menu_links` (
        `page_id` int(11) NOT NULL,
        `menu_item_id` int(11) NOT NULL,
        `link_action` int(10) unsigned NOT NULL,
        PRIMARY KEY (`page_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_modules` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `com_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `optset_id` int(11) DEFAULT NULL,
        `access_level` int(11) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`),
        KEY `com_id` (`com_id`),
        KEY `optset_id` (`optset_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_modules_to_collections` (
        `module_id` int(11) NOT NULL,
        `collection_id` int(11) NOT NULL,
        PRIMARY KEY (`module_id`,`collection_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_modules_to_modulepage` (
        `module_id` int(11) NOT NULL,
        `page_id` int(11) NOT NULL,
        PRIMARY KEY (`module_id`,`page_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_modules_to_pages` (
        `module_id` int(11) NOT NULL,
        `page_id` int(11) NOT NULL,
        `layout_id` int(11) NOT NULL,
        PRIMARY KEY (`module_id`,`page_id`,`layout_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_module_collections` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_options` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(255) NOT NULL,
        `value` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `key` (`key`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_options_link` (
        `option_id` int(11) NOT NULL,
        `optset_id` int(11) NOT NULL,
        PRIMARY KEY (`option_id`,`optset_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_option_sets` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_pages` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) DEFAULT NULL,
        `view_id` int(11) NOT NULL,
        `theme_id` int(11) NOT NULL DEFAULT \'1\',
        `template_id` int(11) NOT NULL DEFAULT \'1\',
        `layout_id` int(11) DEFAULT NULL,
        `optset_id` int(11) DEFAULT NULL,
        `keywords` varchar(2000) DEFAULT NULL,
        `access_level` tinyint(3) NOT NULL DEFAULT \'0\',
        `published` tinyint(1) NOT NULL DEFAULT \'0\',
        `p_from` timestamp NULL DEFAULT NULL,
        `p_to` timestamp NULL DEFAULT NULL,
        `trashed` tinyint(1) NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_page_group_permissions` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `page_id` int(11) NOT NULL,
        `user_group_id` int(11) NOT NULL,
        `access_level` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `page_id` (`page_id`,`user_group_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_page_info` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `page_id` int(10) unsigned NOT NULL DEFAULT \'0\',
        `language_id` int(10) unsigned NOT NULL DEFAULT \'0\',
        `title` varchar(50) DEFAULT NULL,
        `slogan` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_templates` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `name` (`name`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    tx('Sql')->query('
      CREATE TABLE `#__cms_themes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `name` (`name`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Insert CMS component.
    $component = tx('Sql')
      ->model('cms', 'Components')
      ->set(array(
        'name' => 'cms',
        'title' => 'CMS component'
      ))
      ->save();
    
    //Insert page management.
    tx('Sql')
      ->model('cms', 'ComponentViews')
      ->set(array(
        'com_id' => $component->id,
        'name' => 'pages',
        'tk_title' => 'CMS_PAGES_VIEW_TITLE',
        'tk_description' => 'CMS_PAGES_VIEW_DESCRIPTION',
        'is_config' => '1'
      ))
      ->save();
    
    //Insert settings management.
    tx('Sql')
      ->model('cms', 'ComponentViews')
      ->set(array(
        'com_id' => $component->id,
        'name' => 'settings',
        'tk_title' => 'CMS_SETTINGS_VIEW_TITLE',
        'tk_description' => 'CMS_SETTINGS_VIEW_DESCRIPTION',
        'is_config' => '1'
      ))
      ->save();
    
  }
  
}

