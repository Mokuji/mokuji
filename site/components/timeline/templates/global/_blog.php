<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

echo '<div class="entries blog-entries">';

if($data->funny_man->is_set()){
  echo n.'<!-- '.__($names->component, 'FUNNY_MAN', true).' '.
    __($names->component, $data->funny_man->get(), 'lowercase', true).'. -->'.n;
}

$data->entries->each(function($entry){
  echo $entry->html->get();
});

echo '</div>';