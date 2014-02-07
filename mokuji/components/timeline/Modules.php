<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');


class Modules extends \dependencies\BaseViews
{
  
  protected
    $permissions = array(
      'blog' => 0
    );

  /**
   * Show blogposts.
   * 
   * #TODO description
   * 
   * @param array $options An array with options
   *    @param int    $pid       The page ID of the timeline page we want to load items from.
   *    @param int    $menu_id   (optional) Menu ID to use in the URLs.
   *    @param string $dt_format (optional) Date/Time format.
   *
   * @return object The requested timeline entries.
   */
  protected function blog($options)
  {
    
    //Check for the page ID.
    $options
      ->pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    #TODO: check page permissions
    
    //Get the page to base the entries on.
    $page = tx('Sql')
      ->table('timeline', 'Pages')
      ->pk($options->pid->get('int'))
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\NotFound('No configuration found for this blog page.');
      })
      
      //Store the requested language.
      ->is('set', function($page){
        $page->merge(array(
          'language' => $page->force_language->otherwise(tx('language')->id)
        ));
      });
    
    //Return the entries.
    return tx('Component')
      ->helpers('timeline')
      ->_call('get_entries', array($page->merge($options->filters->otherwise(array())->as_array())))
      
      //Template each entry.
      ->entries
        ->each(function($entry)use($page, $options){
          $entry->format_dt_publish($options->dt_format);
          $entry->html->set(tx('Component')
            ->sections($page->display_type->component_name)
            ->get_html($page->display_type->section_name, $entry->merge(array(
              'pid' => $page->page_id,
              'menu' => $options->menu->otherwise('NULL'),
              'dt_format' => $options->filters->dt_format,
              'language' => $page->language,
              'is_summary' => true
            )))
          );
        })
      ->back();
    
  }
  
}
