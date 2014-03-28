<?php namespace components\cms; if(!defined('MK')) die('No direct access.'); ?>

<h1><?php __($names->component, 'Sites') ?></h1>

<div class="tabs" id="tabs-sites">
  
  <!-- TABS -->
  <ul>
    <li id="tabber-sites" class="active"><a href="#tab-sites"><?php __('Summary'); ?></a></li>
    <li id="tabber-new-site"><a href="#tab-new-site"><?php __($names->component, 'New site'); ?></a></li>
    <li id="tabber-edit-site"><a href="#tab-edit-site"><?php __($names->component, 'Edit site'); ?></a></li>
  </ul>
  <!-- /TABS -->
  
  <!-- CONTENT -->
  
  <div id="tab-sites" class="tab-content">
    <?php echo $data->sites; ?>
  </div>
  
  <div id="tab-new-site" class="tab-content">
    <?php echo $sites->new_site; ?>
  </div>
  
  <div id="tab-edit-site" class="tab-content"></div>
  
  <!-- /CONTENT -->
  
</div>

<script type="text/javascript">
  $(function(){
    
    $("#tabs-sites ul").idTabs(function(id){
      
      if(id!='#tab-edit-site'){
        $('#tabs-sites ul #tabber-edit-site').hide();
        $('#tab-edit-site').html('');
      }
      if(id=='#tab-new-site'){
        $(id).find(':input:not([type=submit], [type=checkbox], [type=radio])').val('');
      }

      return true;
      
    });
    
  });
</script>
