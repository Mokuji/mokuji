<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>

<!DOCTYPE HTML>

<html>

  <head>
  
    <title><?php echo $head->title; ?></title>
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />
    
    <meta type="keywords" content="<?php echo $head->meta->keywords; ?>" />
    
    <?php echo $head->theme; ?>
  
  </head>
  
  <body>
  
  <?php echo $body->content; ?>
  
  </body>

</html>