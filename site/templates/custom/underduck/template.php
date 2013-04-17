<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>
  
  <head>
    
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />
    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="revisit-after" content="5 days" />
    
    <title><?php echo $head->title; ?></title>
    <?php echo $head->meta; ?>
    
    <?php echo $head->links; ?>
    
    <?php echo $head->plugins; ?>
    
    <?php echo $head->theme; ?>
    
    <?php echo $head->scripts; ?>
    
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
