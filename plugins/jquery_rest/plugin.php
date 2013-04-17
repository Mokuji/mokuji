<?php namespace plugins; if(!defined('TX')) die('No direct access.');
tx('Ob')->script('Plugin::jquery_rest');
?>
    <script type="text/javascript" src="<?php echo $plugin ?>jQuery.formToObject.min.js"></script>
    <script type="text/javascript" src="<?php echo $plugin ?>jquery.rest.js"></script>
    <script type="text/javascript" src="<?php echo $plugin ?>jquery.restForm.js"></script>
<?php
tx('Ob')->end();