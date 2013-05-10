<?php namespace components\security; if(!defined('TX')) die('No direct access.');
$id = 'captcha_'.tx('Security')->random_string();
?>

<div class="native-captcha">
  
  <div class="captcha-block">
    <img src="<?php echo $data->url; ?>" id="<?php echo $id; ?>" class="captcha" alt="<?php __($names->component, 'CAPTCHA Image'); ?>" />
  </div>
  
  <div class="input-block">
    <input type="text" name="<?php echo $data->name; ?>" placeholder="<?php __($names->component, 'Security code'); ?>" />
  </div>
  
  <script type="text/javascript">
  var Securimage = {
    reload: function(){
      var image = document.getElementById('<?php echo $id; ?>');
      image.src = '<?php echo $data->url; ?>?rand=' + encodeURIComponent(Math.random());
    }
  };
  </script>
  
</div>