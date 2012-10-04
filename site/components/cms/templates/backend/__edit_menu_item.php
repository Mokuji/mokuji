<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<div id="edit-menu-item">
  
  <form id="form-menu-item" method="post" action="<?php echo url('action=cms/save_menu_item/post'); ?>" class="form-inline-elements">
    
    <input type="hidden" name="id" value="<?php echo $edit_menu_item->item->id; ?>" />

    <div class="title-bar page-title">
      <h2><span class="title"><?php echo $edit_menu_item->item->info->{LANGUAGE}->title; ?></span> <span style="font-weight:normal;">(menu-item)</span></h2>
      <ul class="title-bar-icons clearfix">
        <?php if(tx('Component')->available('media')){ ?>
          <li><a href="#" class="icon menu-item-settings" id="toggle-menu-item-settings" title="<?php __('Toggle menu item settings'); ?>">Toggle menu item settings</a></li>
        <?php } ?>
        <li><a href="#" class="icon" id="detach-menu-item" style="display:none;">Detach menu item from page</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    
    <div class="body clearfix">

      <fieldset class="menu_item_titles-wrapper">
        <?php

        if(tx('Component')->available('language')){

          $languages =
            tx('Component')->helpers('language')->get_languages(array('in_language_id'=>LANGUAGE));

          $languages
            ->each(function($lang)use($data, $languages){
              $in_language_text = ($languages->size() <= 1 ? '' : $in_language_text = ' '.__('IN_LANGUAGE_NAME', 1).' '.$lang->title);
            ?>

            <div class="inputHolder">
            <label for="l_title_menu_item_<?php echo $lang->id; ?>"><?php __('Menu-item titel').$in_language_text; ?></label>
            <input class="big" type="text" id="l_title_menu_item_<?php echo $lang->id; ?>" name="info[<?php echo $lang->id; ?>][title]" value="<?php echo $data->item->info[$lang->id]->title; ?>" />
            </div>

            <?php
          });

        }

        else{
          ?>
          <div class="inputHolder">
            <label for="l_title_menu_item_<?php echo LANGUAGE; ?>"><?php __('Menu-item titel'); ?></label>
            <input class="big" type="text" id="l_title_menu_item_<?php echo LANGUAGE; ?>" name="info[<?php echo LANGUAGE; ?>][title]" value="<?php echo $data->item->info[LANGUAGE]->title; ?>" />
          </div>
          <?php
        }
        
        ?>
      </fieldset>

      <!-- Select menu -->
      <div class="inputHolder last">

        <?php if($data->menus->size() > 1){ ?>

          <label for="l_menu"><?php echo __('Menu'); ?></label>
          <?php echo $data->menus->as_options('menu_id', 'title', 'id', array(
            'id'=>'l_menu',
            'force_choice'=>true,
            'default'=>$data->item->menu_id->otherwise(tx('Data')->filter('cms')->menu_id)
          )); ?>

        <?php }elseif($data->menus->size() == 1){ ?>

          <input type="hidden" name="menu_id" value="<?php echo $data->menus->{0}->id; ?>">

        <?php }else{ ?>

          De website is verkeerd geconfigureerd.<br />
          Neem alstublieft contact op met de site-ontwikkelaar.

        <?php } ?>

      </div>

      <!-- MENU ITEM CONFIG -->
      <div id="menu-item-config">

        <div class="inner">

          <h3><?php __('Menu item settings') ?></h3>
          
          <?php if(tx('Component')->available('media')){ ?>
          <fieldset>
            
            <div class="ctrlHolder">
              <label for="l_header_image_preview"><?php __('Image'); ?></label><br />
              <img id="menu_item_image" src="<?php echo url(URL_BASE.'?section=media/image&resize=0/150&id='.$data->item->image_id); ?>"<?php echo ($data->item->image_id->get() > 0 ? '' : ' style="display:none;"'); ?> />
              <input type="hidden" id="l_menu_item_image_id" name="image_id" value="<?php echo $data->item->image_id; ?>">
            </div>
            
            <?php if($data->item->image_id->get() > 0){ ?>
            <div class="ctrlHolder">
              <input id="delete-menu-item-image" type="button" class="button grey" value="Delete image" />
              <script type="text/javascript" language="javascript">
                jQuery(function($){
                  
                  $('#delete-menu-item-image').on('click', function(e){
                    
                    e.preventDefault();
                    
                    var wrapper = $(e.target).closest('fieldset');
                    var id = wrapper.find('input[name=image_id]');
                    $.rest('DELETE', '?rest=media/image/'+id.val())
                      .done(function(){
                        id.val('');
                        wrapper.find('#menu_item_image').attr('src', '').hide();
                        $('#form-menu-item').submit();
                      });
                    
                  });
                  
                });
              </script>
            </div>
            <?php } ?>
            
            <div class="ctrlHolder">
              <?php echo $data->image_uploader; ?>
            </div>

          </fieldset>
          <?php } ?>

        </div>

      </div><!-- /#menu-item-config -->


      <div class="clear"></div>

    </div>
    
    <?php if(tx('Data')->get->menu->is_set() && tx('Data')->get->menu->get('int') == 0){ ?>
    
    <div class="footer">
      
      <input type="submit" id="save-menu-item" value="<?php __('Save'); ?>" />
      
    </div>

    <style type="text/css">

    #edit-menu-item:after {
      background:none;
    }

    </style>
    
    <?php } ?>
  
  </form>
  
</div>


<script type="text/javascript">

$(function(){

  var form = $('#edit-menu-item');

  //On uploaded file.
  window.plupload_image_file_id = function(up, ids, file_id){
    
    form.find('#menu_item_image')
      .attr('src', '<?php echo url(URL_BASE."?section=media/image&resize=0/150&id=", true); ?>'+file_id).show();
    
    form.find('#l_menu_item_image_id')
      .val(file_id);
    
  };

});

var com_cms = (function(TxComCms){

  TxComCms.init_edit_menu_item = function(){

    $("#edit-menu-item #form-menu-item .inputHolder input:first-child").focus();


    $('#edit-menu-item')

      //Toggle menu item settings.        
      .on('click', '#toggle-menu-item-settings', function(){
        $('#menu-item-config').toggle();
        $('#toggle-menu-item-settings').toggleClass('page-content');
      })

    //submit edit_page form
    $('#form-menu-item').on('submit', function(e){

      e.preventDefault();

      //save page
      if($.isFunction(com_cms.save_page)){
        com_cms.save_page();
      }

      // save page content
      if($.isFunction(com_cms.save_page_content)){
        com_cms.save_page_content();
      }

      // save menu item
      if($.isFunction(com_cms.save_menu_item)){
        com_cms.save_menu_item();
      }
      
    });

  }

  //public save_menu_item()
  TxComCms.save_menu_item = function(){
    $("#form-menu-item").ajaxSubmit(function(d){

      //show page app if necessary
      if(!($.isFunction(com_cms.save_page))){
        $("#app").replaceWith(d);
      }
      
      //update menu items in left sidebar
      $.ajax({url: "<?php echo url('section=cms/menu_items'); ?>"}).done(function(d){
        $("#page-main-left .content .inner").html(d);
        app.init();
      });
      
    });
    return this;
  }
  
  return TxComCms;

})(com_cms||{});

$(function(){
  if(com_cms){
    com_cms.init_edit_menu_item();
  }
});

</script>
