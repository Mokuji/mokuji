<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<?php

$text->items->each(function($item){
  ?>

  <h1 contenteditable="true"><?php echo $item->title; ?></h1>
  <!--<p><?php echo $item->dt_created; ?></p>-->
  <div contenteditable="true">
    <?php echo $item->text; ?>
  </div>

  <?php
});
?>