<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<form method="{{if data.id}}PUT{{else}}POST{{/if}}" action="?rest=timeline/entry/${data.id}" id="timeline-entry-form" class="form">
  
  <input type="hidden" name="type" value="blogpost" />
  <input type="hidden" name="force_language" value="${force_language ? force_language : ''}" />
  <input type="hidden" name="page_id" value="${page_id}" />
  
  {{each(language_id, language) languages}}
    
    <div class="multilingual-section" data-language-id="${language.id}">
      
      <div class="ctrlHolder">
        <label><?php __($component, 'Title'); ?>{{if languages.length > 1}} <?php __('IN_LANGUAGE_NAME', true, 'lowercase'); ?> ${language.title}{{/if}}</label>
        <input type="text" class="title big" name="info[${language.id}][title]"
          placeholder="<?php __($component, 'Title', 1); ?>{{if languages.length > 1}} <?php __('IN_LANGUAGE_NAME', true, 'lowercase'); ?> ${language.title}{{/if}}" value="${data.info && data.info[language.id] ? data.info[language.id]['title'] : ''}" />
      </div>
      
      <div class="ctrlHolder">
        <label><?php __($component, 'Summary'); ?>{{if languages.length > 1}} <?php __('IN_LANGUAGE_NAME', true, 'lowercase'); ?> ${language.title}{{/if}}</label>
        <textarea id="editor_summary_" name="info[${language.id}][summary]" class="summary editor">${data.info && data.info[language.id] ? data.info[language.id]['summary'] : ''}</textarea>
      </div>
      
      <div class="ctrlHolder">
        <label><?php __($component, 'Content'); ?>{{if languages.length > 1}} <?php __('IN_LANGUAGE_NAME', true, 'lowercase'); ?> ${language.title}{{/if}}</label>
        <textarea id="editor_content_" name="info[${language.id}][content]" class="content editor">${data.info && data.info[language.id] ? data.info[language.id]['content'] : ''}</textarea>
      </div>
      
    </div>
    
  {{/each}}
  
  <?php if(tx('Component')->available('media')){ ?>
    <fieldset>
      
      <div class="ctrlHolder">
        <label><?php __('Image'); ?></label><br />
        <img class="entry_image" {{if data && data.thumbnail_image_id > 0}}src="${data.thumbnail_image.url}"{{else}}style="display:none;"{{/if}} />
      </div>
      
      <div class="ctrlHolder">
        <input type="button" class="button grey delete-entry-image" value="<?php __('timeline', 'Delete image') ?>" {{if !data.thumbnail_image_id || data.thumbnail_image_id <= 0}}style="display:none;"{{/if}} />
      </div>
      
      <div class="ctrlHolder image_upload_holder">
        <input type="hidden" id="l_entry_thumbnail_image_id" name="thumbnail_image_id" value="${data.thumbnail_image_id}" />
      </div>
      
    </fieldset>
  <?php } ?>
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Starting date and time') ?></label>
    <input type="text" class="date-time-input" name="dt_start" placeholder="yyyy-mm-dd hh:mm:ss" value="{{if data.dt_start}}${data.dt_start}{{else}}<?php echo date("Y-m-d H:i"); ?>{{/if}}" />
  </div>
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Ending date and time') ?></label>
    <input type="text" class="date-time-input" name="dt_end" placeholder="yyyy-mm-dd hh:mm:ss" value="{{if data.dt_end}}${data.dt_end}{{else}}<?php echo date("Y-m-d H:i"); ?>{{/if}}" />
  </div>
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Author') ?></label>
    <select name="author_id">
      <option value="">-- <?php __($component, 'No author') ?> --</option>
      {{each(i, author) data.authors}}
        <option value="${author.user_id}"{{if data.author_id == author.user_id}} selected="selected"{{/if}}>
          ${author.full_name}
        </option>
      {{/each}}
    </select>
  </div>
  
  <fieldset class="fieldset-timelines">
    
    {{if force_timeline}}
      <legend><?php __($component, 'Other timelines to publish this entry in'); ?></legend>
      <input type="hidden" name="timelines[${force_timeline}]" value="1" />
    {{else}}
      <legend><?php __($component, 'Timelines to publish this entry in'); ?></legend>
    {{/if}}
    
    <ul>
      {{each(tid, timeline) timelines}}
        {{if force_timeline !== timeline.id}}
          <li>
            <label>
              <input type="checkbox" name="timelines[${timeline.id}]" value="1"{{if data.timelines && data.timelines[timeline.id]}} checked="checked"{{/if}} />
              ${timeline.title}
            </label>
          </li>
        {{/if}}
      {{/each}}
    </ul>
    
  </fieldset>
  
  <div class="buttonHolder">
    <input type="button" class="button grey cancel" value="<?php __('Back') ?>" />
    <input type="submit" class="button black post" value="{{if data.id}}<?php __($component, 'Update entry') ?>{{else}}<?php __($component, 'Post entry') ?>{{/if}}" />
  </div>
  
</form>
