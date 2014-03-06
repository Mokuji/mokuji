<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

switch($data->type->get('string')){
  
  case 'blogpost':
    
    //Get timeline names to set as css classes for this blogpost.
    $classes = Data(array());
    $data->timelines->each(function($row)use(&$classes){
      $classes[] = $row->name;
    });
    
    ?>
    
    <?php /* Class name: tl-$timeline_name */ ?>
    
    <div class="entry blogpost-entry tl-<?php echo implode(' tl-', $classes->get('array')); ?>">
      
      <div data-model="timeline/entry" data-data="id=<?php echo $data->id; ?>">
        
        <h2 class="title">
          <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>" data-field="info.<?php echo $data->language; ?>.title" data-type="text"><?php echo $data->info->{$data->language}->title; ?></a>
        </h2>
        
        <p class="publishgit-date">
          <span class="label"><?php __($names->component, 'Publish date') ?>:</span>
          <?php /* #TODO: add timezone to site config and integrate it in <time>-fields */ ?>
          <time class="dt-publish" datetime="<?php echo str_replace(' ', 'T', $data->dt_publish->get()); ?>Z"><?php echo $data->formatted_dt_publish->otherwise($data->dt_publish); ?></time>
          <?php if($data->is_future->is_true()){ ?>
            <span class="future">(<?php __($names->component, 'In the future') ?>)</span>
          <?php } ?>
        </p>
        
        <div class="thumbnail">
          <?php if($data->thumbnail_image->get() != false){ ?>
            <img src="<?php echo $data->thumbnail_image->url; ?>" />
          <?php } ?>
        </div>
        
        <?php if($data->is_summary->is_true()): ?>
          <div class="summary" data-field="info.<?php echo $data->language; ?>.summary" data-type="text"><?php echo $data->info->{$data->language}->summary; ?></div>
        <?php else: ?>
          <div class="content" data-field="info.<?php echo $data->language; ?>.content" data-type="text"><?php echo $data->info->{$data->language}->content; ?></div>
        <?php endif; ?>
        
        <?php if($data->author->is_set()){ ?>
          <p class="credits">
            <?php __($names->component, 'Posted by') ?>:
            <span class="author"><?php echo $data->author->full_name; ?></span>
          </p>
        <?php } ?>
      
      </div>
      
      <?php if($data->is_summary->is_true()): ?>
        <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>" class="read-more"><?php __($names->component, 'Read more') ?></a>
      <?php else: ?>
        <a href="<?php echo url('post=NULL&pid='.$data->pid.'&menu='.$data->menu); ?>" class="back-to-overview"><?php __($names->component, 'Back to overview'); ?></a>
      <?php endif; ?>
      
    </div>
      
    <?php
    break;
  
}
