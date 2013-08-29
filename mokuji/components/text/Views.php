<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'text' => 0
    );
  
  protected function text($options)
  {
    
    $pid = $options->pid->is_set() ? $options->pid->value : tx('Data')->get->pid;
    
    return array(
      'pid' => $pid,
      'items' =>
        $this->table('Items')
        ->join('ItemInfo', $ii)
        ->select("$ii.title", 'title')
        ->select("$ii.description", 'description')
        ->select("$ii.text", 'text')
        ->where('page_id', "'{$pid}'")
        ->where('trashed', '!', 1)
        ->where("$ii.language_id", tx('Language')->get_language_id())
        ->order('order_nr', 'DESC')
        ->execute()
    );
  }
  
}
