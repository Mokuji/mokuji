<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class EntryPoint extends \dependencies\BaseEntryPoint
{

  public function entrance()
  {

    if(tx('Config')->system()->check('backend'))
    {
      
      //Display a login page?
      if(!tx('Account')->user->check('login'))
      {
        
        //die(tx('Component')->sections('account')->get_html('login_form'));
        
        return $this->template('tx_login', 'tx_login', array(), array(
          'content' => tx('Component')->sections('account')->get_html('login_form')
        ));
        
      }
      
      //Set site_id filter.
      tx('Data')->get->goto_site_id->is('set')
        ->success(function($gtsid){
          tx('Data')->session->cms->filters->site_id = $gtsid->get();
        })
        ->failure(function(){
          tx('Data')->session->cms->filters->site_id = tx('Site')->id;
        });
      
      return $this->template('cms_backend', 'cms_backend', array(
        'plugins' =>  array(
          load_plugin('jquery'),
          load_plugin('jquery_ui'),
          load_plugin('jquery_comboselect'),
          load_plugin('jquery_postpone'),
          load_plugin('nestedsortable'),
          load_plugin('jquery_formtoobject'),
          load_plugin('ckfinder'),
          load_plugin('ckeditor'),
          load_plugin('jquery_tmpl'),
          load_plugin('jsFramework'),
          load_plugin('underscore'),
          load_plugin('idtabs3')
        ),
        'scripts' => array(
          'cms_backend' => '<script type="text/javascript" src="'.URL_COMPONENTS.'/cms/includes/backend.js"></script>'
        )
      ),
      array(
        'content' => $this->view('app')
      ));


    }

    else
    {

      $that = $this;

      tx('Validating get variables', function(){

        //validate page id
        tx('Data')->get->pid->not('set', function(){
          throw new \exception\User('Missing the page ID.');
        })->validate('Page ID', array('number'=>'integer', 'gt'=>0));

        //check if page id is present in database
        $page = tx('Sql')
          ->table('cms', 'Pages')
          ->pk(tx('Data')->get->pid)
          ->execute_single()
          ->is('empty', function(){
            throw new \exception\EmptyResult('The page ID does not refer to an existing page.');
          });
        
        //Check user permissions.
        tx('Component')->helpers('cms')->page_authorisation($page->id);
        
        //validate module id
        tx('Data')->get->mid->is('set', function($mid){
          $mid->validate('Module ID', array('number'=>'integer', 'gt'=>0));
        });

      })

      ->failure(function(){

        //first see if we can go back to where we came from
        $prev = tx('Url')->previous(false, false);
        if($prev !== false && !$prev->compare(tx('Url')->url)){
          tx('Url')->redirect(url($prev, true));
          return;
        }

        tx('Config')->user('homepage')->is('set', function($homepage){

          $redirect = url($homepage);

          $redirect->data->pid->is('set')->and_is(function($pid){
            return tx('Sql')
              ->table('cms', 'Pages')
              ->pk(tx('Data')->get->pid)
              ->execute_single()
              ->is_set();
          })
          ->success(function()use($redirect){tx('Url')->redirect($redirect);})
          ->failure(function(){tx('Url')->redirect('/admin/');});

        });

      })

      ->success(function()use($that, &$output){
        
        //load a layout-part
        if(tx('Data')->get->part->is_set()){
          $output = $that->section('page_part');
        }
        
        //or are we going to load an entire page?
        elseif(tx('Data')->get->pid->is_set()){

          $pi = $that->helper('get_page_info', tx('Data')->get->pid);

          $output = $that->template($pi->template, $pi->theme, array(
            'plugins' =>  array(
                            load_plugin('jquery'),
                            load_plugin('jquery_ui'),
                            load_plugin('nestedsortable'),
                            load_plugin('jsFramework')
                          )
          ),
          array(
            'admin_toolbar' => $that->section('admin_toolbar'),
            'content' => $that->view('page')
          ));

        }

        else{
          throw new \exception\Unexpected('Failed to detect what to load. :(');
        }

      });

      return $output;

    }

  }

}
