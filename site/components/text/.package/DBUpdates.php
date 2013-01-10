<?php namespace components\text; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
tx('Component')->check('update');
tx('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'text',
    $updates = array(
      '1.1' => '1.2'
    );
  
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
            ->where('name', "'{$this->component}'")
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
      tx('Sql')->query('DROP TABLE IF EXISTS `#__text_items`');
      tx('Sql')->query('DROP TABLE IF EXISTS `#__text_item_info`');
    }
    
    tx('Sql')->query('
      CREATE TABLE `#__text_items` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `page_id` int(11) NOT NULL,
        `order_nr` int(11) DEFAULT NULL,
        `dt_created` datetime NOT NULL,
        `user_id` int(11) NOT NULL,
        `trashed` tinyint(1) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `page_id` (`page_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8
    ');
    
    tx('Sql')->query('
      CREATE TABLE `#__text_item_info` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `item_id` int(11) NOT NULL,
        `language_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `text` text NOT NULL,
        PRIMARY KEY (`id`),
        KEY `item_id` (`item_id`,`language_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '1.2'
      ), function($version){
          
          //Look for the component in the CMS tables.
          $component = tx('Sql')
            ->table('cms', 'Components')
            ->where('name', "'text'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function(){
              
              return tx('Sql')
                ->model('cms', 'Components')
                ->set(array(
                  'name' => 'text',
                  'title' => 'Text component'
                ))
                ->save();
              
            });
          
          //Look for the menus view.
          tx('Sql')
            ->table('cms', 'ComponentViews')
            ->where('com_id', $component->id)
            ->where('name', "'text'")
            ->limit(1)
            ->execute_single()
            
            //If it's not there, create it.
            ->is('empty', function()use($component){
              
              $view = tx('Sql')
                ->model('cms', 'ComponentViews')
                ->set(array(
                  'com_id' => $component->id,
                  'name' => 'text',
                  'tk_title' => 'TEXT_TEXT_VIEW_TITLE',
                  'tk_description' => 'TEXT_TEXT_VIEW_DESCRIPTION',
                  'is_config' => '0'
                ))
                ->save();
              
            });
          
        }); //END - Queue CMS 1.2+
    
  }
  
}
