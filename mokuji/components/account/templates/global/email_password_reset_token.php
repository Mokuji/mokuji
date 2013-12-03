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
    </p>
    <p>
      To proceed with entering a new password, <a target="_blank" href="<?php echo $options->target_url; ?>">click here</a>.
      Please keep in mind this token is valid for up to one hour.
    </p>
    <p>If you did not request the password reset, you can ignore this e-mail.</p>
    <p class="details">
      Request made from IP address:
      <a target="_blank" href="http://ip-lookup.net/index.php?ip=<?php echo urlencode($options->ipa->get()); ?>"><?php echo $options->ipa->get(); ?></a><br>
      With user agent: <?php echo htmlentities($options->user_agent->get()); ?>
    </p>
  </body>
</html>