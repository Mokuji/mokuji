<?php namespace components\text; if(!defined('TX')) die('No direct access.'); 

$latest_news->each(function($item){
  ?>
  <section class="intro clearfix">
    <h1><a href="<?php echo url('menu=162&pid='.$item->page_id); ?>"><?php echo $item->title; ?></a></h1>
    <span class="date clearfix"><?php echo date("d-m-y", strtotime($item->dt_created)); ?></span>
    <p>
      <?php echo substr(strip_tags($item->text), 0, 80).'...'; ?>
      <a href="<?php echo url('menu=162&pid='.$item->page_id); ?>" title="<?php __($names->component, 'Read more'); ?>" class="read-more"><?php __($names->component, 'More'); ?> &gt;</a>
    </p>
  </section>
  <?php
});

?>
