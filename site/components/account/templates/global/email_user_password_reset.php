<?php namespace components\account; if(!defined('TX')) die('No direct access.'); ?>
<html>
  <head>
    <style type="text/css">
    </style>
  </head>
  <body>

  <h1>Your password has been reset.</h1>
    <p>
      Your password has been reset for <a href="<?php echo $data->for_link; ?>"><?php echo $data->for_link; ?></a>.<br />
      Click the claim link below to claim your account. Or click the unsubscribe link if this message was not meant for you or you would like to no longer recieve e-mail from us.
    </p>
    <p>
      <b>Claim account: </b><br />
      <a href="<?php echo $data->claim_link; ?>"><?php echo $data->claim_link; ?></a>
    </p>
    <p>
      <b>Unsubscribe: </b><br />
      <a href="<?php echo $data->unsubscribe_link; ?>"><?php echo $data->unsubscribe_link; ?></a>
    </p>

  </body>
</html>
