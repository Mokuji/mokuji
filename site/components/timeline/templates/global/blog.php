<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

$data->entries->each(function($entry){
  echo $entry->html->get();
});
