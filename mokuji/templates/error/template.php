<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>

<!DOCTYPE HTML>

<html>

  <head>
  
    <title><?php echo $head->title; ?></title>
    
    <meta type="robots" content="<?php echo $head->meta->robots; ?>" />
    <?php echo $head->theme; ?>
    
  </head>
  
  <body>
  
    <!-- HEADER -->
    <hgroup id="header">
      <h1><?php echo get_class($exception); ?></h1>
      <h3><?php echo $body->message; ?></h3>
      <h5>Thrown in <code><?php echo $exception->getFile(); ?></code> on line <code><?php echo $exception->getLine(); ?></code>.</h5>
    </hgroup>
    <!-- /HEADER -->
    
    <!-- CONTENT -->
    <div id="content">
      
      <h4>Callstack:</h4>
      <?php callstack(true, $exception->getTrace()); ?>
      
      <h4>Report:</h4>
      <div class="trace">
        <?php trace($exception); ?>
      </div>
      
    </div>
    <!-- /CONTENT -->
  
  </body>

</html>