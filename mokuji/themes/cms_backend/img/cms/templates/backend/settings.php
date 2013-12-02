<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<h1><?php __($names->component, 'SETTINGS_VIEW_TITLE', 'ucfirst'); ?></h1>

<div class="clearfix">
  
  <ul id="settings-navigation" class="config-navigation">
    <?php foreach($data->menu as $item): ?>
      <li><a class="nav-item <?php echo $item->id; ?>"
        href="<?php echo url('?section=cms/settings_page&options[id]='.$item->id, true); ?>"
        ><?php echo $item->preferred_title; ?></a></li>
    <?php endforeach; ?>
  </ul>
  
  <div id="settings-content-pane" class="config-content-pane"><?php echo $data->content; ?></div>
  
</div>

<script type="text/javascript">
jQuery(function($){
  
  var $navigation = $('#settings-navigation')
    , $content = $('#settings-content-pane');
  
  //Clicking the navigation.
  $navigation.on('click', 'li a', function(e){
    e.preventDefault();
    
    var hasFeedback = (window.app && app.Feedback);
    
    if(hasFeedback) app.Feedback.working("<?php __($names->component, 'Loading'); ?>");
    
    $.ajax($(this).attr('href'))
      .done(function(html){
        
        if(html){
          $content.html(html);
          app.Feedback.success("<?php __($names->component, 'Loaded'); ?>")
        }else{
          app.Feedback.error("<?php __($names->component, 'There was a problem loading the section'); ?>");
        }
        
      })
      .error(function(xhs, request, message){
        app.Feedback.error(message);
      });
  });
  
});
</script>
