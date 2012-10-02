<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

//reference user object for easy access
$user =& tx('Data')->session->user;

//validate login
if(!$user->check('login')){

?>

<form method="post" action="<?php echo url('action=cms/login/post'); ?>">
  
  <input type="text" name="email" placeholder="<?php __('email address') ?>" value="<?php echo tx('Data')->postdata()->email->otherwise(tx('Data')->get->email); ?>" />
  <input type="password" name="pass" placeholder="<?php __('password') ?>" value="" />
  <input type="submit" name="login" value="<?php __('login') ?>" />
  
</form>

<?php } ?>