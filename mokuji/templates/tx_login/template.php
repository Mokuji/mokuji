<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>

  <head>
  
    <title><?php echo $head->title; ?></title>
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
  
  <body>
  
    <div id="error">
      <?php echo $messages->error; ?>
    </div>
    
    <div id="notification">
      <?php echo $messages->notification; ?>
    </div>
  
    <div class="tx-wrapper bg-img bg-<?php echo rand(1,6); ?>" role="main">

      <div class="tx-login-wrapper">
  
        <div class="tx-logo"></div>
      
        <?php echo $body->content; ?>

      </div>
      
      <div class="tx-bg-credits"></div>
      
    </div>
    <footer>

    </footer>

    <?php echo $body->admin_toolbar; ?>
  
  </body>

</html>
