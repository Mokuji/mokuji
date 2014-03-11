<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<?php $text->items->each(function($item){ ?>
  
  <div class="text-item" data-model="text/text_info" data-data="id=<?php echo $item->info_id; ?>">
    
    <h1 data-field="title" data-type="text"><?php echo $item->title; ?></h1>
    <div data-field="text" data-type="text"><?php echo $item->text; ?></div>
    
  </div>
  
<?php }); ?>
