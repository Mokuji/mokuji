<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<?php $text->items->each(function($item){ ?>
  
  <div data-model="text/page_text">
  <h1 data-field="title" data-type="line"><?php echo $item->title; ?></h1>
  <!--<p><?php echo $item->dt_created; ?></p>-->
  <div data-field="text" data-type="text"><?php echo $item->text; ?></div>
  </div>
  
<?php }); ?>
