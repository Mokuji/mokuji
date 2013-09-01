<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<form id="menu_linker" method="post" action="<?php echo url('action=cms/save_menu_link/post', true); ?>" class="form-inline-elements">
  <div class="ctrlHolder">
    <p><label><?php __($component, 'Target menu item'); ?></label></p>
    <select name="menu_item_id">
      <option value="">-- <?php __('Please select an option'); ?> --</option>
      {{each(key, value) data.items}}
        <option value="${key}"{{if data.menu_item_id == key}} selected="selected"{{/if}}>${value}</option>
      {{/each}}
    </select>
  </div>
  <div class="ctrlHolder">
    <fieldset class="fieldset-action">
      <legend><?php __($component, 'Link action'); ?></legend>
      <ul>
        <li><label><input type="radio"{{if data.link_action == 0}} checked="checked"{{/if}} value="0" name="link_action"> <?php __($component, 'Redirect'); ?></label></li>
        <li><label><input type="radio"{{if data.link_action == 1}} checked="checked"{{/if}} value="1" name="link_action"> <?php __($component, 'Copy content'); ?></label></li>
      </ul>
    </fieldset>
  </div>
</form>
