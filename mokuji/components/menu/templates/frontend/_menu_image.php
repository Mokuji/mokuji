<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<?php if($data->image_id->get() > 0){ ?>
  <img src="<?php echo $data->image->generate_url($options); ?>" />
<?php } ?>
