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
    $options = $this->helper('get_page_options', $page_info->id);
    
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

  protected function app($view)
  {
    
    //Get menu and site id.
    $mid = tx('Sql')->table('menu', 'Menus')->limit(1)->execute()->{0}->id->get('int');
    $sid = $this->table('Sites')->order('title', 'ASC')->limit(1)->execute_single()->id->get('int');
    
    //the app is going to make use of all components, so we are going to load all javascript and css needed
    tx('Sql')->table('cms', 'ComponentViews')->join('Components', $c)->select("$c.name", 'name')->execute()->each(function($c){
      tx('Component')->load($c->name);
    });

    return array(
      'topbar' => $this->section('admin_toolbar'),
      'menus' => $this->view('menus', array('menu_id' => $mid, 'site_id' => $sid)),
      'menu_id' => $mid,
      'site_id' => $sid,
      'app' => $this->section('app', $view->get()),
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
    return;
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
    
    //Return the data.
    return array(
      'menus' => $this->section('menus'),
      'menu_toolbar' => $this->section('menu_toolbar', $options),
      'menu_items' => $this->section('menu_items', $options),
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
      'menu' => tx('Sql')
        ->table('cms', 'ComponentViews')
        ->where('type', "'SETTINGS'")
        ->execute(),
      'content' => ''
    );
    
  }
  
  protected function generic_site_settings()
  {
    
    $result = array();
    $multilanguage = array(
      'site_name',
      'site_description',
      'site_keywords',
      'site_author',
      'site_twitter',
      'site_googleplus'
    );
    
    foreach($multilanguage as $key){
      $result[$key] = $this->helper('get_settings', array('key'=>$key));
    }
    
    return $result;
    
  }
  
}
