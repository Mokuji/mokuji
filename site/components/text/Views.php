<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{

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
        ->where("$ii.language_id", LANGUAGE)
        ->order('order_nr', 'DESC')
        ->execute()
    );
  }
  
  protected function search_results($options)
  {
    
    return array(
      'term' => tx('Data')->post->term,
      'results' =>
        $this->table('Items')
        ->join('ItemInfo', $ii)
        ->select("$ii.title", 'title')
        ->select("$ii.description", 'description')
        ->select("$ii.text", 'text')
        ->where("$ii.language_id", LANGUAGE)
        ->where(tx('Sql')->conditions()
          ->add('1', array("$ii.title", '|', "'%".addslashes(tx('Data')->post->term)."%'"))
          ->add('2', array("$ii.description", '|', "'%".addslashes(tx('Data')->post->term)."%'"))
          ->add('3', array("$ii.text", '|', "'%".addslashes(tx('Data')->post->term)."%'"))
          ->combine('4', array('1', '2', '3'), 'OR')
          ->utilize('4'))
        ->execute()
    );
  }

}
