<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

{{each(language_id, language) languages}}
  
  <div class="multilingual-section entry ${type}-entry" data-language-id="${language.id}">
    
    <h2 class="title">${info[language.id].title}</h2>
    
    <p class="dt-published">${dt_published}</p>
    
    {{if thumbnail_image}}<img src="${thumbnail_image.url}" class="thumbnail" />{{/if}}
    
    <div class="summary">${info[language.id].summary}</div>
    
    <div class="content">${info[language.id].content}</div>
    
    {{if author}}
      <p class="credits">
        <?php __($component, 'Posted by') ?>
        <span class="author">${author.full_name}</span>
      </p>
    {{/if}}
    
  </div>
  
{{/each}}
