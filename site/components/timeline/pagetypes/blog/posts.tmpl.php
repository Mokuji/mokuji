<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<form method="PUT" action="?rest=timeline/page_title/" id="timeline-title-form" class="form">
  
  {{each(language_id, language) languages}}
    
    <div class="multilingual-section" data-language-id="${language.id}">
      
      <?php
        //Shorten the "Title in " translations.
        $title_in = __($component, 'Blog title', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      
      <div class="ctrlHolder">
        <label><?php echo $title_in; ?>${language.title}</label>
        <input type="text" class="title" name="info[${language.id}][title]"
          placeholder="<?php echo $title_in; ?>${language.title}" value="${data.info && data.info[language.id] ? data.info[language.id]['title'] : ''}" />
      </div>
      
    </div>
    
  {{/each}}
  
</form>

<div id="timeline-preview"></div>
