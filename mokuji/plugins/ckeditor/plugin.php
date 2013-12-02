<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>
    <script type="text/javascript" src="<?php echo $plugin ?>ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo $plugin ?>adapters/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $plugin ?>plugin.js"></script>
    <script type="text/javascript">
      <?php if(mk("Config")->user("tx_editor_toolbar")->is_set()){ ?>
        tx_editor.setDefaultToolbar(JSON.parse('<?php
          echo str_replace("'", "\'", str_replace(array("\r", "\n"), '', mk("Config")->user("tx_editor_toolbar")->get()));
        ?>'));
      <?php } ?>
    </script>