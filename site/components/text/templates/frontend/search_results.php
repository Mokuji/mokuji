<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<h1 style="display:block;"><?php __($names->component, 'Search results for'); ?>: <?php echo $search_results->term; ?></h1>

<?php

$search_results->results->each(function($row)use($search_results){

  echo

    '<div class="search-result">'.

      '<h2>'.
        '<a href="'.url('pid='.$row->page_id).'">'.$row->title.'</a>'.
      '</h2>'.  

      '<p>'.
        str_replace($search_results->term->get(), '<span class="highlighted">'.$search_results->term.'</span>', substr(strip_tags($row->text), 0, 200)).' ...'.
        ' <a href="'.url('pid='.$row->page_id).'" title="<?php __($names->component, 'Read more'); ?>" class="read-more"><?php __($names->component, 'More'); ?> &gt;</a>'.
      '</p>'.

    '</div>';

});

if($data->results->size() == 0)
{
  __($names->component, 'No search results');
}
