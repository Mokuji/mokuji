<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

switch($data->type->get('string')){
  
  case 'blogpost':
    ?>
    
    <div class="entry blogpost-entry">
    
      <h2 class="title">
        <?php echo $data->info->{$data->language}->title; ?>
      </h2>
      
      <p class="publish-date">
        <?php __($names->component, 'Publish date') ?>:
        <span class="dt-publish"><?php echo $data->dt_publish; ?></span>
        <?php if($data->is_future->is_true()){ ?>
          <span class="future">(<?php __($names->component, 'In the future') ?>)</span>
        <?php } ?>
      </p>
      
      <?php if($data->thumbnail_image->is_set()){ ?>
        <img src="<?php $data->thumbnail_image->url; ?>" class="thumbnail" />
      <?php } ?>
      
      <?php if($data->is_summary->is_true()){ ?>
        <div class="summary">
          <?php echo $data->info->{$data->language}->summary; ?>
          <a href="<?php echo url('post='.$data->id); ?>" class="read-more"><?php __($names->component, 'Read more') ?></a>
        </div>
      <?php } else { ?>
        <div class="content"><?php echo $data->info->{$data->language}->content; ?></div>
      <?php } ?>
      
      <?php if($data->author->is_set()){ ?>
        <p class="credits">
          <?php __($names->component, 'Posted by') ?>:
          <span class="author"><?php echo $data->author->full_name; ?></span>
        </p>
      <?php } ?>
    
    </div>
      
    <?php
    break;
  
}
