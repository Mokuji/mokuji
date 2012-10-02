<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<h1 style="display:block;"><?php __('SEARCH_RESULTS_FOR'); ?>: <?php echo $search_results->term; ?></h1>

<?php

$search_results->results->each(function($row)use($search_results){

  echo

    '<div class="search-result">'.

      '<h2>'.
        '<a href="'.url('pid='.$row->page_id).'">'.$row->title.'</a>'.
      '</h2>'.  

      '<p>'.
        str_replace($search_results->term->get(), '<span class="highlighted">'.$search_results->term.'</span>', substr(strip_tags($row->text), 0, 200)).' ...'.
        ' <a href="'.url('pid='.$row->page_id).'" title="Lees meer" class="read-more">Meer &gt;</a>'.
      '</p>'.

    '</div>';

});

if($data->results->size() == 0)
{
  echo __('PNELIS__NO_SEARCH_RESULTS');
}