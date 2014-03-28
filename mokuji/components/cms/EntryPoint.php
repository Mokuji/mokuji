<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

use \components\cms\routing\UrlFormatFactory;

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
      if(!tx('Account')->isLoggedIn())
      {
        
        //Use the previous scheme unless the on-login option is desired.
        $targetScheme = tx('Url')->url->segments->scheme->get();
        if(tx('Config')->user('tls_mode')->get('string') === 'logged-in')
          $targetScheme = 'https';
        
        //Redirect to custom login page is available.
        if(url('')->segments->path == '/admin/' && tx('Config')->user()->login_page->not('empty')->get('bool')){
          $goto = url(URL_BASE.tx('Config')->user()->login_page, true)->segments->merge(array('scheme' => $targetScheme))->back()->rebuild_output();
          header("Location: ".$goto);
          exit;
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
          load_plugin('jquery_password_strength'),
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
      $url = $this->findPageUrl();
      
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
      tx('Validating input.', function()use($that, $url){
        
        //Address page ID.
        $pageId = Data($url->getPageId())
          
          //Validate it.
          ->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
        
        //Get the record for this page from the database.
        $page = tx('Sql')
          ->table('cms', 'Pages')
          ->pk($pageId)
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
        
        //All is valid, store the URL information.
        mk('Config')->system('cms_url', $url);
        
      })
      
      //If any of the above validations failed..
      ->failure(function(){
        
        //Try and redirect to the homepage.
        try{
          
          $homepage = UrlFormatFactory::format('/');
          $isPresent = mk('Sql')->table('cms', 'Pages')
            ->pk($homepage->getPageId())
            ->execute_single()
            ->is_set();
          
          if($isPresent){
            header('Location: '.$homepage);
            exit;
          }
          
          else
            mk('Url')->redirect('/admin/');
          
        }
        
        //The homepage could not be parsed.
        catch(\exception\Exception $ex){
          mk('Url')->redirect('/admin/');
        }

      })
      
      //In case all validations succeeded, we can load the requested page.
      ->success(function()use($that, $url, &$output){
        
        //load a layout-part
        if(tx('Data')->get->part->is_set()){
          $output = $that->section('page_part');
        }
        
        //or are we going to load an entire page?
        elseif($url->getPageId()){
          
          $pi = $that->helper('get_page_info', $url->getPageId());
          $mid = tx('Data')->get->menu->get();
          $languageId = $url->getLanguageId() ? $url->getLanguageId() : mk('Language')->id;
          $lpi = $pi->info->{$languageId};
          
          $pretty_url = $url->output(mk('Data')->get);
          
          //If forced theme is set: re-set theme id.
          if(tx('Config')->user('forced_theme_id')->get() > 0){
            $pi->theme->set($that->table('Themes')->pk(tx('Config')->user('forced_theme_id'))->execute_single()->name);
          }
          
          //If forced template is set: re-set template id.
          if(tx('Config')->user('forced_template_id')->get() > 0){
            $pi->template->set($that->table('Templates')->pk(tx('Config')->user('forced_template_id'))->execute_single()->name);
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
          if(tx('Component')->helpers('cms')->is_website_editable())
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
  
  protected function findPageUrl()
  {
    
    //First get a basic URL without query string.
    $request_uri = mk('Data')->server->REQUEST_URI->get('string');
    
    //Strip the URL_PATH.
    if(URL_PATH)
      $request_uri = str_replace('/'.URL_PATH, '', $request_uri);
    
    try{
      
      //Detect the URL format.
      $url = UrlFormatFactory::format($request_uri, $cast, $homepage);
      
      #TODO: Get rid of this by improving the core URL classes.
      //Implement a little hack, until the core classes are better.
      $QS = mk('Url')->url->data->merge(array(
        'pid' => $url->getPageId()
      ))->as_array();
      mk('Url')->url->segments->query->set(http_build_query($QS, null, '&'));
      mk('Url')->url->rebuild_output();
      
      //To check for legacy / ID based pages.
      $url->getUrlKey();
      
    }
    
    catch(\exception\NotFound $nfex){
      
      //Improve 404 message.
      set_status_header(404);
      throw new \exception\NotFound(transf('cms', 'The page you\'re looking for could not be found.'));
      
    }
    
    
    //Change language?
    if($url->getLanguageId()){
      mk('Data')->session->tx->language->set($url->getLanguageId());
    }
    
    //If we should redirect, do that now.
    if($cast && !$homepage)
    {
      
      //By the way, if a ?menu=1 optimization is in order, do that now as well.
      if(mk('Data')->get->menu->is_set())
      {
        
        $menu = mk('Component')->helpers('menu')->call('get_active_menu_item');
        
        if($menu->is_unique_link()){
          mk('Data')->get->menu->un_set();
        }
        
      }
      
      header('Location: '.$url->output(mk('Data')->get));
      exit;
      
    }
    
    //If not, we might want to adjust our language right away.
    elseif($url->getLanguageId())
      mk('Language')->set_language_id($url->getLanguageId());
    
    return $url;
    
  }

}
