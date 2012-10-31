<?php namespace components\account; if(!defined('TX')) die('No direct access.');
$uid = tx('Security')->random_string(20);
?>
<form method="post" id="<?php echo $uid; ?>" action="<?php echo url('rest=account/mail'); ?>" class="form compose-mail-form">
  
  <div class="ctrlHolder">
    <label for="l_recievers_input"><?php __($names->component, 'Reciever(s)'); ?></label>
    <input class="big large no-enter" type="text" id="l_recievers_input" name="recievers_input" tabindex="1" />
    <div id="recievers_list" class="clearfix"></div>
  </div>
  
  <div class="ctrlHolder">
    <label for="l_subject" accesskey="s"><?php __('Subject'); ?></label>
    <input class="big large no-enter" type="text" id="l_subject" name="subject" value="<?php __($names->component, 'A message from'); ?> <?php echo URL_BASE; ?>" tabindex="2" required />
  </div>
  
  <div class="ctrlHolder">
    <label for="<?php echo $uid; ?>-message" accesskey="m"><?php __('Message'); ?></label>
    <textarea id="<?php echo $uid; ?>-message" name="message" class="editor" tabindex="3"></textarea>
  </div>
  
  <div class="buttonHolder">
    <input class="primaryAction button black" id="b_submit" type="submit" value="<?php __($names->component, 'Send email'); ?>" tabindex="4" />
  </div>
  
</form>

<script type="text/javascript">

$(function(){
  
  // Init editor
  tx_editor.init({
    selector:"#<?php echo $uid; ?>-message",
    config: {
      autologin: {
        defaultText: '<?php __($names->component, "Click here to go to the frontpage quickly"); ?>',
        successUrl: '<?php echo URL_BASE; ?>',
        failureUrl: '<?php echo url("/admin/", true); ?>'
      },
      path_ckfinder:"<?php echo URL_PLUGINS; ?>ckfinder/",
      toolbar_Full: [
        {/* 0 */}, {/* 1 */}, {/* 2 */}, {/* 3 */}, '/',
        {/* 5 */}, {/* 6 */}, {/* 7 */ items:[<?php cond_print(tx('Component')->available('autologin'), '\'Autologin\', '); ?>'Link', 'Unlink', 'Anchor']}
      ]
    }
  });
  
  //Prevent submitting with enter.
  $('.no-enter').on('keypress', function(e){ if(e.which == 13) e.preventDefault(); });
  
  //Make awesomesauce notifications possible.
  $('#<?php echo $uid; ?>').restForm({
    success: function(){
      $.flash('success', "<?php __($names->component, 'Sent mail successfully'); ?>");
      $('#tabber-users').find('a').trigger('click');
    }
  })
  
  //Autocomplete recipients.
  var users_added = []
    , groups_added = [];
  
  $('#l_recievers_input').autocomplete({
    
    //Get options from remote and filter out already used ones locally.
    source: function(request, response){
      $.ajax('?rest=account/mail_autocomplete/'+request.term).done(function(results){
        
        var options = [];
        
        //Convert object to array and filter out duplicates.
        $.each(results, function(index, item){
          if(!(item.is_user && users_added[item.id]) && !(item.is_group && groups_added[item.id]))
            options.push(item);
        });
        
        response(options);
        
      })
    },
    
    //Add the reciever to the list and store it in javascript vars too.
    select: function(e, ui){
      
      e.preventDefault();
      var type = null;
      
      if(ui.item.is_user){
        users_added[ui.item.id] = true;
        type = 'user';
      }
      
      else if(ui.item.is_group){
        groups_added[ui.item.id] = true;
        type = 'group';
      }
      
      $('#recievers_list').prepend(
        $('<div>', {text: ui.item.label, "class":type+' reciever'})
          .append('<input type="hidden" name="'+type+'[]" value="'+ui.item.id+'"><a href="#" class="remove">x</a>')
      );
      e.target.value = '';
      
    }
    
  });
  
  //Allow removing of recievers.
  $('#recievers_list').on('click', '.remove', function(e){
    
    e.preventDefault();
    var div = $(e.target).closest('div');
    
    //If this is a user delete it from users_added.
    if(div.is('.user'))
      delete users_added[div.find('input').val()];
    
    //If this is a group delete it from groups_added.
    else if (div.is('.group'))
      delete groups_added[div.find('input').val()];
    
    div.remove();
    $('#l_recievers_input').focus();
    
  });

});

</script>
