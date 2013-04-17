<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  //Expects: key_name[default|#] where # is a language ID.
  protected function update_settings($data, $params)
  {
    
    $site_id = tx('Data')->session->cms->filters->site_id->get();
    
    //Go over each key set.
    $data->each(function($set)use($site_id){
      
      //Skip empty ones.
      $set->not('empty', function($set)use($site_id){
        
        //Find out which can be replaced. (Prevents auto_increment from going too fast)
        $newKeys = array_combine($set->keys()->get('array'), $set->keys()->get('array'));
        
        //Replace all old config nodes.
        tx('Sql')
          ->table('cms', 'CmsConfig')
          ->where('key', "'{$set->key()}'")
          ->where('site_id', "'$site_id'")
          ->execute()
          ->each(function($setting)use($set, &$newKeys){
            
            //When we have a match on language, replace the old data.
            if($setting->language_id->is_set() && array_key_exists($setting->language_id->get(), $newKeys)){
              
              //Set the new value.
              $setting
                ->merge(array(
                  'value' => $set->{$settings->language_id}->get()
                ))
                ->save();
              
              //Remove, so we know what's left for us to do.
              unset($newKeys[$setting->language_id->get()]);
              
            }
            
            //When we have a match on the default setting.
            elseif($setting->language_id->is_empty() && array_key_exists('default', $newKeys)){
              
              //Set the new value.
              $setting
                ->merge(array(
                  'value' => $set->default->get()
                ))
                ->save();
              
              //Remove, so we know what's left for us to do.
              unset($newKeys['default']);
              
            }
            
            //If it's not on our list, we assume deletion was intended.
            else{
              $setting->delete();
            }
            
          });
        
        //Insert whatever is left.
        foreach($newKeys as $key){
          
          tx('Sql')
            ->model('cms', 'CmsConfig')
            ->set(array(
              'key' => $set->key(),
              'site_id' => $site_id,
              'autoload' => 1,
              'language_id' => $key == 'default' ? 'NULL' : $key,
              'value' => $set->{$key}->get()
            ))
            ->save();
          
        }
        
      });
      
    });
    
    return array(
      'success' => true
    );
    
  }
  
  protected function update_active_site($data, $params)
  {
    
    $site = tx('Sql')->table('cms', 'Sites')
      ->pk($params->{0})
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\NotFound('Site with given ID does not exist.');
      });
    
    tx('Data')->session->cms->filters->site_id->set($site->id);
    
    return array(
      'success' => true,
      'site_id' => $site->id
    );
    
  }
  
  protected function get_config_app($data, $params)
  {
    
    $view_arr = explode('/', $data->view->get());

    switch(count($view_arr)){
      case 1:
        $component = $this->component;
        $view = $view_arr[0];
        break;
      case 2:
        $component = $view_arr[0];
        $view = $view_arr[1];
        break;
    }
    
    return array(
      'contents' => tx('Component')->views($component)->get_html($view)
    );
    
  }
  
  protected function get_configbar_items($data, $params)
  {
    
    //Attempt to use the new types.
    try{
      return tx('Sql')
        ->table('cms', 'ComponentViews')
        ->where('type', "'MANAGER'")
        ->execute()
        
        //Also get the meta info we need.
        ->each(function($view){
          $view->component;
          $view->preferred_title;
          $view->preferred_description;
        });  
    }
    
    //Otherwise use a fallback.
    catch(\exception\Sql $sex){
      return tx('Sql')
        ->table('cms', 'ComponentViews')
          ->where('is_config', 1)
        ->execute()
        
        //Also get the meta info we need.
        ->each(function($view){
          $view->component;
          $view->preferred_title;
          $view->preferred_description;
        });
    }
    
  }
  
  protected function update_page($data, $params)
  {
    
    $pid = $params->{0};
    $pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    $savedata = $data->having('theme_id', 'template_id', 'layout_id', 'notes', 'access_level', 'published')
      -> theme_id     -> validate('Theme',      array('number', 'gt'=>0))                 ->back()
      -> template_id  -> validate('Template',   array('number', 'gt'=>0))                 ->back()
      -> layout_id    -> validate('Layout',     array('number', 'gt'=>0))                 ->back()
      -> notes        -> validate('Notes',      array('string', 'no_html'))               ->back()
      -> access_level -> validate('Access level', array('number', 'between'=>array(0, 3)))->back()
      -> published    -> validate('Published',  array('number', 'between'=>array(0, 1)))  ->back();
    
    $page = tx('Sql')
      ->table('cms', 'Pages')
      ->pk($pid)
      ->execute_single()
      
      ->is('empty', function(){
        throw new \exception\EmptyResult('Could not retrieve the page you were trying to edit. This could be because the ID was invalid.');
      })
      
      ->merge($savedata)
      ->save();
    
    tx('Component')->helpers('cms')->set_page_permissions($page->id, $data->user_group_permission);
    
    //Set the page as homepage?
    if($data->homepage->get('int') == 1){
      $this->update_settings(Data(array(
        'key' => 'homepage',
        'value' => array(
          'NULL' => "?pid=$pid"
        )
      )), null);
    }
    
    return $page;
    
  }
  
  protected function update_page_findability($data, $params)
  {
    
    $pid = $params->{0};
    $pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    $data = $data->having('info');
    
    $page = tx('Sql')
      ->table('cms', 'Pages')
      ->pk($pid)
      ->execute_single()
      
      ->is('empty', function(){
        throw new \exception\EmptyResult('Could not retrieve the page you were trying to edit. This could be because the ID was invalid.');
      });
    
    //Save page info.
    $data->info->each(function($info)use($data, $page){
      
      $language_id = $info->key();
      
      $info = $info->having(
          'title', 'title_recommendation', 'url_key', 'slogan', 'description', 'keywords',
          'og_title', 'og_description', 'og_keywords',
          'tw_title', 'tw_description', 'tw_author',
          'gp_author'
        )
        
        // ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
        ->title->validate('Title', array('string'))->back()
        ->title_recommendation->validate('Title recommendation', array('string'))->back()
        ->url_key->validate('URL key', array('string', 'not_empty'))->back()
        ->slogan->validate('Slogan', array('string', 'not_empty'))->back()
        ->description->validate('Description', array('string', 'not_empty'))->back()
        ->keywords->validate('Keywords', array('string', 'not_empty'))->back()
        
        ->og_title->validate('OG title', array('string', 'not_empty'))->back()
        ->og_description->validate('OG description', array('string', 'not_empty'))->back()
        ->og_keywords->validate('OG keywords', array('string', 'not_empty'))->back()
        
        ->tw_title->validate('Twitter title', array('string', 'not_empty'))->back()
        ->tw_description->validate('Twitter description', array('string', 'not_empty'))->back()
        ->tw_author->validate('Twitter author', array('string', 'not_empty'))->back()
        
        ->gp_author->validate('Google+ author', array('string', 'not_empty'))->back()
        
      ;
      
      string_if_empty($info,
        'title', 'title_recommendation', 'url_key', 'slogan', 'description', 'keywords',
        'og_title', 'og_description', 'og_keywords',
        'tw_title', 'tw_description', 'tw_author',
        'gp_author'
      );
      
      tx('Sql')
        ->table('cms', 'PageInfo')
        ->where('page_id', $page->id)
        ->where('language_id', $language_id)
        ->execute_single()
        
        //If it doesn't exist, create a new model first.
        ->is('empty', function()use($language_id, $page){
          
          return tx('Sql')
            ->model('cms', 'PageInfo')
            ->set(array(
              'page_id' => $page->id,
              'language_id' => $language_id
            ));
          
        })
        
        ->merge($info)
        ->save();

    });
    
    //Include the info.
    $page->info;
    
    return $page;
    
  }
  
  protected function get_page_info($options, $params)
  {
    
    //Get required variables.
    $pid = $params->{0};
    $page_info = $this->helper('get_page_info', $pid);
    $page_options = $this->helper('get_page_options', $page_info->id);
    
    //Validate variables.
    $pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    
    if($page_info)
    {
      
      //Include multilanguage info for the page.
      $page_info->info;
      
      //See if there is a pagetype setup for this view.
      $page_type_folder = PATH_COMPONENTS.DS.$page_info->component.DS.'pagetypes'.DS.$page_info->view_name;
      if(is_dir($page_type_folder)){
        
        $pagetype = $page_info->component.'/'.$page_info->view_name;
        
      }
      
      //Otherwise, go oldschool mode.
      else
      {
        
        $content = tx('Component')
          ->views($page_info->component)
          ->get_html($page_info->view_name, $page_options);
        
      }
      
      
    }
    
    else {
      $content = __($this->component, 'Page was removed').'.';
    }
    
    $default_template =
      $page_info->template_id->get('int') > 0 ?
      $page_info->template_id->get('int') :
      tx('Config')->user('template_id')->get('int');
    
    $default_theme =
      $page_info->theme_id->get('int') > 0 ?
      $page_info->theme_id->get('int') :
      tx('Config')->user('theme_id')->get('int');
    
    $info = array(
      'layout_info' => tx('Sql')->table('cms', 'LayoutInfo')->execute(),
      'page' => $page_info,
      'permissions' => tx('Component')->helpers('cms')->get_page_permissions($page_info->id),
      'default_template' => $default_template,
      'default_theme' => $default_theme
    );
    
    if(isset($pagetype))
      $info['pagetype'] = $pagetype;
    else
      $info['content'] = $content;
    
    ##
    ## Find out if this page is used as a home-page.
    ##
    
    //Let's assume it's not.
    $info['is_homepage'] = false;
    
    //Address the user defined home-page.
    $home = tx('Config')->user('homepage');
    
    //If it's set we have work to do.
    if($home->is_set())
    {
      
      //Convert it to a URL so we can read the parameters.
      $home_url = url($home->get(), true);
      
      //Compare the page id in the home to our own id.
      if($home_url->data->pid->get('int') == $pid->get('int')){
        $info['is_homepage'] = true;
      }
      
    }
    
    return $info;
    
  }
  
  //Delete a page.
  protected function delete_page($options, $params)
  {
    
    $page = tx('Sql')->table('cms', 'Pages')->pk($params[0])->execute_single()->not('set', function(){
      throw new \exception\EmptyResult('Could not retrieve the page you were trying to delete. This could be because the ID was invalid.');
    })
    ->merge(array('trashed' => 1))
    ->save();
    
    #TODO: Implement a way for components to hook into this method, allowing them to delete associated rows.
    
  }
  
  protected function get_menu_item_info($options, $params)
  {
    
    $menu = $params->{0};
    $menu->validate('Menu Item ID', array('required', 'number'=>'integer'));
    
    $menus = tx('Sql')
      ->table('menu', 'Menus')
      ->where('site_id', tx('Data')->filter('cms')->site_id)
      ->execute();
    
    $menus->length->set($menus->size());
    
    if($menu->get('int') > 0)
    {
      
      $item = tx('Sql')
        ->table('menu', 'MenuItems')
        ->pk($menu)
        ->execute_single()
        ->info->back();
      
    }
    
    else{
      $item = Data(array('id'=>0));
    }
    
    return array(
      'item' => $item,
      'menus' => $menus
    );
    
  }
  
  protected function get_new_page($data, $params)
  {
    
    $view_id = $params->{0};
    $view_id->validate('View ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    $menu_item_id = $params->{1};
    $menu_item_id->validate('Menu ID', array('number'=>'integer', 'gt'=>0));
    
    $page = tx('Sql')
      ->model('cms', 'Pages')
      ->set(array(
        'title' => __($this->component, 'New page', 1),
        'view_id' => $view_id,
        'template_id' => tx('Config')->user('template_id')->otherwise(1),
        'theme_id' => tx('Config')->user('theme_id')->otherwise(1)
      ))
      ->save();
    
    $result = Data($this->_call('get_page_info', array(null, Data(array(0=>$page->id)))));
    
    if($menu_item_id->is_set()){
      
      $menu_item = tx('Sql')
        ->table('menu', 'MenuItems')
        ->pk($menu_item_id)
        ->execute_single()
        ->merge(array(
          'page_id' => $page->id
        ))
        ->save()
        
        ->title->set(function($title){
          return $title->back()->info->{tx('Language')->get_language_id()}->title->get();
        })->back();
      
      $result->merge(array(
        'item' => $menu_item
      ));
      
    }
    
    return $result;
    
  }
  
  protected function get_link_page($data, $params)
  {
    
    $data = Data($data)->having('page_id', 'menu_id')
      ->page_id->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
      ->menu_id->validate('Menu ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
    ;
    
    return tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($data->menu_id)
      ->where('page_id', 'NULL')
      ->execute_single()
      
      ->is('empty', function()use($data){
        throw new \exception\EmptyResult('No menu item entry was found with id %s.', $data->menu);
      })
      
      ->merge(array('page_id' => $data->page_id))
      ->save()
      ->title->set(function($title){
        return $title->back()->info->{tx('Language')->get_language_id()}->title->get();
      })->back();
    
  }
  
  protected function get_detach_page($data, $params)
  {
    
    $data = Data($data)->having('page_id', 'menu_id')
      ->page_id->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
      ->menu_id->validate('Menu ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
    ;
    
    return tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($data->menu_id)
      ->where('page_id', $data->page_id)
      ->execute_single()
      
      ->is('empty', function()use($data){
        throw new \exception\EmptyResult('No menu item entry was found with id %s.', $data->menu);
      })
      
      ->merge(array('page_id' => 'NULL'))
      ->save()
      ->title->set(function($title){
        return $title->back()->info->{tx('Language')->id}->title->get();
      })->back();
    
  }
  
  // protected function update_settings($data, $params)
  // {
    
  //   $data->key->validate('Key', array('required', 'not_empty', 'string'));
    
  //   $data->value_default->not('empty', function()use($data){
  //     tx('Config')->user($data->key->get(), $data->value_default->get(), null);
  //   });
    
  //   $data->value->each(function($val)use($data){
      
  //     tx('Sql')
  //       ->table('cms', 'CmsConfig')
  //       ->where('key', "'{$data->key}'")
  //       ->where('language_id', $val->key() === 'NULL' ? 'NULL' : "'".$val->key()."'")
  //       ->execute_single()
        
  //       ->is('empty', function()use($data, $val){
  //         return tx('Sql')
  //           ->model('cms', 'CmsConfig')
  //           ->set(array(
  //             'key' => $data->key,
  //             'language_id' => $val->key(),
  //             'site_id' => tx('Site')->id,
  //             'autoload' => 1
  //           ));
  //       })
        
  //       ->merge(array(
  //         'value' => $val->is_empty() ? 'NULL' : $val
  //       ))
        
  //       ->save();
        
  //   });
    
  //   return $this->helper('get_settings', $data->key);
    
  // }

  protected function get_menus($data)
  {
    //Get menu's.
    return tx('Sql')
      ->table('menu', 'Menus')
      ->where('site_id', $data->options->site_id)
      ->order('title')
      ->execute();
  }
  
}
