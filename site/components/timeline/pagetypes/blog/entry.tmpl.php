<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

{{each(language_id, language) languages}}
  
  <div class="multilingual-section entry ${data.type}-entry" data-language-id="${language.id}">
    
    <h2 class="title">
      {{if data.info && data.info[language.id] && data.info[language.id].title}}
        ${data.info[language.id].title}
      {{else}}
        {{html '<em class="untitled">&laquo;<?php __($component, 'Untitled in this language') ?>&raquo;</em>'}}
      {{/if}}
      <a class="edit-item" href="#" data-entry="${data.id}">edit</a>
    </h2>
    
    <p class="dt-published">${data.dt_published}</p>
    
    {{if data.thumbnail_image}}<img src="${data.thumbnail_image.url}" class="thumbnail" />{{/if}}
    
    <div class="summary">{{html data.info && data.info[language.id] && data.info[language.id].summary}}</div>
    
    <div class="content">{{html data.info && data.info[language.id] && data.info[language.id].content}}</div>
    
    {{if data.author}}
      <p class="credits">
        <?php __($component, 'Posted by') ?>
        <span class="author">${data.author.full_name}</span>
      </p>
    {{/if}}
    
  </div>
  
{{/each}}
