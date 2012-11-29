<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{

  protected function app()
  {

    return array(
      'menu' => $this->section('menu_app'),
      'page' => $this->section('page_app')
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
        ->where('page_id', 'NULL')
        ->workwith($mii)
          ->select('title', 'title')
          ->where('language_id', LANGUAGE)
        ->execute()
    );

  }

  protected function edit_menu_item($data)
  {

    return array(
      'item' => tx('Sql')->table('menu', 'MenuItems')->where('id', $data->id)->execute_single(),
      'menus' => tx('Sql')->table('menu', 'Menus')->where('site_id', tx('Data')->filter('cms')->site_id)->execute(),
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
    
    $page_info = $this->helper('get_page_info', $options->id->is_set() ? $options->id->get('int') : tx('Data')->filter('cms')->pid->get('int'));
    $page_options = $this->helper('get_page_options', $page_info->id);
    
    return array(
      'layout_info' => tx('Sql')->table('cms', 'LayoutInfo')->execute(),
      'page' => $page_info,
      'content' => $page_info === false ? 'Page was removed.' : tx('Component')->views($page_info->component)->get_html($page_info->view_name, $page_options),
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
  
  protected function menu_items($options)
  {
    
    //Get menu id and set it in session filters.
    $mid = tx('Data')->filter('cms')->menu_id->is_set() ? tx('Data')->filter('cms')->menu_id : '1';
    tx('Data')->session->cms->filters->menu_id->set(data_of($mid));
    
    //Get site id and set it in sessions filters.
    $sid = tx('Data')->filter('cms')->site_id->is_set() ? tx('Data')->filter('cms')->site_id : tx('Site')->id;
    tx('Data')->session->cms->filters->site_id->set(data_of($sid));
    
    //Get menu's.
    $menus = tx('Sql')
      ->table('menu', 'Menus')
      ->where('site_id', $sid)
      ->order('title')
      ->execute()
      ->is('empty', function($menus){
        // $menus->{0}->set(array(
        //   'title'=>__('No menu\'s found')
        // ));
      });
    
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
          ->where('language_id', LANGUAGE)
        ->execute();
    });

    //Get all configured sites.
    $sites = tx('Sql')->table('cms', 'Sites')->execute();
  
    return array(
      'menu_id' => $mid,
      'site_id' => $sid,
      'sites' => $sites,
      'menus' => $menus,
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
    
    return array(
      'items' => tx('Sql')
        ->table('cms', 'ComponentViews')
          ->where('is_config', 1)
        ->execute()
    );
    
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
