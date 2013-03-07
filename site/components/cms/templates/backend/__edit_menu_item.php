<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>
<script id="edit_menu_tmpl" type="text/x-jquery-tmpl">
  
  <div id="edit-menu-item" class="{{if item && item.page_id}}has-page{{/if}}">
    
    <form id="form-menu-item" method="{{if item && item.id > 0}}put{{else}}post{{/if}}" action="<?php echo url('rest=menu/menu_item', 1); ?>" class="form-inline-elements">
      
      <input type="hidden" name="id" value="${item.id}" />
      
      <div class="title-bar page-title">
        <h2><span class="title">{{if item && item.id > 0}}${item.info['<?php echo tx('Language')->get_language_id(); ?>'].title}{{/if}}</span> <span style="font-weight:normal;">(<?php __($names->component, 'Menu item', 'l') ?>)</span></h2>
        <ul class="title-bar-icons clearfix">
          <?php if(tx('Component')->available('media')){ ?>
            <li><a href="#" class="icon menu-item-settings" id="toggle-menu-item-settings" title="<?php __('Toggle menu item settings'); ?>"><?php __($names->component, 'Toggle menu item settings', 'ucfirst') ?></a></li>
          <?php } ?>
          <li><a href="#" class="icon" id="detach-menu-item" style="display:none;"><?php __($names->component, 'Detach menu item from page', 'ucfirst') ?></a></li>
        </ul>
        <div class="clear"></div>
      </div>
      
      <div class="body clearfix">
        
        <fieldset class="menu_item_titles-wrapper">
          
          <?php tx('Language')->multilanguage(function($language)use($names){ ?>
            <div class="inputHolder">
              <label for="l_title_menu_item_<?php echo $language->id; ?>"><?php echo __($names->component, 'Menu item title',true).' '.__('IN_LANGUAGE_NAME',true).' '.__($language->title,true);  ?></label>
              <input class="big" type="text" id="l_title_menu_item_<?php echo $language->id; ?>" name="info[<?php echo $language->id; ?>][title]" value="{{if item && item.id > 0 && item.info['<?php echo $language->id; ?>']}}${item.info['<?php echo $language->id; ?>'].title}{{/if}}" />
            </div>
          <?php }); ?>
          
        </fieldset>
        
        <!-- Select menu -->
        <div class="inputHolder last">
          
          {{if menus.length > 1}}
          <label for="l_menu"><?php echo __('Menu'); ?></label>
          <select id="l_menu" name="menu_id">
            {{each menus}}
              {{if $index != 'length'}}
                <option value="${$value.id}"{{if $value.id == current_menu}}selected="selected"{{/if}}>${$value.title}</option>
              {{/if}}
            {{/each}}
          </select>
          {{else}}
          <input type="hidden" name="menu_id" value="${menus[0].id}" />
          {{/if}}
          
        </div>
        
        <!-- MENU ITEM CONFIG -->
        <div id="menu-item-config">

          <div class="inner">
            
            <h3><?php __($names->component, 'Menu item settings', 'ucfirst') ?></h3>
            
            <?php if(tx('Component')->available('media')){ ?>
              <fieldset>
                
                <div class="ctrlHolder">
                  <label for="menu_item_image"><?php __('Image'); ?></label><br />
                  <img id="menu_item_image" {{if item && item.image_id > 0}}src="<?php echo url(URL_BASE.'?section=media/image&resize=0/150&id=NULL'); ?>&id=${item.image_id}"{{else}}style="display:none;"{{/if}} />
                </div>
                
                <div class="ctrlHolder">
                  <input type="button" class="button grey delete-menu-item-image" value="<?php __($names->component, 'Delete image') ?>" {{if !item || item.image_id <= 0}}style="display:none;"{{/if}} />
                </div>
                
                <div class="ctrlHolder image_upload_holder">
                  <input type="hidden" id="l_menu_item_image_id" name="image_id" value="${item.image_id}" />
                </div>

              </fieldset>
            <?php } ?>

          </div>

        </div><!-- /#menu-item-config -->


        <div class="clear"></div>

      </div>
      
      <div class="footer">
        
        <input type="submit" id="save-menu-item" value="<?php __('Save'); ?>" />
        
      </div>
    
    </form>
    
  </div>
  
</script>
