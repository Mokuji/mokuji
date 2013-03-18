<?php namespace components\timeline; if(!defined('TX')) die('No direct access.'); ?>

{{if pages > 1}}

  <label class="pagination-label"><?php __($component, 'Pages') ?></label>

  {{if page-1 > 0}}
    <a href="#" data-page="${page-1}" class="page prev-page"><?php __($component, 'PREVIOUS_PAGE_NOTATION') ?></a>
  {{/if}}

  {{each page_numbers}}
    <a href="#" data-page="${$value}" class="page page-number{{if $value == page}} active{{/if}}">${$value}</a>
  {{/each}}

  {{if page+1 > 0 && page+1 <= pages}}
    <a href="#" data-page="${page+1}" class="page next-page"><?php __($component, 'NEXT_PAGE_NOTATION') ?></a>
  {{/if}}

{{/if}}
