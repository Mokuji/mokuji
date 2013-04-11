<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<form method="PUT" action="?rest=text/page_text/" id="text-contentTab-form">
  
  <input type="hidden" name="id" value="${data.id}" />
  <input type="hidden" name="page_id" value="${data.page_id}" />
  
  {{each(language_id, language) languages}}
    
    <div class="multilingual-section" data-language-id="${language.id}">
      
      <?php
        //Shorten the "Title in " translations.
        $title_in = __($component, 'Title', true).' '.__('IN_LANGUAGE_NAME', true, 'lowercase').' ';
      ?>
      
      <input type="text" class="title" name="info[${language.id}][title]"
        placeholder="<?php echo $title_in; ?>${language.title}" value="${data.info && data.info[language.id] ? data.info[language.id]['title'] : ''}" />
      
      <textarea id="l_text_${language.code}_" name="info[${language.id}][text]" class="text editor">
        ${data.info && data.info[language.id] ? data.info[language.id]['text'] : ''}
      </textarea>

      <div class="toggle-wrapper description" style="margin:10px 0;">
        <a href="#" class="trigger">
          Klik hier om <span class="toggle hidden">de </span>additionele tekst te
          <span class="toggle">bewerken</span><span class="toggle hidden">verbergen</span>.
        </a>
        <div class="hidden wrapper description">
          <textarea id="l_description_${language.code}_" name="info[${language.id}][description]" class="description editor">
            ${data.info && data.info[language.id] ? data.info[language.id]['description'] : ''}
          </textarea>
        </div>
      </div>
        
    </div>
    
  {{/each}}
  
</form>
