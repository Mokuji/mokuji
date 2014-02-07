<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'feed' => 0,
      'blogposts_entry' => 0
    );
  
  protected function blogposts_entry($options)
  {
    
    return $options;
    
  }

  protected function feed($options)
  {

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

    load_plugin('atom_php');

    //Create Atom object.
    $atom = new \plugins\Atom (tx('Config')->user('site_name'), URL_BASE, 'yesterday');

    //Define feed elements.
    $atom->feed(array(
      'author' => array('name' => tx('Config')->user('site_name')),
      'link'   => array(
        'rel'=>'self',
        'type'=>'application/atom+xml', 
        'href'=>URL_BASE.'atom.xml'
      ) 
    ));

    //Get items.
    tx('Component')
      ->helpers('timeline')
      ->_call('get_entries', array())

      //Loop items.
      ->entries
        ->each(function($entry)use(&$atom){

          //Define item elements.
          $atom->entry(
            ($entry->info->{tx('Language')->id}->title ? $entry->info->{tx('Language')->id}->title : 'Untitled'), 
            URL_BASE,
            $entry->dt_created,
            array(
              'link' => array(
                'rel'  => 'alternate',
                'href' => URL_BASE.'?post='.$entry->id
              ),
              'content' => array(
                'type'  => 'html', 
                'value' => htmlspecialchars($entry->info->{tx('Language')->id}->content)
              ),
              'summary' => strip_tags($entry->info->{tx('Language')->id}->summary)
            )
          );

        });

    //Display feed.
    $atom->display();

  }
  
}
