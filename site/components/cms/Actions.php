<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{

  protected
    $permissions = array(
      'select_menu' => 2,
      'new_page' => 2,
      'edit_page' => 2,
      'logout' => 1
    );
  
  protected function select_menu($data)
  {

    $action = tx('Selecting a menu.', function()use($data){
      $data->menu_id->validate('Menu', array('number'))->moveto(tx('Data')->session->cms->filters->menu_id);
    });

    tx('Controller')->message(array(
      'notification'=>$action->get_user_message()
    ));

    tx('Url')->redirect(url('menu_id=NULL'));

  }

  protected function link_page($data)
  {

    $action = tx('Adding a new menu item <-> page link.', function()use($data){

      tx('Sql')->table('menu', 'MenuItems')->pk($data->menu_item_id)->execute_single()->is('empty', function()use($data){
        throw new \exception\EmptyResult('No menu item entry was found with id %s.', $data->menu_item_id);
      })
      ->merge($data->having('page_id'))->save();

    });

    $action->failure(function($info){
      // tx('Controller')->messages('error', $info->get_user_message());
    });

    if($data->redirect->is_set()){
      tx('Url')->redirect(url("section=cms/app&menu={$data->menu_item_id}&pid={$data->page_id}", true));
    }

  }

  protected function detach_page($data)
  {

    $data
      ->menu->validate('Menu identifier', array('required', 'number'))->back()
      ->pid->validate('Page identifier', array('required', 'number'));
  
    $action = tx('Detaching a page from a menu item.', function()use($data){

      tx('Sql')->table('menu', 'MenuItems')->pk($data->menu)->where('page_id', $data->pid)->execute_single()->is('empty', function()use($data){
        throw new \exception\EmptyResult('No menu item entry was found with id %s.', $data->menu);
      })
      ->merge(array('page_id' => 'NULL'))
      ->save();

    })->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });
    
    tx('Url')->redirect("section=cms/app&menu={$data->menu}");

  }

  protected function new_page($data)
  {

    $page = null;

    tx('Adding a new page.', function()use($data){
      
      //save page
      $page = tx('Sql')->model('cms', 'Pages')->set(array(
        'title' => __('New page', 1),
        'view_id' => $data->view_id->validate('View', array('required', 'number'))
      ))
      ->save();
      
      if($data->link_to->is_set())
      {

        tx('Component')->actions('cms')->call('link_page', Data(array(
          'page_id' => $page->id,
          'menu_item_id' => $data->link_to
        )));

        tx('Url')->redirect(url("section=cms/app&menu={$data->link_to}&pid={$page->id}", true));

      }

      else{
        tx('Url')->redirect("section=cms/app&pid={$page->id}");
      }

    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });

  }

  protected function edit_page($data)
  {

    tx('Editing page.', function()use($data){

      // $data
        // -> title         ->validate('Title', array('required', 'not_empty', 'no_html', 'between'=>array(2, 250)))->back()
        // -> theme_id      ->validate('Theme', array('number', 'gt'=>0))->back()
        // -> template_id   ->validate('Template', array('number', 'gt'=>0))->back()
        // -> layout_id     ->validate('Layout', array('number', 'gt'=>0))->back()
        // -> keywords      ->validate('Keywords', array('string', 'no_html'))->back()
        // -> access_level  ->validate('Access level', array('number', 'between'=>array(0, 2)))->back()
        // -> published     ->validate('Published', array('number', 'between'=>array(0, 1)))->back()
        // -> p_from        ->un_set()->back()
        // -> p_to          ->un_set()->back()
        // -> trashed       ->un_set()->back();
      
      $page = tx('Sql')->table('cms', 'Pages')->pk($data->page_id)->execute_single()->not('set', function(){
        throw new \exception\EmptyResult('Could not retrieve the page you were trying to edit. This could be because the ID was invalid.');
      })
      ->merge($data)
      ->save();
      
      tx('Component')->helpers('cms')->set_page_permissions($page->id, $data->user_group_permission);
      
      //Delete existing page info.
      tx('Sql')->table('cms', 'PageInfo')->where('page_id', $page->id)->execute()->each(function($row){
        $row->delete();
      });

      //Save page info.
      $data->info->each(function($info)use($data, $page){

        $language_id = $info->key();
        $info->each(function($val)use($info, $page, $language_id){

        tx('Sql')->table('cms', 'PageInfo')->where('page_id', $page->id)->where('language_id', $language_id)->execute_single()->is('empty')
          ->success(function()use($info, $language_id, $page){
            tx('Sql')->model('cms', 'PageInfo')->set($info->having('title', 'slogan'))->merge(array('page_id' => $page->id, 'language_id' => $language_id))->save();
          })
          ->failure(function($page_info)use($info, $language_id){
            $page_info->merge($info->having('title', 'slogan'))->save();
          });

        });

      });

    })

    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });

    exit;

  }

  protected function delete_page($data)
  {

    tx('Deleting page.', function()use($data){

      //delete
      $page = tx('Sql')->table('cms', 'Pages')->pk($data->page_id)->execute_single()->not('set', function(){
        throw new \exception\EmptyResult('Could not retrieve the page you were trying to delete. This could be because the ID was invalid.');
      })
      ->merge(array('trashed' => 1))
      ->save();

      tx('Sql')->table('text', 'Items')->where('page_id', $page->id)->execute()->each(function($row){
        $row->delete();
      });

    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

  }

  protected function save_menu_item($data)
  {
   
    $data->image_id = $data->image_id->otherwise(0);
    
    $item = null;
    tx($data->id->get('int') > 0 ? 'Updating a menu item.' : 'Adding a new menu item', function()use($data, &$item){

      //See if menu item exists.
      tx('Sql')
        ->table('menu', 'MenuItems')
        ->pk($data->id->get('int'))
        ->execute_single()
        ->is('empty')
        
          //Insert.
          ->success(function()use($data, &$item){
                                                
            $item = tx('Sql')
              ->model('menu', 'MenuItems')
              ->merge($data->having('menu_id', 'page_id', 'image_id'))
              ->hsave(null, 0);
                      
          })
          
          //Update.
          ->failure(function($result)use($data, &$item){
            
            //Check if menu_id changed.
            $item = $result;
            $item->menu_id->eq($data->menu_id)
              
              //When changing menu_id we need to ensure proper lft-rgt positions.
              ->failure(function()use($item, $data){
                $item
                  ->hdelete()
                  ->merge($data->having('page_id', 'image_id', 'menu_id'))
                  ->hsave(null, 0);
              })
              
              //When not changing menu_id, leave it out and use normal save.
              ->success(function()use($item, $data){
                $item
                  ->merge($data->having('page_id', 'image_id'))
                  ->save();
              });
            
          });
      
      //Go over each menu item info language.
      $data->info->each(function($info, $key)use(&$item){
        
        //Update info multi-language style. :>
        $item->info->{$key}
          ->not('set', function($info){
            return tx('Sql')->model('menu', 'MenuItemInfo');
          })
          ->merge($info->having('title', 'description')) //Set new values.
          ->merge(array('item_id' => $item->id, 'language_id'=>$key)) //Update item_id in case of re-insert.
          ->save();
        
      });
      
    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });
    
    tx('Url')->redirect(url('section=cms/app&menu='.$item->id, true));

  }
  
  protected function login($data)
  {
    
    throw new \exception\Deprecated();
    
    $data = $data->having('email', 'pass');

    tx('Logging in.', function()use($data){

      $data
        -> email   ->validate('Email address', array())->back()
        -> pass    ->validate('Password', array('required', 'not_empty', 'between'=>array(3, 64)));

      tx('Account')->login($data->email, $data->pass);

    })

    ->failure(function($info){

      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    $prev = tx('Url')->previous();

    if($prev !== false){
      tx('Url')->redirect($prev);
    }

    tx('Url')->redirect(url('email=NULL&pass=NULL', false, ($prev !== false)));

  }

  protected function logout($data)
  {
    
    throw new \exception\Deprecated('Please use account/logout');
    
    tx('Logging out.', function(){tx('Account')->logout();})->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

  }

  protected function register($data)
  {
    
    throw new \exception\Deprecated();
    
    $data = $data->having('email', 'username', 'password');

    tx('Registering a new account.', function()use($data){

      $data
        -> email   ->validate('Email address', array('required', 'not_empty', 'email'))->back()
        -> username->validate('Username', array('no_html'))->back()
        -> password->validate('Password', array('required', 'not_empty', 'between'=>array(3, 30)));
      tx('Account')->register($data->email, $data->username, $data->password);

    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    tx('Url')->redirect('email=NULL&username=NULL&pass=NULL');

  }

  protected function save_settings_simple($data)
  {

    tx($data->id->get('int') > 0 ? 'Updating a config key/value pair.' : 'Adding a new config key/value pair.', function()use($data){
      
      $data = $data->having('homepage', 'login_page');
      
      tx('Sql')->table('cms', 'CmsConfig')->where('key', "'homepage'")->execute_single()->is('empty', function(){
        throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
      })
      ->merge(array('value' => $data->homepage))->save();

      tx('Sql')->table('cms', 'CmsConfig')->where('key', "'login_page'")->execute_single()->is('empty', function(){
        throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
      })
      ->merge(array('value' => $data->login_page))->save();
      
    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    tx('Url')->redirect('?section=cms/setting_list&setting_id=NULL');

  }

  protected function update_ip_addresses($data)
  {

    tx($data->id->get('int') > 0 ? 'Updating an ip address.' : 'Adding an ip address.', function()use($data){
      
      $data = $data->having('address', 'login_level');
      
      tx('Sql')->table('cms', 'IpAddresses')->where('address', "'".$data->address."'")->execute_single()->is('empty', function()use($data){
        tx('Sql')->model('cms', 'IpAddresses')->set($data)->save();
      })->failure(function($item)use($data){
        $item->merge($data)->save();
      });

    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    tx('Url')->redirect('?section=cms/ip_list&address=NULL');

  }

  protected function update_cms_config($data)
  {
    
    tx($data->id->get('int') > 0 ? 'Updating a config key/value pair.' : 'Adding a new config key/value pair.', function()use($data){
      
      $data = $data->having('id', 'key', 'value', 'site_id', 'autoload')
        ->site_id->validate('Site ID', array('required', 'number'=>'integer', 'gte'=>0))->back()
        ->autoload->validate('Site ID', array('required', 'number'=>'integer'))->back()
        ->key->validate('Key', array('required', 'string'))->back()
        ->value->validate('Value', array('required', 'string'))->back()
      ;
      
      //update
      if($data->id->get('int') > 0)
      {
        $item = tx('Sql')->table('cms', 'CmsConfig')->pk($data->id)->execute_single()->is('empty', function(){
          throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
        })
        ->merge($data)->save();
      
      }
      
    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    tx('Url')->redirect('?section=cms/setting_list&setting_id=NULL');

  }

  protected function language($data)
  {

    tx('Setting the language.', function()use($data){
      $data->lang_id->validate('Language', array('number'=>'integer'))->moveto(tx('Data')->session->tx->language);
    })

    ->failure(function($info){
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    tx('Url')->redirect('lang_id=NULL');

  }

  protected function pause_redirects($data=null)
  {
    if(DEBUG){
      tx('Data')->session->tx->debug->pause_redirects = true;
    }else{
      throw new \exception\Authorisation('DEBUG mode has to be on in order to pause redirects.');
    }
  }

  protected function play_redirects($data=null)
  {
    tx('Data')->session->tx->debug->pause_redirects->un_set();
  }
  
  protected function insert_sites($data)
  {
    
    tx('Inserting a site.', function()use($data){
      
      $data = $data->having('title', 'domain', 'path_base', 'url_path')
        ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
        ->domain->validate('Domain', array('required', 'string', 'not_empty'))->back()
        ->path_base->validate('Path base', array('required', 'string', 'not_empty'))->back()
        ->url_path->validate('URL path', array('required', 'string', 'not_empty'))->back()
      ;
      
      tx('Sql')
        ->model('cms', 'Sites')
        ->merge($data)
        ->save();
      
    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    tx('Url')->redirect('?section=cms/site_list', true);

  }
  
  protected function update_sites($data)
  {
    
    tx('Updating a site.', function()use($data){
      
      $data = $data->having('id', 'title', 'domain', 'path_base', 'url_path')
        ->id->validate('Site ID', array('required', 'number'=>'integer', 'gte'=>0))->back()
        ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
        ->domain->validate('Domain', array('required', 'string', 'not_empty'))->back()
        ->path_base->validate('Path base', array('required', 'string', 'not_empty'))->back()
        ->url_path->validate('URL path', array('required', 'string', 'not_empty'))->back()
      ;
      
      $item = tx('Sql')
        ->table('cms', 'Sites')
        ->pk($data->id)
        ->execute_single()
        ->is('empty', function(){
          throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
        })
        ->merge($data)
        ->save();
      
    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    tx('Url')->redirect('?section=cms/site_list', true);

  }

  protected function send_feedback($data){
    $feedback =
      'IP address: '.tx('Data')->server->REMOTE_ADDR."\n".
      'More detailed host address: '.gethostbyaddr(tx('Data')->server->REMOTE_ADDR)."\n".
      'Browser info: '.tx('Data')->server->HTTP_USER_AGENT."\n".
      'Request URL: '.tx('Data')->server->REQUEST_URI."\n".
      'Referer URL: '.tx('Data')->server->HTTP_REFERER."\n".
      'Feedback given:'."\n\n".
      $data->feedback;
      
    mail(EMAIL_ADDRESS_WEBMASTER, 'Feedback for: '.URL_BASE, $feedback, 'FROM: '.EMAIL_NAME_AUTOMATED_MESSAGES.' <'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>');
  }
  
  protected function save_menu_link($data)
  {
    
    tx('Saving a menu link.', function()use($data){
      
      $data = $data->having('page_id', 'menu_item_id', 'link_action')
        ->page_id->validate('Page ID', array('required', 'number'=>'integer', 'gte'=>0))->back()
        ->menu_item_id->validate('Menu item ID', array('required', 'number'=>'integer', 'gte'=>0))->back()
        ->link_action->validate('Action', array('required', 'number'=>'integer', 'between'=>array(0,1)))->back()
      ;
      
      $link = tx('Sql')
        ->table('cms', 'MenuLinks')
        ->pk($data->page_id)
        ->execute_single()
        ->is('empty', function(){
          return tx('Sql')
            ->model('cms', 'MenuLinks');
        })
        ->merge($data)
        ->save();
      
      echo $link->page_id->get();
      exit;
      
    })
    
    ->success(function($info){
      tx('Controller')->message($info->get_user_message());
    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });

  }

}
