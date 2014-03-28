<?php namespace components\cms; if(!defined('MK')) die('No direct access.'); ?>

<div id="new-page-wrap">

  <h1><?php __($names->component, 'Add a page', 'ucfirst'); ?></h1>

  <ul class="pagetypes-list">
    <?php
    
    $new_page->page_types->each(function($page_type){
      echo
        '  <li class="page-type-'.$page_type->name.'">'.
        '    <a href="#" data-id="'.$page_type->id.'" title="'.$page_type->preferred_description.'">'.$page_type->preferred_title.'</a>'.
        '  </li>';
    });
    
    ?>
  </ul>

  <h2><?php __($names->component, 'Or select an existing page'); ?></h2><br />
  
  <select name="pages" id="page-link">
    <option value="">-- <?php __($names->component, 'Select a page'); ?> --</option>
  <?php
  $new_page->pages->each(function($page){
    echo '<option value="'.$page->id.'">'.$page->preferred_title.($page->notes->get() != '' ? ' ('.$page->notes->split("\n")->{0}->trim().')' : '').'</option>';
  });
  ?>
  </select>

</div>