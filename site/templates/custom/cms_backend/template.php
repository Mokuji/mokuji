<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
  <head>

    <title>tuxion.cms <?php echo $head->title; ?></title>
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />

    <!-- character encoding -->
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <!-- seo -->
    <meta name="description" content="Tuxion CMS" />
    <meta name="author" content="Tuxion" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="revisit-after" content="15 days" />
    <?php echo $head->meta; ?>
    
    <?php echo $head->theme; ?>

    <?php echo $head->links; ?>

    <?php echo $head->plugins; ?>
    
    <?php echo $head->scripts; ?>

  </head>
  <body id="tx-backend">

  <!-- PAGE -->
  <div id="page">

    <?php echo $body->content; ?>
    
  </div>
  <!-- /PAGE -->

  </body>
</html>
