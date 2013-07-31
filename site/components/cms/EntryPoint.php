<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class EntryPoint extends \dependencies\BaseEntryPoint
{

  public function entrance()
  {
    
    //When loading PageType templates
    if(tx('Data')->get->pagetypetemplate->is_set()){
      
      $parts = explode('/', tx('Data')->get->pagetypetemplate->get());
      $com = array_shift($parts);
      $pagetype = array_shift($parts);
      $tmpl = implode('/', $parts);
      
      $path = PATH_COMPONENTS.DS.$com.DS.'pagetypes'.DS.$pagetype.DS.$tmpl;
      
      return load_html($path, array(
        'component' => $com,
        'pagetype' => $pagetype
      ));
      
    }
    
    //Backend
    if(tx('Config')->system()->check('backend'))
    {
      
      //Display a login page?
      if(!tx('Account')->user->check('login'))
      {
        
        //Use the previous scheme unless the on-login option is desired.
        $targetScheme = tx('Url')->url->segments->scheme->get();
        if(tx('Config')->user('tls_mode')->get('string') === 'logged-in')
          $targetScheme = 'https';
        
        //Redirect to custom login page is available.
        if(url('')->segments->path == '/admin/' && tx('Config')->user()->login_page->not('empty')->get('bool')){
          $goto = url(URL_BASE.tx('Config')->user()->login_page, true)->segments->merge(array('scheme' => $targetScheme))->back()->rebuild_output();
          header("Location: ".$goto);
        }
        
        if($targetScheme !== tx('Url')->url->segments->scheme->get())
          tx('Url')->redirect(url('')->segments->merge(array('scheme' => $targetScheme))->back()->rebuild_output());
        
        //Check for password reset process.
        if(tx('Data')->get->password_forgotten->get() === 'init'){
          
          return $this->template('tx_login', 'tx_login', array('plugins' =>  array(
            load_plugin('jquery'),
            load_plugin('jquery_rest')
          )), array(
            'content' => tx('Component')->sections('account')->get_html('password_forgotten')
          ));
          
        }
        
        //Check for password reset process.
        if(tx('Data')->get->password_forgotten->get() === 'token'){
          
          return $this->template('tx_login', 'tx_login', array('plugins' =>  array(
            load_plugin('jquery'),
            load_plugin('jquery_rest')
          )), array(
            'content' => tx('Component')->sections('account')->get_html('password_forgotten_token', tx('Data')->get->having('token'))
          ));
          
        }
        
        //Otherwise: show awesome login screen.
        return $this->template('tx_login', 'tx_login', array('plugins' =>  array(
          load_plugin('jquery'),
          load_plugin('jquery_rest')
        )), array(
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
      
      if(tx('Component')->available('helpchat'))
        tx('Component')->sections('helpchat')->call('widget');
      
      return $this->template('cms_backend', 'cms_backend', array(
        'plugins' =>  array(
          load_plugin('jquery'),
          load_plugin('jquery_ui'),
          load_plugin('jquery_rest'),
          load_plugin('jquery_comboselect'),
          load_plugin('jquery_postpone'),
          load_plugin('nestedsortable'),
          load_plugin('ckeditor'),
          load_plugin('elfinder'),
          load_plugin('jquery_tmpl'),
          load_plugin('jsFramework'),
          load_plugin('underscore'),
          load_plugin('idtabs3')
        ),
        'scripts' => array(
          'cms_cms' => t.t.'<script type="text/javascript" src="'.URL_COMPONENTS.'cms/includes/cms.js"></script>',
          'cms_backend' => t.t.'<script type="text/javascript" src="'.URL_COMPONENTS.'cms/includes/backend.js"></script>',
          'cms_backend_pagetype' => t.t.'<script type="text/javascript" src="'.URL_COMPONENTS.'cms/includes/PageType.js"></script>',
          'i18nSetup' => t.t.'<script type="text/javascript">i18nSetup("'.tx('Language')->code.'", "'.URL_BASE.'");</script>'
        )
      ),
      array(
        'content' => $this->view('app', tx('Data')->get->view->get())
      ));


    }
    
    //Frontend
    else
    {

      $that = $this;
      
      //If we need to claim our account, do that now before anything else.
      if(tx('Component')->helpers('account')->call('should_claim'))
      {
        
        $template_id = tx('Config')->user('forced_template_id')->otherwise(tx('Config')->user('template_id')->otherwise(1)->get('int'));
        $template = tx('Sql')->table('cms', 'Templates')->pk($template_id)->execute_single();
        
        $theme_id = tx('Config')->user('forced_theme_id')->otherwise(tx('Config')->user('theme_id')->otherwise(1)->get('int'));
        $theme = tx('Sql')->table('cms', 'Themes')->pk($theme_id)->execute_single();
        
        //Define plugins to be loaded.
        $plugins = array(
          load_plugin('jquery'),
          load_plugin('jquery_rest'),
          load_plugin('jquery_postpone')
        );
        
        return $that->template($template->name, $theme->name, array(
          'title' => __('cms', 'Claim your account', true),
          'plugins' => $plugins,
        ),
        array(
          'content' => tx('Component')->views('account')->get_html('claim_account')
        ));
        
      }
      
      //Validate input variables to see if they will generate proper content.
      tx('Validating input.', function()use($that){
        
        //Address page ID.
        tx('Data')->get->pid
        
        //Validate it.
        ->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
        
        //Get the record for this page from the database.
        $page = tx('Sql')
        ->table('cms', 'Pages')
        ->pk(tx('Data')->get->pid)
        ->execute_single()
        
        //If the records didn't exist. We assume the page-id is invalid.
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
      
      //If any of the above validations failed..
      ->failure(function(){
        
        //Don't redirect user to previous. Since this can be forged.
        
        //Address the user-defined home page in the configuration.
        tx('Config')->user('homepage')
        
        //Check if it's set.
        ->is('set')
        
        //In case it is.. We will attempt to redirect there.
        ->success(function($homepage){
          
          //Make the redirect URL.
          $redirect = url($homepage);
          
          //Validate if the homepage will lead to a valid page.
          $redirect->data->pid->is('set')->and_is(function($pid){
            return tx('Sql')
              ->table('cms', 'Pages')
              ->pk($pid)
              ->execute_single()
              ->is_set();
          })
          
          //In case it does - redirect there.
          ->success(function()use($redirect){tx('Url')->redirect($redirect);})
          
          //Otherwise we'll redirect to the administrators panel.
          ->failure(function(){tx('Url')->redirect('/admin/');});

        })
        
        //In case there is no home page defined, we'll redirect to the administrators panel.
        ->failure(function(){
          tx('Url')->redirect('/admin/');
        });

      })
      
      //In case all validations succeeded, we can load the requested page.
      ->success(function()use($that, &$output){
        
        //load a layout-part
        if(tx('Data')->get->part->is_set()){
          $output = $that->section('page_part');
        }
        
        //or are we going to load an entire page?
        elseif(tx('Data')->get->pid->is_set()){
          
          $pi = $that->helper('get_page_info', tx('Data')->get->pid);
          $mid = tx('Data')->get->menu->get();
          $lpi = $pi->info->{tx('Language')->get_language_id()};
          
          //See if the URL key is correct.
          $url_key = $lpi->url_key;
          $pretty_url = URL_BASE."{$pi->id}/{$url_key}?menu={$mid}";
          if($url_key->is_set() && $url_key->get() != tx('Data')->get->pkey->get()){
            header('Location: '.$pretty_url);
            return;
          }
          
          //If forced theme is set: re-set theme id.
          if(tx('Config')->user('forced_theme_id')->get() > 0){
            $pi->theme->set($that->table('Themes')->pk(tx('Config')->user('forced_theme_id'))->execute_single()->name);
          }

          /* ------- Set all the headers! ------- */
          
          //TODO: improve some of the default site-wide settings
          //TODO: thumbnail images for twitter/facebook
          //TODO: author en (publish tijden?) voor facebook
          
          $site_name = tx('Config')->user('site_name')->otherwise('My Mokuji Website');
          $site_twitter = tx('Config')->user('site_twitter');
          $site_googleplus = tx('Config')->user('site_googleplus');
          $site_author = tx('Config')->user('site_author');
          $site_description = tx('Config')->user('site_description')->otherwise('');
          $site_keywords = tx('Config')->user('site_keywords')->otherwise('');
          $title = $lpi->title->otherwise($lpi->title_recommendation->otherwise($pi->title))->get();
          $title .= ($title ? ' - ' : '') . $site_name;
          $description = $lpi->description->otherwise($site_description)->get();
          $keywords = $lpi->keywords->otherwise($site_keywords)->get();
          
          tx('Ob')->meta('Page Headers');
?>
    <!-- Standard HTML SEO -->
    <meta http-equiv="content-language" content="<?php echo tx('Language')->get_language_code(); ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="author" content="<?php echo $lpi->author->otherwise($site_author); ?>" />

    <!-- Open Graph (Facebook) -->
    <meta property="og:url" content="<?php echo $pretty_url; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:article:tag" content="<?php echo $lpi->og_keywords->otherwise($keywords); ?>" />
    <meta property="og:locale" content="<?php echo tx('Language')->get_language_code(); ?>" />
    <meta property="og:title" content="<?php echo $lpi->og_title->otherwise($title); ?>" />
    <meta property="og:description" content="<?php echo $lpi->og_description->otherwise($description); ?>" />
    <meta property="og:site_name" content="<?php echo $site_name; ?>" />

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo $lpi->tw_title->otherwise($title); ?>" />
    <meta name="twitter:description" content="<?php echo $lpi->tw_description->otherwise($description); ?>" />
    <meta name="twitter:url" content="<?php echo $pretty_url; ?>" />
    <meta name="twitter:site" content="<?php echo $site_twitter; ?>" />
    <meta name="twitter:creator" content="<?php echo $lpi->tw_author->otherwise($site_twitter); ?>" />

    <!-- Google+ Authorship -->
    <link rel="author" href="<?php echo $lpi->gp_author->otherwise($site_googleplus); ?>" />
<?php tx('Ob')->end();
          
          /* ------- END - headers ------- */
          
          //Define plugins to be loaded.
          $plugins = array(
            load_plugin('jquery')
          );
          
          //If we're in editable mode, load editing plug-ins and scripts.
          if($this->helper('is_website_editable'))
          {
            
            //CKEditor, ELFinder and jQuery Postpone.
            $plugins = array_merge($plugins, array(
              load_plugin('ckeditor'),
              load_plugin('elfinder'),
              load_plugin('jquery_postpone'),
              load_plugin('jsFramework'),
              load_plugin('underscore')
            ));
            
            //Our own editable scrips.
            tx('Ob')->add('<script src="'.URL_COMPONENTS.'cms/includes/cms.js"></script>', 'script', 'cms_editable_cms');
            tx('Ob')->add('<script src="'.URL_COMPONENTS.'cms/includes/jslite.min.js"></script>', 'script', 'cms_editable_jslite');
            tx('Ob')->add('<script src="'.URL_COMPONENTS.'cms/includes/ejs.js"></script>', 'script', 'cms_editable_ejs');
            tx('Ob')->add('<script src="'.URL_COMPONENTS.'cms/includes/editable.js"></script>', 'script', 'cms_editable_editable');
            
          }
          
          $output = $that->template($pi->template, $pi->theme, array(
            'title' => $title,
            'plugins' => $plugins
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
