<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<script id="edit_page_tmpl" type="text/x-jquery-tmpl">
    
  <div id="edit_page" class="has-languages">
    
    <div class="title-bar page-title">
      <h2><span class="title">${page.title}</span> <span style="font-weight:normal;">(<?php __('Page', 0, 'l'); ?>)</span></h2>
      <ul class="title-bar-icons clearfix">
        {{if menu_id}}
          <li><a href="?action=cms/detach_page&menu=${menu_id}&pid=${page.id}" class="icon detach-page" id="detach-page" title="<?php __($names->component, 'Detach page from menu item'); ?>">Detach</a></li>
        {{/if}}
      </ul>
      <div class="clear"></div>
    </div>
    
    <div id="page-languages" class="language-bar" data-id="<?php echo tx('Language')->get_language_id(); ?>" data-iln="<?php __('IN_LANGUAGE_NAME'); ?>">
      <a href="#" class="language" data-id="1" data-code="nl_NL" data-shortcode="NL" data-title="Nederlands">Nederlands</a>
      <a href="#" class="language" data-id="2" data-code="en_GB" data-shortcode="EN" data-title="Engels">Engels</a>
      <a href="#" class="language" data-id="3" data-code="de_DE" data-shortcode="DE" data-title="Duits">Duits</a>
    </div>
    
    <div id="page-tabs" class="tab-bar"></div>
    
    <div id="page-tab-body" class="tab-body"></div>
    
    <div class="footer" id="save-buttons">
      
      <button id="save-page" class="button black"><?php __('Save'); ?></button>
      
    </div>
    
  </div>
  
</script>

<script id="edit_page_config_tmpl" type="text/x-jquery-tmpl">
  <form id="page-config" class="form-inline-elements" method="PUT" action="<?php echo url('rest=cms/page/', true); ?>${page.id}">
    
    <fieldset class="fieldset-general clearfix">
      
      <legend><?php __($names->component, 'Reference'); ?></legend>
      
      <div class="inputHolder">
        <label for="l_title_page"><?php __($names->component, 'Page title'); ?></label>
        <input id="l_title_page" class="big" type="text" name="title" value="${page.title}" placeholder="<?php __($names->component, 'Page title') ?>" />
      </div>
      
      <?php if($data->layout_info->size() > 0){ ?>
        <div class="inputHolder last">
          <label for="l_layout"><?php echo __($names->component, 'Layout'); ?></label>
          <select name="layout_id" id="l_layout">
            <?php
            foreach($data->layout_info as $layout){
              echo '<option value="'.$layout->layout_id.'"{{if page.layout_id && page.layout_id == '.$layout->layout_id.'}}selected="selected"{{/if}}>'.$layout->title.'</option>';
            }
            ?>
          </select>
        </div>
      <?php } ?>
      
    </fieldset>
    
    <fieldset class="fieldset-display">
      
      <legend><?php __($names->component, 'PAGE_DISPLAY', 'ucfirst'); ?></legend>
      
      <div class="ctrlHolder">
        <label for="cf_site_layout"><?php __($names->component, 'Site layout'); ?></label>
        <select id="cf_site_layout" name="template_id">
          <?php
          foreach($data->templates as $template){
            echo '<option value="'.$template->id.'"{{if default_template && default_template == '.$template->id.'}}checked="checked"{{/if}}>'.$template->title.'</option>';
          }
          ?>
        </select>
      </div>
      
      <div class="ctrlHolder">
        <label for="cf_theme"><?php __($names->component, 'Theme'); ?></label>
        <select id="cf_theme" name="theme_id">
          <?php
          foreach($data->themes as $themes){
            echo '<option value="'.$themes->id.'"{{if default_theme && default_theme == '.$themes->id.'}}checked="checked"{{/if}}>'.$themes->title.'</option>';
          }
          ?>
        </select>
      </div>
      
    </fieldset>
    
    <fieldset class="fieldset-rights">
      
      <legend><?php __('User rights'); ?></legend>
      
      <?php __('Accessable to'); ?>:
      <ul>
        <li><label><input type="radio" name="access_level" value="0"{{if page.access_level <= 0}}checked="checked"{{/if}} /> <?php __('Everyone'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="1"{{if page.access_level == 1}}checked="checked"{{/if}} /> <?php __('Logged in users'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="2"{{if page.access_level == 2}}checked="checked"{{/if}} class="members" /> <?php __($names->component, 'Group members'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="3"{{if page.access_level == 3}}checked="checked"{{/if}} /> <?php __('Admins'); ?></label></li>
      </ul>
      
      <fieldset class="fieldset-groups"{{if page.access_level == 2}} style="display:block;"{{/if}}>
        
        <legend><?php __($names->component, 'Groups with access'); ?></legend>
        
        <ul>
          {{each permissions.group_permissions}}
            <li><label><input type="checkbox" name="user_group_permission[${$value.id}]" value="1"{{if $value.access_level > 0}}checked="checked"{{/if}} /> ${$value.title}</label></li>
          {{/each}}
        </ul>
        
      </fieldset>
      
    </fieldset>
    
  </form>
</script>
