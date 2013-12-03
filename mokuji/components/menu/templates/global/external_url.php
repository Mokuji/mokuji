<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

Go to

  <a href="<?php echo $data->link_url; ?>"
    <?php if($data->link_target->not('empty')): ?> target="<?php echo $data->link_target; ?>"<?php endif; ?>>
    <?php echo $data->link_url; ?>
  </a>
