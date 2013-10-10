<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<script type="text/javascript">
  var installSteps = JSON.parse('<?php echo $data->install_steps->as_json(); ?>');
</script>

<div id="page-main">
  
  <div id="page-main-left">
    <h3 class="install-steps-header">Installation steps</h3>
    <ol id="install-steps">
      <?php $data->install_steps->each(function($step){ ?>
        <li class="step" data-step="<?php echo $step->key(); ?>"><?php echo $step->title; ?></li>
      <?php }); ?>
    </ol>
  </div>
  
  <div id="page-main-right">
    <div id="app"></div>
  </div>
  
</div>

<div id="page-topbar">
  <h1 id="logo"><a href="<?php echo url('/install/', true); ?>">Mokuji <i class="icon-circle-arrow-up"></i></a></h1>
  <div class="clear"></div>
</div>
