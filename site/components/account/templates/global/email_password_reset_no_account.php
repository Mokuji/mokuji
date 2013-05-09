<?php namespace components\account; if(!defined('TX')) die('No direct access.'); ?>
<html>
  <head>
    <style type="text/css">
    </style>
  </head>
  <body>
    <h1>Password reset requested for <?php echo $options->email; ?>.</h1>
    <p>
      You (or someone else) requested a password reset for the account associated with <?php echo $options->email; ?> on
      <a target="_blank" href="<?php echo $options->site_url; ?>"><?php echo htmlentities($options->site_name->get()); ?></a>.
      However no account has been created with this e-mail address.
    </p>
    <p>If you tried to reset your password please make sure to enter the e-mail address that corresponds to your account.</p>
    <p class="details">
      Request made from IP address:
      <a target="_blank" href="http://ip-lookup.net/index.php?ip=<?php echo urlencode($options->ipa->get()); ?>"><?php echo $options->ipa->get(); ?></a><br>
      With user agent: <?php echo htmlentities($options->user_agent->get()); ?>
    </p>
  </body>
</html>