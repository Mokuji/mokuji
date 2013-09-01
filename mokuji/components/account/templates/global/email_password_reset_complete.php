<?php namespace components\account; if(!defined('TX')) die('No direct access.'); ?>
<html>
  <head>
    <style type="text/css">
    </style>
  </head>
  <body>
    <h1>Password reset completed for <?php echo $options->email; ?>.</h1>
    <p>
      You (or someone else) completed a password reset for the account associated with <?php echo $options->email; ?> on
      <a target="_blank" href="<?php echo $options->site_url; ?>"><?php echo htmlentities($options->site_name->get()); ?></a>.
    </p>
    <p>You can log in with your new password from now on.</p>
    <p>If you did not request the password reset, please contact <a href="mailto:<?php echo EMAIL_ADDRESS_WEBMASTER; ?>"><?php echo EMAIL_NAME_WEBMASTER; ?></a>.</p>
    <p class="details">
      Request completed from IP address:
      <a target="_blank" href="http://ip-lookup.net/index.php?ip=<?php echo urlencode($options->ipa->get()); ?>"><?php echo $options->ipa->get(); ?></a><br>
      With user agent: <?php echo htmlentities($options->user_agent->get()); ?>
    </p>
  </body>
</html>