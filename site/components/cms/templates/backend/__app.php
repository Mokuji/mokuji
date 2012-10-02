<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<div id="app">

  <div id="menu_app">
  <?php echo $app->menu ?>
  </div>

  <div id="page_app">
  <?php echo $app->page ?>
  </div>

</div>
