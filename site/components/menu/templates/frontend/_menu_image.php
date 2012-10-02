<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<?php if($data->image_id->get() > 0){ ?>
  <img src="<?php echo url(URL_BASE.'?section=media/image&resize='.$options->resize.'&id='.$data->image_id, true); ?>" />
<?php } ?>
