<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<h1><?php __('Pages') ?></h1>

<div class="tabs" id="tabs-pages">
  
  <!-- TABS -->
  <ul>
    <li id="tabber-pages" class="active"><a href="#tab-pages"><?php __('Summary'); ?></a></li>
    <!--<li><a href="#tab-new-page"><?php __('New page'); ?></a></li>-->
  </ul>
  <!-- /TABS -->
  
  <!-- CONTENT -->
  
  <!-- pages -->
  <div id="tab-pages" class="tab-content">
    <?php echo $pages->pages; ?>
  </div>
  
  <!-- pages
  <div id="tab-new-page" class="tab-content">
    <?php echo $pages->new_page; ?>
  </div>-->
  
  <!-- /CONTENT -->
  
</div>

<script type="text/javascript">
  $(function(){
    
    $("#tabs-pages ul").idTabs(function(id){
      
      if(id!='#tab-page'){
        $('#tabs-accounts ul #tabber-edit-page').hide();
        $('#tab-page').html('');
      }
      if(id=='#tab-new-page'){
        $(id).find(':input:not([type=submit], [type=checkbox], [type=radio])').val('');
      }

      return true;
      
    });
    
  });
</script>
