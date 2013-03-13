<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

<!-- keeps the 100% width view -->
<div class="pagination-viewport">
  
  <!-- has a 100% * pages width -->
  <div class="pagination-wrapper">
    
    <!-- posts preview page -->
    <div class="page-1">
      
      <form method="PUT" action="?rest=timeline/page_title/" id="timeline-title-form" class="form">
        
        <input type="hidden" name="page_id" value="${data.page.page_id}" />
        
        {{each(language_id, language) languages}}
          
          <div class="multilingual-section" data-language-id="${language.id}">
            
            <?php
              //Shorten the "Title in " translations.
              $title_in = __($component, 'Blog title', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
            ?>
            
            <div class="ctrlHolder">
              <label><?php echo $title_in; ?>${language.title}</label>
              <input type="text" class="title" name="info[${language.id}][title]"
                placeholder="<?php echo $title_in; ?>${language.title}"
                value="${data.page.info && data.page.info[language.id] ? data.page.info[language.id]['title'] : ''}" />
            </div>
            
          </div>
          
        {{/each}}
        
        <div class="ctrlHolder">
          <a class="edit-item" href="#" data-entry=""><?php __($component, 'New post') ?></a>
        </div>
        
      </form>

      <div id="timeline-preview"></div>
      
    </div>
    
    <!-- edit post page -->
    <div class="page-2"></div>

  </div>
</div>
