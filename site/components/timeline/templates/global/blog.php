<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

//Function to make the pagination.
$__pagination = function()use($data, $names){
  
  if($data->pages->get('int') <= 1)
    return;
  
  ?>
  <div class="pagination blog-pagination">
    
    <label class="pagination-label"><?php __($names->component, 'Pages') ?></label>
    
    <?php if($data->page->get('int')-1 > 0){ ?>
      <a href="<?php echo url('page='.($data->page->get('int')-1)); ?>"
        data-page="<?php echo $data->page->get('int')-1; ?>" class="page prev-page">
        <?php __($names->component, 'PREVIOUS_PAGE_NOTATION') ?>
      </a>
    <?php } ?>
    
    <?php for($i = 1; $i <= $data->pages->get('int'); $i++){ ?>
      <a href="<?php echo url('page='.$data->page->get('int')); ?>" data-page="<?php echo $i; ?>"
        class="page page-number<?php echo $data->page->get('int') === $i ? ' active' : ''; ?>"><?php echo $i; ?></a>
    <?php } ?>
    
    <?php if($data->page->get('int')+1 <= $data->pages->get('int')){ ?>
      <a href="<?php echo url('page='.($data->page->get('int')+1)); ?>"
        data-page="<?php echo $data->page->get('int')+1; ?>" class="page next-page">
        <?php __($names->component, 'NEXT_PAGE_NOTATION') ?>
      </a>
    <?php } ?>
    
  </div>
  <?php
  
};

//Insert pagination at top.
$__pagination();

echo '<div class="entries blog-entries'.( ! $data->page->is_set() ? ' single-post' : '').'">';

if($data->funny_man->is_set()){
  echo n.'<!-- '.__($names->component, 'FUNNY_MAN', true).' '.
    __($names->component, $data->funny_man->get(), 'lowercase', true).'. -->'.n;
}

$data->entries->each(function($entry){
  echo $entry->html->get();
});

echo '</div>';

//Insert pagination at bottom.
$__pagination();
