<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
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
    return tx('Sql')
      ->table('cms', 'ComponentViews')
        ->where('is_config', 1)
      ->execute()
      
      //Also get the meta info we need.
      ->each(function($view){
        $view->component;
        $view->prefered_title;
        $view->prefered_description;
      });
  }
  
  protected function update_page($data, $params)
  {
    
    $pid = $params->{0};
    $pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    $data = $data->having('title', 'theme_id', 'template_id', 'layout_id', 'keywords', 'access_level', 'published', 'user_group_permissions')
      -> title         ->validate('Title', array('required', 'not_empty', 'no_html', 'between'=>array(2, 250)))->back()
      -> theme_id      ->validate('Theme', array('number', 'gt'=>0))->back()
      -> template_id   ->validate('Template', array('number', 'gt'=>0))->back()
      -> layout_id     ->validate('Layout', array('number', 'gt'=>0))->back()
      -> keywords      ->validate('Keywords', array('string', 'no_html'))->back()
      -> access_level  ->validate('Access level', array('number', 'between'=>array(0, 2)))->back()
      -> published     ->validate('Published', array('number', 'between'=>array(0, 1)))->back();
    
    $page = tx('Sql')
      ->table('cms', 'Pages')
      ->pk($pid)
      ->execute_single()
      
      ->is('empty', function(){
        throw new \exception\EmptyResult('Could not retrieve the page you were trying to edit. This could be because the ID was invalid.');
      })
      
      ->merge($data)
      ->save();
    
    tx('Component')->helpers('cms')->set_page_permissions($page->id, $data->user_group_permission);
    
    return $page;
    
  }
  
  protected function get_page_info($options, $params)
  {
    
    $pid = $params->{0};
    $pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    $page_info = $this->helper('get_page_info', $pid);
    $page_options = $this->helper('get_page_options', $page_info->id);
    
    if($page_info)
    {
      
      $content = tx('Component')
        ->views($page_info->component)
        ->get_html($page_info->view_name, $page_options);
      
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
    
    return array(
      'layout_info' => tx('Sql')->table('cms', 'LayoutInfo')->execute(),
      'page' => $page_info,
      'content' => $content,
      'permissions' => tx('Component')->helpers('cms')->get_page_permissions($page_info->id),
      'default_template' => $default_template,
      'default_theme' => $default_theme
    );
    
  }
  
  protected function get_menu_item_info($options, $params)
  {
    
    $menu = $params->{0};
    $menu->validate('Menu ID', array('required', 'number'=>'integer'));
    
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
        'view_id' => $view_id
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
        return $title->back()->info->{LANGUAGE}->title->get();
      })->back();
    
  }
  
}
