<?php namespace components\menu; if(!defined('MK')) die('No direct access.'); ?>

<p>
  Do you want to link to an external web page, e.g. <a href="http://mokuji.net" target="_blank">http://mokuji.net</a>? Fill in the URL (and optional target) below.
</p>

<form id="external_url_form" method="post" action="<?php echo url('rest=menu/external_url', true); ?>" class="form-inline-elements">

  <input type="hidden" name="menu_item_id" value="${data.menu_item_id}" />

  <div class="ctrlHolder">
    <p><label><?php __($component, 'URL'); ?></label></p>
    <input type="text" name="link_url" value="${data.link_url}" placeholder="http://example.com" />
  </div>

  <div class="ctrlHolder">
    <p><label><?php __($component, 'Link target'); ?></label></p>
    <input type="text" name="link_target" value="${data.link_target}" placeholder="_self" />
  </div>

</form>
