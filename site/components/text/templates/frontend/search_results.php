<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<h1 style="display:block;"><?php __($names->component, 'Search results for'); ?>: <?php echo $search_results->term; ?></h1>

<?php
$search_results->results->each(function($row)use($search_results, $names){
  ?>

    <div class="search-result">

      <h2>
        <a href="<?php echo url('pid='.$row->page_id); ?>"><?php echo $row->title; ?></a>
      </h2>

      <p>
        <?php echo str_replace($search_results->term->get(), '<span class="highlighted">'.$search_results->term.'</span>', substr(strip_tags($row->text), 0, 200)); ?> ...
        <a href="<?php echo url('pid='.$row->page_id); ?>" title="<?php __($names->component, 'Read more'); ?>" class="read-more"><?php __($names->component, 'More'); ?> &raquo;</a>
      </p>

    </div>

  <?php
});

if($data->results->size() == 0)
{
  __($names->component, 'No search results');
}
