<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<form method="{{if data.id}}PUT{{else}}POST{{/if}}" action="?rest=timeline/entry/${data.id}" id="timeline-entry-form" class="form">
  
  <input type="hidden" name="type" value="blogpost" />
  <input type="hidden" name="force_language" value="${force_language ? force_language : ''}" />
  <input type="hidden" name="page_id" value="${page_id}" />
  
  {{each(language_id, language) languages}}
    
    <div class="multilingual-section" data-language-id="${language.id}">
      
      <?php
        //Shorten the "Title in " translations.
        $title_in = __($component, 'Title', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $title_in; ?>${language.title}</label>
        <input type="text" class="title" name="info[${language.id}][title]"
          placeholder="<?php echo $title_in; ?>${language.title}" value="${data.info && data.info[language.id] ? data.info[language.id]['title'] : ''}" />
      </div>
      
      <?php
        //Shorten the "Summary in " translations.
        $summary_in = __($component, 'Summary', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $summary_in; ?>${language.title}</label>
        <textarea id="editor_summary_" name="info[${language.id}][summary]" class="summary editor">${data.info && data.info[language.id] ? data.info[language.id]['summary'] : ''}</textarea>
      </div>
      
      <?php
        //Shorten the "Content in " translations.
        $content_in = __($component, 'Content', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $content_in; ?>${language.title}</label>
        <textarea id="editor_content_" name="info[${language.id}][content]" class="content editor">${data.info && data.info[language.id] ? data.info[language.id]['content'] : ''}</textarea>
      </div>
      
    </div>
    
  {{/each}}
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Publish date and time') ?></label>
    <input type="text" class="date-time-input" name="dt_publish" placeholder="yyyy-mm-dd hh:mm:ss" value="${data.dt_publish}" />
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
  
  <!-- TODO: thumbnail image uploader -->
  
  <div class="buttonHolder">
    <input type="button" class="button grey cancel" value="<?php __('Back') ?>" />
    <input type="submit" class="button black post" value="{{if data.id}}<?php __($component, 'Update entry') ?>{{else}}<?php __($component, 'Post entry') ?>{{/if}}" />
  </div>
  
</form>
