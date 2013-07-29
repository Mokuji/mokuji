<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>
    <script type="text/javascript" src="<?php echo $plugin; ?>jQuery.PasswordStrength.js"></script>
    <?php if(file_exists(PATH_PLUGINS.DS.'jquery_password_strength'.DS.'i18n'.DS.mk('Language')->code.'.js')){ ?>
      <script type="text/javascript" src="<?php echo $plugin; ?>i18n/<?php echo mk('Language')->code; ?>.js"></script>
    <?php } ?>