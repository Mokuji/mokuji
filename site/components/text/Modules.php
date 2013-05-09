<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'text' => 0
    );
  
  protected function text($options)
  {
    
    #TODO: Needs page permission checks.
    
    return array(
      'info' => $this
        ->table('Items')
        ->join('ItemInfo', $ii)
        ->select("$ii.title", 'title')
        ->select("$ii.description", 'description')
        ->select("$ii.text", 'text')
        ->where('page_id', "'{$options->pid}'")
        ->order('order_nr', 'ASC')
        ->execute_single()
    );
    
  }

}