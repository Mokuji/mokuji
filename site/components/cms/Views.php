<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{

  protected function page()
  {

    /* ? *\

      Handle page restrictions and
      throw an \exception\Authorisation
      in case necessary

    \* ¿ */

    $page_info = $this->helper('get_page_info', tx('Data')->get->pid);
    $part=null;
    $options=array();

    tx('Sql')->table('cms', 'Layouts')
      ->parent_pk(true, (!is_null($part) ? $part : $page_info->layout_id))
      ->execute()
      ->not('empty')
      ->success(function($layout)use(&$return, $page_info, $options){
        
        $layout->hwalk(function($node, $key, $delta)use(&$return, $page_info, $options){
          
          if($delta == 0){
            switch($node->content_type->get())
            {
              
              case 'm'://odule
                $return .=
                  '<div class="tx-layout-part tx-module-wrapper" rel="'.$node->id.'">'."\n".
                    '(((a list of modules to be loaded)))'."\n".
                  '</div>'."\n";
                break;

              case 'c'://omponent
                $return .=
                '<div class="tx-layout-part tx-component-wrapper" rel="'.$node->id.'">'."\n".
                  tx('Component')->views($page_info->component)->get_html($page_info->view_name, $options)."\n".
                '</div>'."\n";
                break;

              default: break;

            }
          }

          elseif($delta > 0){
            $return .= '<div class="tx-layout-part tx-layout-split-'.$node->split.'" rel="'.$node->id.'">'."\n";
          }

          elseif($delta < 0){
            $return .= '</div>'."\n";
          }

        });

      })
      ->failure(function()use(&$return, $page_info, $options){
        $return = tx('Component')->views($page_info->component)->get_html($page_info->view_name, $options)."\n";
      });

    return $return;

  }

  protected function mod()
  {
    $module = tx('Sql')->execute_single('SELECT *, (SELECT name FROM #__cms_components WHERE id = pm.com_id) AS component FROM #__page_modules AS pm WHERE id = '.tx('Data')->get->mid);
    return load_module($module->component, $module->name);
  }


  protected function app()
  {

    //the app is going to make use of all components, so we are going to load all javascript and css needed
    tx('Sql')->table('cms', 'ComponentViews')->join('Components', $c)->select("$c.name", 'name')->execute()->each(function($c){
      tx('Component')->load($c->name);
    });

    return array(
      'topbar' => $this->section('admin_toolbar'),
      'menus' => $this->view('menus'),
      'app' => $this->section(tx('Data')->get->view->is_set() ? 'config_app' : 'app'),
      'sites' => tx('Sql')->table('cms', 'Sites')->execute()
    );

  }

  protected function pages()
  {
    return array(
      'pages' => $this->section('page_list'),
      'new_page' => $this->section('new_page')
    );
  }
  
  protected function sites()
  {
    return array(
      'sites' => $this->section('site_list'),
      'new_site' => $this->section('edit_site')
    );
  }
  
  protected function modules()
  {

    return array(
      'all' => tx('Sql')
        ->table('cms', 'Modules')
          ->join('Components', $c)
        ->select("$c.name", 'component')
          ->join('ModulesPageLink', $p)
        ->where("$p.page_id", tx('Data')->get->pid)
        ->execute()
    );

  }

  protected function menus($options)
  {

    return array(
      'menus' => $this->section('menus'),
      'items' => $this->section('menu_items'),
      'configbar' => $this->section('configbar')
    );

  }

  protected function instructions()
  {
    return null;
  }

  protected function settings()
  {
    return array(
      'setting_list' => $this->section('setting_list'),
      'setting_edit_simple' => $this->section('setting_edit_simple'),
      'ip_list' => $this->section('ip_list'),
      'theme_list' => $this->section('theme_list'),
      'template_list' => $this->section('template_list')
    );
  }

}
