<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'menu',
    $updates = array(
      '1.1' => '1.2',
      '1.2' => '1.3',
      '1.3' => '1.4',
      '1.4' => '0.2.0-beta', //No DB changes.
      '0.2.0-beta' => '0.3.0-beta' //No DB changes.
    );
  
  //Add new installer to prevent pagetype problems.
  public function install_1_4($dummydata, $forced)
  {
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_items`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_item_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_menus`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_items` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `menu_id` int(10) unsigned NOT NULL,
        `lft` int(10) unsigned NOT NULL,
        `rgt` int(10) unsigned NOT NULL,
        `page_id` int(10) unsigned DEFAULT NULL,
        `image_id` INT(10) unsigned NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_item_info` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `item_id` int(10) unsigned NOT NULL,
        `language_id` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` longtext,
        PRIMARY KEY (`id`),
        KEY `item_id` (`item_id`),
        KEY `language_id` (`language_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_menus` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `site_id` int(10) unsigned NOT NULL,
        `template_key` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `site_id` (`site_id`),
        KEY `template_key` (`template_key`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '3.0'
      ), function($version){
        
        tx('Component')->helpers('cms')->_call('ensure_pagetypes', array(
          array(
            'name' => 'menu',
            'title' => 'Menu component'
          ),
          array(
            'menu_link' => 'PAGETYPE'
          )
        ));
        
      }
    ); //END - Queue CMS 3.0+
    
  }
  
  //This one will be deprecated soon.
  public function update_to_1_4($current_version, $forced)
  {
    
    tx('Logging')->log('Menu', 'DEPRECATED', 'Used deprecated update_to_1_4 function.');
    
    //Queue translation token update with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'menu'")
            ->execute_single();
          
          //Sitemap has been broken for some time now.
          //Remove it please.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'sitemap'")
            ->execute_single()
            ->not('empty', function($row){
              $row->delete();
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
  //This one will be deprecated soon.
  public function update_to_1_3($current_version, $forced)
  {
    
    tx('Logging')->log('Menu', 'DEPRECATED', 'Used deprecated update_to_1_3 function.');
    
    //Queue translation token update with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'menu'")
            ->execute_single();
          
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->execute()
            ->each(function($view){
              
              //If tk_title starts with 'COMNAME_' remove it.
              if(strpos($view->tk_title->get('string'), strtoupper('menu_')) === 0){
                $view->tk_title->set(
                  substr($view->tk_title->get('string'), (strlen('menu')+1))
                );
              }
              
              //If tk_description starts with 'COMNAME_' remove it.
              if(strpos($view->tk_description->get('string'), strtoupper('menu_')) === 0){
                $view->tk_description->set(
                  substr($view->tk_description->get('string'), (strlen('menu')+1))
                );
              }
              
              $view->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
  //This one will be deprecated soon.
  public function update_to_1_2($current_version, $forced)
  {
    
    tx('Logging')->log('Menu', 'DEPRECATED', 'Used deprecated update_to_1_2 function.');
    
    //If this goes wrong it's because of the column already existing.
    try{
      tx('Sql')->query('ALTER TABLE  `#__menu_items` ADD  `image_id` INT NULL');
    }
    
    //Ignore it when we're forcing.
    catch(\exception\Sql $ex){
      if($forced !== true) throw $ex;
    }
    
  }
  
  //This one will be deprecated soon.
  public function install_1_1($dummydata, $forced)
  {
    
    tx('Logging')->log('Menu', 'DEPRECATED', 'Used deprecated install_1_1 function.');
    
    if($forced === true){
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_items`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_item_info`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__menu_menus`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_items` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `menu_id` int(11) NOT NULL,
        `lft` int(11) NOT NULL,
        `rgt` int(11) NOT NULL,
        `page_id` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_item_info` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `item_id` int(11) NOT NULL,
        `language_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` longtext,
        PRIMARY KEY (`id`),
        KEY `item_id` (`item_id`),
        KEY `language_id` (`language_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__menu_menus` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `site_id` int(10) unsigned NOT NULL,
        `template_key` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `site_id` (`site_id`),
        KEY `template_key` (`template_key`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          //Look for the component in the CMS tables.
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'menu'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function(){
              
              return tx('Sql')
                ->model('cms', 'Components')
                ->set(array(
                  'name' => 'menu',
                  'title' => 'Menu component'
                ))
                ->save();
              
            });
          
          //Look for the sitemap view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'sitemap'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'sitemap',
                  'tk_title' => 'MENU_SITEMAP_VIEW_TITLE',
                  'tk_description' => 'MENU_SITEMAP_VIEW_DESCRIPTION',
                  'is_config' => '0'
                ))
                ->save();
              
            });
          
          //Look for the menu_link view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'menu_link'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'menu_link',
                  'tk_title' => 'MENU_MENU_LINK_VIEW_TITLE',
                  'tk_description' => 'MENU_MENU_LINK_VIEW_DESCRIPTION',
                  'is_config' => '0'
                ))
                ->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
}
