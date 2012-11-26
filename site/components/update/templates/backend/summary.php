<?php namespace components\update; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<h1><?php __($names->component, 'Update management'); ?></h1>
<input type="button" id="check_updates" class="button grey" value="<?php __($names->component, 'Check for updates'); ?>" />

<h2><?php __($names->component, 'Recent updates'); ?></h2>
<div id="recent-updates">
  
  <?php $data->latest_updates->each(function($version)use($names){ ?>
    
    <div class="version-wrapper">
      <h4 title="<?php echo $version->package->description; ?>"><?php echo $version->package->title; ?></h4>
      <?php __($names->component, 'Version'); ?>:
      <span class="version"><?php echo $version->version; ?></span>
      <span class="date">(<?php echo $version->date; ?>)</span>
      <div class="description"><?php echo $version->description; ?></div>
      
      <?php $version->changes->each(function($change)use($names){ ?>
        
        <div class="change-wrapper">
          <h4><?php echo $change->title; ?></h4>
          <div class="change-description"><?php echo $change->description; ?></div>
          <?php echo $change->url->not('empty', function($url)use($names){
            return '<a href="'.$url.'" target="_blank">'.__($names->component, 'More information', 1).'</a>';
          }); ?>
        </div>
        
      <?php }); ?>
      
    </div>
    
  <?php }); ?>
  
</div>

<script type="text/javascript">
  jQuery(function($){
    
    $('#check_updates').on('click', function(e){
      
      $.ajax("<?php echo url('?action=update/check_updates', true); ?>")
        .done(function(res){
          $('#config_app .inner').html(res);
        });
      
    });
    
    $('#configbar .update-summary .counter').hide();
    
  });
</script>
