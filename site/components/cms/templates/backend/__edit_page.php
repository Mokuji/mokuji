<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<?php if($edit_page->page->get() === false): ?>

<div id="edit_page">

  <div class="title-bar page-title">
    <h2><?php __($names->component, 'Page was deleted') ?>.</h2>
    <ul class="title-bar-icons clearfix">
      <?php if(tx('Data')->get->menu->is_set()){ ?><li><a href="<?php echo url('action=cms/detach_page&menu='.tx('Data')->get->menu.'&pid='.tx('Data')->get->pid); ?>" class="icon detach-page" id="detach-page" title="<?php __($names->component, 'Detach page from menu item'); ?>">Detach</a></li><?php } ?>
    </ul>
    <div class="clear"></div>
  </div>

  <div class="body">
    <?php __($names->component, 'This page was deleted from the database. Unlink it from the menu item.'); ?>
  </div>

</div>

<?php return; endif; ?>

<div id="edit_page">

  <div class="title-bar page-title">
    <h2><span class="title"><?php echo $edit_page->page->title; ?></span> <span style="font-weight:normal;">(<?php __('Page', 0, 'l'); ?>)</span></h2>
    <ul class="title-bar-icons clearfix">
      <li><a href="#" class="icon page-settings" id="toggle-page-settings" title="<?php __($names->component, 'Toggle page settings'); ?>">Toggle page settings</a></li>
      <?php if(tx('Data')->get->menu->is_set()){ ?><li><a href="<?php echo url('action=cms/detach_page&menu='.tx('Data')->get->menu.'&pid='.$edit_page->page->id); ?>" class="icon detach-page" id="detach-page" title="<?php __($names->component, 'Detach page from menu item'); ?>">Detach</a></li><?php } ?>
    </ul>
    <div class="clear"></div>
  </div>

  <div class="header">

    <form method="post" action="<?php echo url("action=cms/edit_page/post&menu=NULL"); ?>" class="form-inline-elements">

      <input type="hidden" name="page_id" id="page_id" value="<?php echo $edit_page->page->id; ?>" />

      <fieldset class="fieldset-general clearfix">

        <div class="inputHolder">
          <label for="l_title_page"><?php __($names->component, 'Page title'); ?></label>
          <input id="l_title_page" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __($names->component, 'Page title') ?>" />
        </div>

        <?php if($edit_page->layout_info->size() > 0){ ?>
          <div class="inputHolder last">
            <label for="l_layout"><?php echo __($names->component, 'Layout'); ?></label>
            <select name="layout_id" id="l_layout">
              <?php
              foreach($edit_page->layout_info as $layout){
                echo '<option value="'.$layout->layout_id.'"'.($layout->layout_id->get()===$edit_page->page->layout_id->get() ? ' selected' : '').'>'.$layout->title.'</option>';
              }
              ?>
            </select>
          </div>
        <?php } ?>

      </fieldset>

    <!-- PAGE CONFIG -->
      <div id="page-config">

        <div class="inner">

          <h3><?php __($names->component, 'Page settings') ?></h3>

          <div class="page-item">

            <div class="left">

              <fieldset class="fieldset-display">

                <legend><?php __($names->component, 'PAGE_DISPLAY', 'ucfirst'); ?></legend>

                <div class="inputHolder">
                  <label><?php __($names->component, 'Site layout'); ?></label>
                  <?php echo $edit_page->templates->as_options('template_id', 'title', 'id', array('id' => 'template_id', 'default' => ($edit_page->page->template_id->get('int') > 0 ? $edit_page->page->template_id->get('int') : tx('Config')->user('template_id')->get('int')), 'placeholder_text' => __($names->component, 'Select a site layout', 1))); ?>
                </div>

                <div class="inputHolder">
                  <label><?php __($names->component, 'Theme'); ?></label>
                  <?php echo $edit_page->themes->as_options('theme_id', 'title', 'id', array('default' => ($edit_page->page->theme_id->get('int') > 0 ? $edit_page->page->theme_id->get('int') : tx('Config')->user('theme_id')->get('int')), 'placeholder_text' => __($names->component, 'Select a theme', 1))); ?>
                </div>

  <?php
  /*
                <div id="appearance-slider" style="height:auto;">

                  <div class="toolbar theme">
                    <a href="#" class="btn-prev"></a>
                    <div class="title">
                      <?php
                      echo $edit_page->themes->as_options('theme_id', 'title', 'id', array('default' => ($edit_page->page->theme_id->get('int') > 0 ? $edit_page->page->theme_id->get('int') : tx('Config')->user('theme_id')), 'placeholder_text' => __('Select a theme', 1)));
                      ?>
                    </div>
                    <a href="#" class="btn-next"></a>
                  </div>

  <!--
                  <div class="preview-container">

                  </div>
  -->

                  <div class="toolbar template">
                    <a href="#" class="btn-prev"></a>
                    <div class="title">
                      <?php
                      echo $edit_page->templates->as_options('template_id', 'title', 'id', array('id' => 'template_id', 'default' => ($edit_page->page->template_id->get('int') > 0 ? $edit_page->page->template_id->get('int') : tx('Config')->user('template_id')), 'placeholder_text' => __('Select a template', 1)));
                      ?>
                    </div>
                    <a href="#" class="btn-next"></a>
                  </div>

                </div>
  */
  ?>

              </fieldset>

            </div>

            <div class="right">

  <!--
              <fieldset class="fieldset-variables">

                <legend>Variabelen</legend>

                <label for="variable_1"><?php __('Variable'); ?> 1</label>
                <input id="variable_1" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __('Page title') ?>" />

                <label for="variable_2"><?php __('Variable'); ?> 2</label>
                <input id="variable_2" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __('Page title') ?>" />

              </fieldset>

              <fieldset class="fieldset-metatags">

                <legend>Meta tags</legend>

                <label for="metatags"><?php __('Meta tags'); ?></label>
                <input id="metatags" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __('Page title') ?>" />

              </fieldset>

              <fieldset class="fieldset-publish">

                <legend>Variabelen</legend>

                <label for="variable_1"><?php __('Variable'); ?> 1</label>
                <input id="variable_1" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __('Page title') ?>" />

                <label for="variable_2"><?php __('Variable'); ?> 2</label>
                <input id="variable_2" class="big" type="text" name="title" value="<?php echo $edit_page->page->title ?>" placeholder="<?php __('Page title') ?>" />

              </fieldset>
  -->

              <fieldset class="fieldset-rights">

                <legend><?php __('User rights'); ?></legend>

                <?php __('Accessable to'); ?>:
                <ul>
                  <li><label><input type="radio" name="access_level" value="0"<?php echo ($edit_page->page->access_level->get('int') <= 0 ? ' checked="checked"' : ''); ?> /> <?php __('Everyone'); ?></label></li>
                  <li><label><input type="radio" name="access_level" value="1"<?php echo ($edit_page->page->access_level->get('int') == 1 ? ' checked="checked"' : ''); ?> /> <?php __('Logged in users'); ?></label></li>
                  <li><label><input type="radio" name="access_level" value="2"<?php echo ($edit_page->page->access_level->get('int') == 2 ? ' checked="checked"' : ''); ?> class="members" /> <?php __($names->component, 'Group members'); ?></label></li>
                  <li><label><input type="radio" name="access_level" value="3"<?php echo ($edit_page->page->access_level->get('int') == 3 ? ' checked="checked"' : ''); ?> /> <?php __('Admins'); ?></label></li>
                </ul>

                <fieldset class="fieldset-groups">

                  <legend><?php __($names->component, 'Groups with access'); ?></legend>

                  <ul>
                    <?php
                    
                    tx('Component')
                      ->helpers('cms')
                      ->get_page_permissions($data->page->id)
                      ->group_permissions->each(function($group){
                        echo '<li><label><input type="checkbox" name="user_group_permission['.$group->id.']" value="1"'.($group->access_level->get() > 0 ? ' CHECKED' : '').' /> '.$group->title.'</label></li>'.n;
                      });
                    
                    ?>
                  </ul>

                </fieldset>

              </fieldset>

              <fieldset class="fieldset-page-info" style="display:none;">

                <legend><?php __($names->component, 'Page info'); ?></legend>

                <?php
                
                if(tx('Component')->available('language')){
                
                  tx('Component')->helpers('language')->get_languages(array('in_language_id'=>LANGUAGE))
                    ->each(function($lang)use($data){
                    ?>

                    <div class="inputHolder" hidden>
                      <label for="l_page_info__title_<?php echo $lang->id; ?>"><?php __($names->component, 'Page title (visible in addressbar)'); ?> <?php __('IN_LANGUAGE_NAME'); ?> <?php echo $lang->title; ?></label>
                      <input class="big" type="text" id="l_page_info__title_<?php echo $lang->id; ?>" name="info[<?php echo $lang->id; ?>][title]" value="<?php echo $data->page->info[$lang->id]->title; ?>" />
                    </div>

                    <div class="inputHolder"style="height:auto;">
                      <label style="float:none;width:280px;clear:both;"  for="l_page_info__slogan_<?php echo $lang->id; ?>"><?php __($names->component, 'Slogan (visible in header)'); ?> <?php __('IN_LANGUAGE_NAME'); ?> <?php echo $lang->title; ?></label>
                      <input style="float:none;clear:both;" class="big" type="text" id="l_page_info__slogan_<?php echo $lang->id; ?>" name="info[<?php echo $lang->id; ?>][slogan]" value="<?php echo $data->page->info[$lang->id]->slogan; ?>" />
                    </div>

                    <?php
                  });
                  
                }
                
                //Without language component.
                else {
                  
                  ?>
                  <div class="inputHolder" hidden>
                    <label for="l_page_info__title_<?php echo LANGUAGE; ?>"><?php __($names->component, 'Page title (visible in addressbar)'); ?></label>
                    <input class="big" type="text" id="l_page_info__title_<?php echo LANGUAGE; ?>" name="info[<?php echo LANGUAGE; ?>][title]" value="<?php echo $data->page->info[LANGUAGE]->title; ?>" />
                  </div>

                  <div class="inputHolder"style="height:auto;">
                    <label style="float:none;width:280px;clear:both;"  for="l_page_info__slogan_<?php echo LANGUAGE; ?>"><?php __($names->component, 'Slogan (visible in header)'); ?></label>
                    <input style="float:none;clear:both;" class="big" type="text" id="l_page_info__slogan_<?php echo LANGUAGE; ?>" name="info[<?php echo LANGUAGE; ?>][slogan]" value="<?php echo $data->page->info[LANGUAGE]->slogan; ?>" />
                  </div>
                  <?php
                  
                }
                ?>

              </fieldset>

            </div>

            <div class="clear"></div>

          </div>

        </div>

      </div><!-- eof:#page-config -->

    </form>

    
  </div><!-- eof:.header -->

  <div class="body">

    <div id="page_content">

      <div class="inner">
        <h3><?php echo __($names->component, 'Page content'); ?></h3>
        <?php echo $edit_page->content; ?>
      </div>

    </div><!-- eof:#page-content -->
    
    <div class="reset"></div>    

  </div>
  
  <div class="footer" id="save-buttons">
    <button id="save-page" class="button black"><?php __('Save'); ?></button>
    <button id="save-page-return" href="<?php echo url(('section='.(tx('Data')->get->pid->is_set() ? 'cms/config_app&view=cms/pages' : 'cms/app')), true); ?>" class="button grey"><?php __('Save and return'); ?></button>
    <button id="cancel-page" href="<?php echo url(('section='.(tx('Data')->get->pid->is_set() ? 'cms/config_app&view=cms/pages' : 'cms/app')), true); ?>" class="button grey"><?php __('Cancel'); ?></button>
    <!--<?php if(tx('Data')->get->pid->is_set()){ ?><button id="delete-page" href="<?php echo url('action=cms/delete_page&page_id='.tx('Data')->get->pid); ?>" class="button grey"><?php __('Delete'); ?></button><?php } ?>-->
  </div>

