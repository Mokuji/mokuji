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
      
      <h2 class="title">
        <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>" target="_top"><?php echo $data->info->{$data->language}->title; ?></a>
      </h2>
      
      <p class="publishgit-date">
        <span class="label"><?php __($names->component, 'Publish date') ?>:</span>
        <?php /* #TODO: add timezone to site config and integrate it in <time>-fields */ ?>
        <time class="dt-publish" datetime="<?php echo str_replace(' ', 'T', $data->dt_publish->get()); ?>Z" title="<?php echo $data->dt_publish->get(); ?>"><?php echo $data->formatted_dt_publish->otherwise($data->dt_publish); ?></time>
        <?php if($data->is_future->is_true()){ ?>
          <span class="future">(<?php __($names->component, 'In the future') ?>)</span>
        <?php } ?>
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
        <a href="<?php echo url('post='.$data->id.'&pid='.$data->pid.'&menu='.$data->menu); ?>" class="read-more" target="_top"><?php __($names->component, 'Read more') ?></a>
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
        <a href="<?php echo url('post=NULL&pid='.$data->pid.'&menu='.$data->menu); ?>" class="back-to-overview" target="_top"><?php __($names->component, 'Back to overview'); ?></a>
      <?php } ?>
      
    </div>
      
    <?php
    break;
  
}
