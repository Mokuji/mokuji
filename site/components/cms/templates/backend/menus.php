<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<div class="content">    
  <?php echo $menus->items; ?>
</div>


<div id="widget_bar">
  <div class="inner">
    <?php echo $menus->configbar; ?>
    <div id="widget-slider" class="widget-slider"></div>
  </div>
</div>
