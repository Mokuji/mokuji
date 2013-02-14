<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>

  <head>
  
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="revisit-after" content="15 days" />

    <?php echo $head->meta; ?>
    
    <?php echo $head->links; ?>
    
    <?php echo $head->plugins; ?>

    <?php echo $head->theme; ?>

    <?php echo $head->scripts; ?>
  
  </head>
  
  <body>

    <?php echo $body->content; ?>
    <?php echo $body->admin_toolbar; ?>
  
  </body>

</html>
