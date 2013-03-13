<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<form method="{{if id}}PUT{{else}}POST{{/if}}" action="?rest=timeline/entry/${id}" id="timeline-entry-form" class="form">
  
  <input type="hidden" name="type" value="blogpost" />
  
  {{each(language_id, language) languages}}
    
    <div class="multilingual-section entry ${type}-entry" data-language-id="${language.id}">
      
      <?php
        //Shorten the "Title in " translations.
        $title_in = __($component, 'Title', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $title_in; ?>${language.title}</label>
        <input type="text" class="title" name="info[${language.id}][title]"
          placeholder="<?php echo $title_in; ?>${language.title}" value="${info && info[language.id] ? info[language.id]['title'] : ''}" />
      </div>
      
      <?php
        //Shorten the "Summary in " translations.
        $summary_in = __($component, 'Summary', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $summary_in; ?>${language.title}</label>
        <textarea id="editor_summary_" name="info[${language.id}][summary]" class="summary editor">${info && info[language.id] ? info[language.id]['summary'] : ''}</textarea>
      </div>
      
      <?php
        //Shorten the "Content in " translations.
        $content_in = __($component, 'Content', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      <div class="ctrlHolder">
        <label><?php echo $content_in; ?>${language.title}</label>
        <textarea id="editor_content_" name="info[${language.id}][content]" class="content editor">${info && info[language.id] ? info[language.id]['content'] : ''}</textarea>
      </div>
      
    </div>
    
  {{/each}}
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Publish date and time') ?></label>
    <input type="text" class="date-time-input" name="dt_publish" placeholder="yyyy-mm-dd hh:mm:ss" value="${dt_publish}" />
  </div>
  
  <div class="ctrlHolder">
    <label><?php __($component, 'Author') ?></label>
    <select name="author_id">
      <option value="">-- <?php __($component, 'No author') ?> --</option>
      {{each(i, author) authors}}
        <option value="${author.user_id}"{{if author_id == author.user_id}} selected="selected"{{/if}}>
          ${author.full_name}
        </option>
      {{/each}}
    </select>
  </div>
  
  <!-- TODO: thumbnail image uploader -->
  
  <div class="buttonHolder">
    <input type="button" class="button grey cancel" value="<?php __('Back') ?>" />
    <input type="submit" class="button black post" value="{{if id}}<?php __($component, 'Update entry') ?>{{else}}<?php __($component, 'Post entry') ?>{{/if}}" />
  </div>
  
</form>
