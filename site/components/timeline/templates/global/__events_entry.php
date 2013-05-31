<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

switch($data->type->get('string')){
  
  case 'event':
    
    //Get timeline names to set as css classes for this event.
    $classes = Data(array());
    $data->timelines->each(function($row)use(&$classes){
      $classes[] = $row->name;
    });
    
    ?>
    
    <?php /* Class name: tl-$timeline_name */ ?>
    <div class="entry event-entry tl-<?php echo implode(' tl-', $classes->get('array')); ?>">
      
      <h2 class="title">
        <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>"><?php echo $data->info->{$data->language}->title; ?></a>
      </h2>
      
      <p class="start-date">
        <span class="label"><?php __($names->component, 'Starting date') ?>:</span>
        <?php /* #TODO: add timezone to site config and integrate it in <time>-fields */ ?>
        <time class="dt-start" datetime="<?php echo str_replace(' ', 'T', $data->dt_start->get()); ?>Z"><?php echo $data->formatted_dt_start->otherwise($data->dt_start); ?></time>
        <?php if($data->is_future->is_true()){ ?>
          <span class="future">(<?php __($names->component, 'In the future') ?>)</span>
        <?php } ?>
      </p>
      
      <p class="end-date">
        <span class="label"><?php __($names->component, 'Ending date') ?>:</span>
        <?php /* #TODO: add timezone to site config and integrate it in <time>-fields */ ?>
        <time class="dt-end" datetime="<?php echo str_replace(' ', 'T', $data->dt_end->get()); ?>Z"><?php echo $data->formatted_dt_end->otherwise($data->dt_end); ?></time>
      </p>
      
      <div class="thumbnail">
        <?php if($data->thumbnail_image->get() != false){ ?>
          <img src="<?php echo $data->thumbnail_image->url; ?>" />
        <?php } ?>
      </div>
      
      <?php if($data->is_summary->is_true()){ ?>
        <div class="summary">
          <?php echo $data->info->{$data->language}->summary; ?>
        </div>
        <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>" class="read-more"><?php __($names->component, 'Read more') ?></a>
      <?php } else { ?>
        <div class="content"><?php echo $data->info->{$data->language}->content; ?></div>
      <?php } ?>
      
      <?php if($data->author->is_set()){ ?>
        <p class="credits">
          <?php __($names->component, 'Posted by') ?>:
          <span class="author"><?php echo $data->author->full_name; ?></span>
        </p>
      <?php } ?>
      
      <?php if(!$data->is_summary->is_true()){ ?>
        <a href="<?php echo url('post=NULL&pid='.$data->pid.'&menu='.$data->menu); ?>" class="back-to-overview"><?php __($names->component, 'Back to overview'); ?></a>
      <?php } ?>
      
    </div>
      
    <?php
    break;
  
}
