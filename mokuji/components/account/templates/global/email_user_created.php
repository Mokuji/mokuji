<?php namespace components\account; if(!defined('TX')) die('No direct access.');

$options->password = '**hidden**'; //Password is a hidden string.
?>
<html>
  <head>
    <style type="text/css">
    </style>
  </head>
  <body>
    <h1>User <?php echo $options->username; ?> has been created.</h1>
    <p>Your user account <?php echo $options->username; ?> has been created at <a href="<?php echo URL_BASE; ?>"><?php echo URL_BASE; ?></a>.</p>
    <p>
      Provided here are your login details:
      <?php echo $options->having('username', 'email', 'password')->as_list(function($value, $key){ return __(ucfirst($key), 1).': '.$value; }); ?>
    </p>
  </body>
</html>