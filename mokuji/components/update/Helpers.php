<?php namespace components\update; if(!defined('TX')) die('No direct access.');

use \components\update\enums\PackageType;
use \components\update\packages\PackageFactory;

class Helpers extends \dependencies\BaseComponent
{
  
  static private
    $package_cache = array();
  
  protected
    $default_permission = 2,
    $permissions = array(
      'get_component_package' => 0
    );
  
  
  /**
   * Lets you rename a component package that's already installed.
   * @param array $data A string array with keys 'component' and 'old_title', guess what they do.
   * @return void
   */
  public function rename_component_package($data)
  {
    
    if($data->component->get() === '/')
      $packageFile = PATH_FRAMEWORK.DS.'.package'.DS.'package.json';
    else
      $packageFile = PATH_COMPONENTS.DS.$data->component.DS.'.package'.DS.'package.json';
    
    //Check the file is there.
    if(!is_file($packageFile))
      return Data(null);
    
    //Get package info.
    $package = Data(json_decode(file_get_contents($packageFile), true));
    
    $model = mk('Sql')
      ->table('update', 'Packages')
      ->where('title', "'{$data->old_title}'")
      ->execute_single();
    
    if($model->is_empty()){
      mk('Logging')->log('Update', 'Rename package', sprintf('Package with old title "%s" does not exist.', $data->old_title));
      return;
    }
    
    $model
      ->merge($package->having('title', 'description'))
      ->save();
    
  }
  
  /**
   * Attempts to get the component entry in the database of a given component name.
   */
  public function get_component_package($component)
  {
    
    raw($component);
    
    if(empty($component))
      return PackageFactory::get(PackageType::CORE)->model();
    else
      return PackageFactory::get(PackageType::COMPONENT, $component)->model();
    
  }
  
  protected function check_updates($options)
  {
    
    ini_set('memory_limit', '-1');
    
    //May the silent force be with you.
    $options = Data($options)->having('silent', 'force');
    
    $silent = $options->silent->is_true();
    $force = $options->force->is_true();
    
    if(!$silent){
      ?>
      <script type="text/javascript">
        jQuery(function($){
          if(app){
            $('#update-logs a.back-to-summary').click(function(e){
              e.preventDefault();
              app.Settings.loadView('update/summary');
              app.Settings.activate();
            });
          }
        });
      </script>
      <?php
    }
    
    if(!$silent) echo '<div id="update-logs">'.n.
      '<h1>'.__($this->component, 'Update logs', 1).'</h1>'.n.
      '<a class="back button grey back-to-summary" href="?view=update/summary">'.__($this->component, 'Back to summary', 1).'</a>'.br.n;
    
    $scanning = function($path)use($silent){
      if(!$silent) echo br.n.__('update', 'Scanning', 1).': <strong class="path package">'.str_replace(PATH_FRAMEWORK.DS, '../', $path).'</strong>'.br.n;
    };
    
    $updating = function($new_versions)use($silent){
      if(!$silent && $new_versions) echo '<span class="new-version-loaded">'. __('update', 'New versions loaded', 1) .'!</span>'.br.n;
      else if(!$silent) echo __('update', 'No new updates', 1).'.'.br.n;
    };
    
    //Sync core.
    $scanning(PackageFactory::directory(PackageType::CORE));
    $updating(PackageFactory::get(PackageType::CORE)->update($force, true));
    
    //Function to process any PackageType's directory.
    $scanType = function($type)use($force, $scanning, $updating)
    {
      
      //Find all files in the directory.
      $globs = glob(PackageFactory::directory($type, '*'));
      
      //Loop them.
      foreach($globs as $glob)
      {
        
        //Only directories apply as files (like .gitignore) are not packages.
        if(is_dir($glob))
        {
          
          //Let the factory find out if there is any package definition.
          $package = PackageFactory::get($type, basename($glob));
          
          //If there wasn't, skip this one without even mentioning it.
          if($package !== null){
            
            //Log a scan and update.
            $scanning($glob);
            $updating($package->update($force, true));
            
          }
          
        }
        
      }
      
    };
    
    //Look through all the types.
    $scanType(PackageType::COMPONENT);
    $scanType(PackageType::TEMPLATE);
    $scanType(PackageType::THEME);
    
    //When everything is done, see if we need to process any queued operations.
    \components\update\classes\BaseDBUpdates::process_queue();
    
    if(!$silent){
      echo '</div>';
      exit;
    } else {
      return true;
    }
    
  }
  
}
