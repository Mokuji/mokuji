<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<h1><?php echo __('Account management'); ?></h1>

<div class="tabs" id="tabs-accounts">

  <!-- TABS -->
  <ul>
    <li id="tabber-users" class="active"><a href="#tab-users"><?php __('Users'); ?></a></li>
    <li id="tabber-user"><a href="#tab-user"><?php __('New user'); ?></a></li>
    <li id="tabber-groups"><a href="#tab-groups"><?php __('Groups'); ?></a></li>
    <li id="tabber-group"><a href="#tab-group"><?php __('New group'); ?></a></li>
    <?php if(tx('Component')->available('mail')){ ?>
      <li id="tabber-mail"><a href="#tab-mail"><?php __('Mail'); ?></a></li>
    <?php } ?>
    <li id="tabber-import"><a href="#tab-import"><?php echo ucfirst(__('IMPORT_PLURAL', 1)); ?></a></li>
  </ul>
  <!-- /TABS -->
  
  <!-- CONTENT -->
  
  <!-- users -->
  <div id="tab-users" class="tab-content">
    <?php echo $accounts->users; ?>
  </div>
  
  <div id="tab-user" class="tab-content">
    <?php echo $accounts->new_user; ?>
  </div>
  
  <div id="tab-groups" class="tab-content">
    <?php echo $accounts->groups; ?>
  </div>
  
  <div id="tab-group" class="tab-content">
    <?php echo $accounts->new_group; ?>
  </div>
  
  <?php if(tx('Component')->available('mail')){ ?>
    <div id="tab-mail" class="tab-content">
      <?php echo $accounts->compose_mail; ?>
    </div>
  <?php } ?>
  
  <div id="tab-import" class="tab-content">
    <?php echo $accounts->import_users; ?>
  </div>
  
  <!-- /CONTENT -->

</div>

<script type="text/javascript">
  $(function(){
    
    $("#tabs-accounts ul").idTabs(function(id){
      
      <?php /*
      if(id != "#tab-user" || $("#tab-user").find("input[name=id]").val() == ""){
        $("#tab-user").find(':input:not([type=submit], [type=checkbox], [type=radio], [type=button])').val('');
        $("#tab-user").find(':input[type=checkbox]').removeAttr('checked');
      }
      
      if(id != "#tab-group" || $("#tab-group").find("input[name=id]").val() == ""){
        $("#tab-group").find(':input:not([type=submit], [type=checkbox], [type=radio], [type=button])').val('');
        $("#tab-group").find(':input[type=checkbox]').removeAttr('checked');
        $("#tab-group").find('div.comboselect #_remove_all').trigger('click');
      }
      */ ?>
      
      if(id != "#tab-user" || $("#tab-user").find("input[name=id]").val() == ""){
        $("#tabber-user").find("a").text("<?php __('New user'); ?>");
      }
      
      if(id != "#tab-group" || $("#tab-group").find("input[name=id]").val() == ""){
        $("#tabber-group").find("a").text("<?php __('New group'); ?>");
      }
      
      //In some cases prevent refresh.
      if($(id).is('.no-refresh')){
        $(id).removeClass('no-refresh');
        return true;
      }
      
      switch(id){
        case '#tab-users': var gowhere = '<?php echo url("?section=account/user_list"); ?>'; break;
        case '#tab-user': var gowhere = '<?php echo url("?section=account/edit_user"); ?>'; break;
        case '#tab-groups': var gowhere = '<?php echo url("?section=account/group_list"); ?>'; break;
        case '#tab-group': var gowhere = '<?php echo url("?section=account/edit_user_group"); ?>'; break;
        <?php if(tx('Component')->available('mail')){ ?>
          case '#tab-mail': var gowhere = '<?php echo url("?section=account/compose_mail"); ?>'; break;
        <?php } ?>
        case '#tab-import': var gowhere = '<?php echo url("?section=account/import_users"); ?>'; break;
      }
      
      if(gowhere)
        $.ajax(gowhere).done(function(d){ $(id).html(d); });
      
      return true;
      
    });
    
  });
  
  $(function(){
    
    $('#tabs-accounts').on('submit', '.import-users-form', function(e){
      
      e.preventDefault();
      
      $(this).ajaxSubmit(function(d){
        $('#tab-import').html(d);
      });
      
    });
    
    $('#tabs-accounts').on('submit', '.edit-user-form', function(e){
      
      e.preventDefault();
      
      $(this).ajaxSubmit(function(d){
        $('#tab-users').html(d);
        $('#tabber-users a').trigger('click');
      });
      
    });
    
    $('#tabs-accounts').on('submit', '#tab-group form', function(e){
      
      e.preventDefault();
      
      $(this).ajaxSubmit(function(d){
        $('#tab-groups').html(d);
        $('#tabber-groups a').trigger('click');
      });
      
    });
    
  });

</script>

<style>
body{
  background-color:#fff;
}
</style>
