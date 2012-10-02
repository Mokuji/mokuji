<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected function check_updates($options)
  {
    
    //May the silent force be with you.
    $options = Data($options)->having('silent', 'force');
    
    $silent = $options->silent->is_true();
    $force = $options->force->is_true();
    
    if(!$silent) echo '<div id="update-logs">'.n.
      '<h1>'.__('Update logs', 1).'</h1>'.n.
      '<a class="back button grey" href="?view=update/summary">'.__('Back to summary', 1).'</a>'.br.n;
    
    //Look through root dir.
    if(is_dir(PATH_BASE.DS.'.package'))
      $this->check_folder(PATH_BASE, '\\core\\', $silent, $force);
    
    //Look through all components.
    $components = glob(PATH_COMPONENTS.DS.'*');
    foreach($components as $component){
      if(is_dir($component.DS.'.package')){
        $component_path_parts = explode(DS, $component);
        $namespace = '\\components\\'.end($component_path_parts).'\\';
        $this->check_folder($component, $namespace, $silent, $force);
      }
    }
    
    //Look through all templates.
    $templates = glob(PATH_TEMPLATES.DS.'custom'.DS.'*');
    foreach($templates as $template){
      if(is_dir($template.DS.'.package')){
        $template_path_parts = explode(DS, $template);
        $namespace = '\\templates\\'.end($template_path_parts).'\\';
        $this->check_folder($template, $namespace, $silent, $force);
      }
    }
    
    //Look through all themes.
    $themes = glob(PATH_THEMES.DS.'custom'.DS.'*');
    foreach($themes as $theme){
      if(is_dir($theme.DS.'.package')){
        $theme_path_parts = explode(DS, $theme);
        $namespace = '\\themes\\'.end($theme_path_parts).'\\';
        $this->check_folder($theme, $namespace, $silent, $force);
      }
    }
    
    //When everything is done, see if we need to process any queued operations.
    tx('Component')->load('update', 'classes\\BaseDBUpdates', false);
    \components\update\classes\BaseDBUpdates::process_queue();
    
    if(!$silent){
      echo '</div>';
      exit;
    } else {
      return true;
    }
    
  }
  
  private function check_folder($folder, $namespace, $silent, $force)
  {
    
    $packageFile = $folder.DS.'.package'.DS.'package.json';
    
    if(!$silent) echo br.n.__('Scanning', 1).': <strong class="path package">'.str_replace(PATH_BASE.DS, '../', $folder).'</strong>'.br.n;
    
    //Make sure the package file is there.
    if(!is_file($packageFile)){
      if(!$silent) echo '<em class="error">'.__('Package folder does not contain package.json file', 1).'.</em>'.br.n;
      else throw new \exception\NotFound('Package folder does not contain package.json file');
      return;
    }
    
    //Get package info.
    $package = Data(json_decode(file_get_contents($packageFile), true));
    
    //Switch on type.
    switch($package->type->get()){
      
      case 'manual':
        $this->sync_manual_package($package, $folder, $namespace, $silent, $force);
        break;
      
      default:
        if(!$silent) echo '<em class="error">'.__('Package type', 1).' '.$package->type->get().' '.__('is not supported', 1).'.</em>'.br.n;
        else throw new \exception\Expected('Package type '.$package->type->get().' is not supported');
      
    }
    
  }
  
  private function sync_manual_package($package, $folder, $namespace, $silent, $force)
  {
    
    $package = Data($package);
    $new_versions = false;
    
    //Find the package.
    $dbPackage = tx('Sql')
      ->table('update', 'Packages')
      ->where('title', "'{$package->title}'")
      ->execute_single()
      
      //If it doesn't exist, create it now.
      ->is('empty', function()use(&$new_versions){
        $new_versions = true;
        return tx('Sql')
          ->model('update', 'Packages');
      });
    
    //Update the package data.
    $dbPackage->merge(array(
      'title' => $package->title,
      'type' => 0, //manual type
      'description' => $package->description
    ))->save();
    
    //Save the latest version.
    $latest = tx('Sql')
      ->table('update', 'PackageVersions')
      ->where('package_id', $dbPackage->id)
      ->order('date', 'DESC')
      ->limit(1)
      ->execute_single();
    
    //Update the versions and their changes.
    $package->versions->each(function($version)use($dbPackage, &$latest, &$new_versions){
      
      //Try find this version.
      $dbVersion = tx('Sql')
        ->table('update', 'PackageVersions')
        ->where('package_id', $dbPackage->id)
        ->where('version', "'{$version->version}'")
        ->execute_single()
        
        //If it doesn't exist, create it now.
        ->is('empty', function()use($version, $dbPackage, &$latest, &$new_versions){
          
          //Bump latest version if needed.
          $version->timestamp->set(strtotime($version->date->get()));
          if($version->timestamp->get() > $latest->timestamp->get())
            $latest = $version;
          
          $new_versions = true;
          $dbVersion = tx('Sql')
            ->model('update', 'PackageVersions')
            ->set($version->having('version', 'date', 'description'))
            ->package_id->set($dbPackage->id)->back()
            ->save();
          
          //Insert the changes of this version.
          $version->changes->each(function($change)use($dbVersion){
            
            tx('Sql')
              ->model('update', 'PackageVersionChanges')
              ->set($change->having('title', 'description', 'url'))
              ->url->is('empty', function($url){ $url->set('NULL'); })->back()
              ->package_version_id->set($dbVersion->id)->back()
              ->save();
            
          });
          
        });
      
    });
    
    if($new_versions || $dbPackage->installed_version->get() !== $latest->version->get() || $dbPackage->installed_version->is_empty())
    {
      
      if($package->dbUpdates->get() === true)
      {
        
        try{
          require_once($folder.DS.'.package'.DS.'DBUpdates'.EXT);
          $updaterClass = $namespace.'DBUpdates';
          $updater = new $updaterClass();
          $updater->update($force, true);
        }
        
        catch(\exception\Exception $ex){
          if(!$silent) echo '<em class="error">'.__('Error while updating database', 1).'.'.br.n.$ex->getMessage().'</em>'.br.n;
          else throw new \exception\Expected('Error while updating database. '.$ex->getMessage());
          return;
        }
        
      }
      
      else if($latest->is_set())
      {
        $dbPackage->merge(array(
          'installed_version' => $latest->version,
          'installed_version_date' => $latest->date
        ))->save();
      }
      
      if(!$silent) echo __('New versions loaded', 1).'!'.br.n;
      
    }
    else if(!$silent) echo __('No new updates', 1).'.'.br.n;
    
  }
  
}
