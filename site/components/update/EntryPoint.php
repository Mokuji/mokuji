<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class EntryPoint extends \dependencies\BaseEntryPoint
{
  
  public function entrance()
  {

    //We have to be installing.
    if(INSTALLING !== true){
      throw new \exception\Authorisation('The CMS has already been installed.');
    }
    
    //Return the view.
    return $this->template('cms_backend', 'cms_backend',
      array(
        'plugins' =>  array(
          load_plugin('jquery'),
          load_plugin('jquery_ui'),
          load_plugin('jquery_rest')
        ),
        'links' => array(
          'cms_style' => '<link rel="stylesheet" type="text/css" href="'.URL_COMPONENTS.'cms/includes/style.css" />',
          'install_style' => '<link rel="stylesheet" type="text/css" href="'.URL_COMPONENTS.'update/includes/install.css" />'
        ),
        'scripts' => array(
          'install' => '<script type="text/javascript" src="'.URL_COMPONENTS.'update/includes/install.js"></script>'
        )
      ),
      array(
        'content' => $this->view('install')
      )
    );

  }

}
