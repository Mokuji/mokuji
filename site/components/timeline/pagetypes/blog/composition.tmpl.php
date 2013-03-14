<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<form method="PUT" action="?rest=timeline/page" id="timeline-composition-form" class="form">
  
  <input type="hidden" name="page_id" value="${data.page.page_id}" />
  
  <div class="ctrlHolder">
    
    <label><?php __($component, 'Timeline to use as the source of the entries') ?></label>
    <select name="timeline_id">
      <option value="NEW">-- <?php __('New timeline for this page') ?> --</option>
      {{each(i, timeline) data.timelines}}
        <option value="${timeline.id}"{{if data.page.timeline_id == timeline.id}} selected="selected"{{/if}}>
          ${timeline.title}
        </option>
      {{/each}}
    </select>
    
  </div>
  <div class="ctrlHolder">
    
    <label><?php __($component, 'Entry language') ?></label>
    <select name="force_language">
      <option value="">-- <?php __($component, 'Multilingual') ?> --</option>
      {{each(language_id, language) languages}}
        <option value="${language.id}"{{if data.page.force_language == language.id}} selected="selected"{{/if}}>${language.title}</option>
      {{/each}}
    </select>
    
  </div>
  <div class="ctrlHolder">
    
    <label><?php __($component, 'Display order of the entries') ?></label>
    <select name="is_chronologic">
      <option value="1"{{if data.page.is_chronologic}} selected="selected"{{/if}}><?php __($component, 'Old entries first') ?></option>
      <option value="0"{{if !data.page.is_chronologic}} selected="selected"{{/if}}><?php __($component, 'New entries first') ?></option>
    </select>
    
  </div>
  <div class="ctrlHolder">
    
    <label><?php __($component, 'Display type for the entries') ?></label>
    <select name="display_type_id">
      {{each(i, display) data.display_types}}
        <option value="${display.id}"{{if data.page.display_type_id == display.id}} selected="selected"{{/if}}>
          ${display.title}
        </option>
      {{/each}}
    </select>
    
  </div>
  <div class="ctrlHolder">
    
    <label>
      <input name="is_future_hidden" type="checkbox"{{if data.page.is_future_hidden}} checked="checked"{{/if}} value="1" />
      <?php __($component, 'Hide entries posted in the future') ?>
    </label>
    
  </div>
  
</form>
