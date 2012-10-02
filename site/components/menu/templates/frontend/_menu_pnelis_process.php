<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<section class="clearfix process-images">

<?php
$data->each(function($item){
  ?>

  <div class="box<?php if(tx('Data')->get->pid->get() == $item->page_id->get()) echo ' active'; ?>" box-type="image" box-arrow="top">
    <a href="<?php echo url('menu='.$item->id.'&pid='.$item->page_id); ?>">
      <header><h4><?php echo $item->title; ?></h4></header>
      <img src="<?php echo url(URL_BASE.'?section=media/image&resize=250/0&id='.$item->image_id, true); ?>" />
    </a>
    <div class="active-overlay"></div>
  </div>

  <?php
});
?>

</section>