<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{

  protected function app($view)
  {
    
    return array(
      'menu_id' => tx('Data')->get->menu,
      'page_id' => tx('Data')->get->pid,
      'edit_menu_item' => $this->section('edit_menu_item'),
      'edit_page' => $this->section('edit_page'),
      'view' => $view->get()
    );
    
  }

  protected function config_app()
  {

    $view_arr = explode('/', tx('Data')->get->view->get());

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

    $paths = array(
      'theme' => URL_THEMES.'system/backend/',
      'template' => URL_TEMPLATES.'system/backend/',
      'components' => URL_COMPONENTS,
      'component' => URL_COMPONENTS.$component.'/',
      'cms' => URL_SITE.'tx.cms/cms/'
    );

    return tx('Component')->views($component)->get_html($view, array($paths));

  }


  protected function menu_app()
  {

    if(tx('Data')->get->menu->is_set() && tx('Data')->get->menu->get('int') > 0){
      $content = $this->section('edit_menu_item', array('id'=>tx('Data')->get->menu));
    }

    elseif(tx('Data')->get->menu->is_set() && tx('Data')->get->menu->get('int') == 0){
      $content = $this->section('edit_menu_item');
    }

    elseif(tx('Data')->get->pid->is_set()){
      $content = $this->section('link_menu_item');
    }

    else{
      $content = '';
    }

    return $content;

  }

  protected function link_menu_item($options)
  {

    return array(
      'menu_items' => tx('Sql')
        ->table('menu', 'MenuItems')
          ->sk(1)
          ->add_absolute_depth('depth')
          ->join('MenuItemInfo', $mii)->left()
        ->workwith($mii)
          ->select('title', 'title')
          ->where('language_id', tx('Language')->get_language_id())
        ->execute()
    );

  }

  protected function edit_menu_item($data)
  {

    return array(
      'image_uploader' => 
        tx('Component')->available('media') ?
          tx('Component')->modules('media')->get_html('image_uploader', array(
            'insert_html' => array(
              'header' => '',
              'drop' => 'Sleep de afbeelding.',
              'upload' => 'Uploaden',
              'browse' => 'Bladeren'
            ),
            'auto_upload' => true,
            'callbacks' => array(
              'ServerFileIdReport' => 'plupload_image_file_id'
            )))
        : null
    );

  }


  protected function page_app()
  {

    if(tx('Data')->get->menu->is_set() && tx('Data')->get->menu->get('int') > 0)
    {

      $menu_item_info = tx('Sql')->table('menu', 'MenuItems')->pk(tx('Data')->get->menu)->execute_single();

      if($menu_item_info->page_id->is(function($d){return $d->is_set() && $d->get('int') > 0;})->success()){
        $content = $this->section('edit_page', array('id'=>$menu_item_info->page_id));
      }

      else{
        $content = $this->section('new_page');
      }

    }

    //edit page
    elseif(tx('Data')->get->pid->is_set())
    {
      $content = $this->section('edit_page', array('id'=>tx('Data')->get->pid));
    }

    //new menu item
    elseif(tx('Data')->get->menu->is_set() && tx('Data')->get->menu->get('int') == 0){
      $content = '';
    }

    //new page
    else{
      $content = $this->section('new_page');
    }

    return $content;

  }

  protected function new_page($options)
  {
    
    return array(
      'page_types' => tx('Sql')
        ->table('cms', 'ComponentViews')
          ->where('is_config', 0)
        ->execute(),
      'pages' => tx('Sql')->table('cms', 'Pages')
        ->join('LayoutInfo', $li)
        ->select("$li.title", 'layout_title')
        ->where('trashed', 0)
        ->order('title')
      ->execute()
    );
    
  }

  protected function edit_page($options)
  {
    
    return array(
      'languages' => tx('Sql')->table('cms', 'Languages')->execute(),
      'layout_info' => tx('Sql')->table('cms', 'LayoutInfo')->execute(),
      'themes' => $this->table('Themes')->order('title')->execute(),
      'templates' => $this->table('Templates')->order('title')->execute()
    );
    
  }
  
  protected function edit_site($options)
  {
    
    $options = tx('Data')->get->having('site_id')->merge($options->having('site_id'));
    
    $site = tx('Sql')
      ->table('cms', 'Sites')
      ->pk($options->site_id)
      ->execute_single();
    
    $site->is('empty', function()use(&$site){
      $site = tx('Sql')->model('cms', 'Sites');
    });
    
    return array(
      'item'=>$site
    );
    
  }


  protected function module_app()
  {

    return (tx('Data')->get->mid->is_set() ? tx('Controller')->load_module(tx('Data')->get->mid) : 'no module selected');

  }



  protected function menus($options)
  {

    return array(
      'all' => tx('Sql')->table('menu', 'Menus')->execute(),
      'selected' => tx('Sql')->table('menu', 'Menus')->pk(tx('Data')->filter('cms')->menu_id->is_set() ? tx('Data')->filter('cms')->menu_id : 1)->execute_single()
    );

  }
  
  //The tool-bar containing the buttons to control menu items with.
  protected function menu_toolbar($options)
  {
    
    //Get all configured sites.
    $sites = tx('Sql')->table('cms', 'Sites')->execute();
    
    //Get menu's.
    $menus = tx('Sql')
      ->table('menu', 'Menus')
      ->where('site_id', $options['site_id'])
      ->order('title')
      ->execute();
    
    return array(
      'sites' => $sites,
      'selected_site' => $options['site_id'],
      'menus' => $menus,
      'selected_menu' => $options['menu_id']
    );
    
  }
  
  protected function menu_items($options)
  {
    
    //Menu and site id.
    $mid = $options['menu_id'];
    $sid = $options['site_id'];
    
    //Get the menu.
    $menu = tx('Sql')
      ->table('menu', 'Menus')
      ->pk($mid)
      ->where('site_id', $sid)
      ->execute_single()
      
      //If no menu is found for this site id, get the first one available and pre-select it.
      ->not('set', function()use($sid){
        return tx('Sql')
          ->table('menu', 'Menus')
          ->where('site_id', $sid)
          ->order('title')
          ->limit(1)
          ->execute_single();
      });
    
    //If there is a menu with this ID and site ID, get it's items.
    $menu_items = Data();
    $menu->is('set', function()use(&$menu_items, $menu){
      $menu_items = tx('Sql')
        ->table('menu', 'MenuItems')
          ->sk($menu->id)
          ->add_absolute_depth('depth')
          ->join('MenuItemInfo', $mii)->left()
        ->workwith($mii)
          ->select('title', 'title')
          ->where('language_id', tx('Language')->get_language_id())
        ->execute();
    });

  
    return array(
      'menu_id' => $mid,
      'site_id' => $sid,
      'menu' => $menu,
      'items' => $menu_items
    );
    
  }
  
  protected function page_list($options)
  {

    return tx('Sql')->table('cms', 'Pages')
      ->join('LayoutInfo', $li)
      ->select("$li.title", 'layout_title')
      ->where('trashed', 0)
      ->order('title')
    ->execute();
  }
  
  protected function site_list($options)
  {

    return tx('Sql')->table('cms', 'Sites')
      ->order('title')
      ->execute();
  }

  protected function configbar()
  {
    
    return array();
    
  }

  protected function admin_toolbar()
  {

    return array(
      'website_url'=>url(URL_BASE.'?menu=KEEP&pid=KEEP', true),
      'edit_url'=>url(URL_BASE.'?action=cms/editable', true),
      'advanced_url'=>url(URL_BASE.'admin/?menu=KEEP&pid=KEEP', true),
      'admin_url'=>url(URL_BASE.'admin/?project_id=KEEP', true)
    );

  }

  protected function setting_list()
  {

    return $this->helper('get_settings');

  }

  protected function setting_edit()
  {

    return array(
      'item' => $this->helper('get_settings', tx('Data')->get->setting_id)
    );

  }

  protected function ip_list()
  {

    return $this->table('IpAddresses')->order('login_level')->order('address')->execute();

  }

  protected function ip_edit()
  {

    return array(
      'item' => $this->table('IpAddresses')->pk("'".tx('Data')->get->address."'")->execute_single()
    );

  }

  protected function setting_edit_simple()
  {

    $config = Data();
    $this->helper('get_settings')->each(function($row)use(&$config){
      $config->{$row->key} = $row->value->get();
    });

    return array(
      'config' => $config,
      'pages' => $this->table('Pages')->where('trashed', 0)->order('title')->execute()
    );

  }

  protected function theme_list()
  {

    return array();

  }

  protected function template_list()
  {

    return array();

  }
  
  //A login form.
  protected function login_form()
  {
    
    return tx('Component')->sections('account')->get_html('login_form');
    
  }

}