</div>

<script type="text/javascript">

var com_cms = (function(TxComCms){

  var //private properties
    defaults = {
    };
  
  //Public callbacks collection.
  if(!TxComCms.submitCallbacks)
    TxComCms.submitCallbacks = {};
  
  //public init(o)
  TxComCms.init_edit_page = function(){

    //
    if($('.fieldset-rights').find('input[name=access_level]').hasClass('members')){
          $('.fieldset-groups').show();
    }

    //page permissions
    $('.fieldset-rights')

      .on('click', 'input[name=access_level]', function(){
        if($(this).hasClass('members')){
          $('.fieldset-groups').show();
        }else{
          $('.fieldset-groups').hide();
        }
      });

    $('#edit_page')

      //Toggle page settings.        
      .on('click', '#toggle-page-settings', function(){
        $('#page-config').toggle();
        $('#page_content').toggle();
        $('#toggle-page-settings').toggleClass('page-content');
      })

      //Detach page from menu item.
      .on('click', '#detach-page', function(e){
        // e.preventDefault();
        // if(confirm('<?php __('Are you sure you want to detach this page from the menu item?'); ?>')){
        //   return true;
        // }else{
        //   return false;
        // }
      })

      //Update page title on change.
      .on('keyup', '#l_title_page', function(){
        $('#edit_page .title-bar.page-title .title').text($(this).attr('value'));
      });

/*    //layout select
    $('#edit_page select[name=layout_id]').change(function(e){

      e.preventDefault();

      $.ajax({
        data : {
          part: $(this).children(':selected').val().toInt(),
          pid: <?php echo $edit_page->page->page_info->id->get('int'); ?>
        }
      });

    }); */
    
    //cycle themes
    $('#appearance-slider')

      .on('click', '.theme a.btn-prev', function(e){
        e.preventDefault();
        var to_select = $('.theme .tx-select').find('option:selected').prev('option');
        $('.theme .tx-select option').removeAttr('selected');
        $(to_select).attr('selected', 'selected');
      })
      .on('click', '.theme a.btn-next', function(e){
        e.preventDefault();
        var to_select = $('.theme .tx-select option:selected').next('option');
        $('.theme .tx-select option').removeAttr('selected');
        $(to_select).attr('selected', 'selected');
      })
      .on('click', '.template a.btn-prev', function(e){
        e.preventDefault();
        var to_select =  $('.template .tx-select option:selected').prev('option');
        $('.template .tx-select option').removeAttr('selected');
        $(to_select).attr('selected', 'selected');
      })
      .on('click', '.template a.btn-next', function(e){
        e.preventDefault();
        var to_select = $('.template .tx-select option:selected').next('option');
        $('.template .tx-select option').removeAttr('selected');
        $(to_select).attr('selected', 'selected');
      });

    $("#detach-page").on("click", function(e){
    
      e.preventDefault();
      
      $.ajax({
        url: $(this).attr("href")
      }).done(function(data){
        $("#page-main-right").html(data);
      });
    
    });
    
    //submit edit_page form
    $('#edit_page .header form').on('submit', function(e){

      e.preventDefault();

      //save page
      if($.isFunction(com_cms.save_page)){
        com_cms.save_page();
      }

      // save page content
      if($.isFunction(com_cms.save_page_content)){
        com_cms.save_page_content();
      }
      $("#page_app form").each(function(){
        var cb = $(this).attr('data-callback');
        $(this).ajaxSubmit({
          data: {
            page_id: <?php echo ($edit_page->page->id->get('int') > 0 ? $edit_page->page->id->get('int') : tx('Data')->get->pid->get('int')); ?>
          },
          success: function(data){
            if(com_cms.submitCallbacks[cb])
              com_cms.submitCallbacks[cb].apply(this, arguments);
            //alert(data);
          }
        });
      });

      // save menu item
      if($.isFunction(com_cms.save_menu_item)){
        com_cms.save_menu_item();
      }
      
    });
  
    //button:save-page buttonhandler
    $('#save-page').click(function(e){
      e.preventDefault();
      $('#edit_page .header form').trigger('submit');
    });
  
    //button:save-page-return handler
    $('#save-page-return').click(function(e){
      e.preventDefault();
      $('#edit_page .header form').trigger('submit');
      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#page-main-right").html(data);
      });
    });

    //button:cancel-page handler
    $('#cancel-page').click(function(e){
      e.preventDefault();
      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#page-main-right").html(data);
      });
    });
    
    return this;

  }
  
  //public save_page()
  TxComCms.save_page = function(){
    $('#save-page').text('<?php __('Saving'); echo '...'; ?>');
    $("#edit_page .header form").ajaxSubmit(function(){
      $('#save-page').text('<?php __('Saved'); echo '.'; ?>');
      setTimeout(function(){
        $('#save-page').text('<?php __('Save'); ?>');
      }, 750);
    });
    return this;
  }
  
  return TxComCms;

})(com_cms||{});

$(function(){
  com_cms.init_edit_page();
});

</script>
