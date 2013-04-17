<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width">
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />
    
    <title><?php echo $head->title; ?></title>
    
    <meta name="revisit-after" content="5 days" />
    <?php
      echo $head->meta;
      echo $head->links;
      echo $head->plugins;
      echo $head->theme;
      echo $head->scripts;
    ?>
    
  </head>
  
  <body class="underduck-template">
    <header id="header">
      <img class="logo" src="http://placehold.it/135x35" />
      <nav class="main-menu">
        <?php echo tx('Component')->modules('menu')->get_html('menu', array('max_depth' => 1)); ?>
      </nav>
    </header>
    
    <div id="content-body">
      <?php echo $body->content; ?>
    </div>
    
    <?php echo $body->admin_toolbar; ?>
  </body>
</html>
