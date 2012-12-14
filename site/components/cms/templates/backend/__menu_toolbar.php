<?php namespace components\cms; if(!defined('TX')) die('No direct access.');?>

<menu type="toolbar" class="menu-items-toolbar">
  
  <!-- The set of buttons for selecting different sites. -->
  <menu>
    
    <?php if($data->sites->size() > 1): ?>
      
      <li>
        <?php echo $data->sites->as_options('site_id', 'title', 'id', array(
          'id'=>'btn-select-site',
          'force_choice'=>true,
          'default'=>$data->site_id)
        ); ?>
      </li>
        
    <?php else: ?>
      
      <li><h3 class="site-title" title="<?php echo $data->sites->{0}->title; ?>"><?php echo $data->sites->{0}->title; ?></h3></li>
    
    <?php endif; ?>
    
    <li><a href="<?php echo url('view=cms/sites&menu=NULL&pid=NULL'); ?>" id="btn-edit-sites" title="<?php __('Manage sites'); ?>"><?php __('Manage sites'); ?></a></li>
  
  </menu>
  
  <!-- The set of buttons used to control the menu items. -->
  <menu>
    
    <li><a href="<?php echo url('section=cms/app&menu=0', true); ?>" id="btn-new-menu-item" title="<?php __('New menu item'); ?>"><?php __('New menu item'); ?></a></li>
    <li><a href="<?php echo url('section=cms/menu_item_list'); ?>" id="btn-refresh-menu-items" title="<?php __('Refresh menu items'); ?>"><?php __('Refresh menu items'); ?></a></li>
    <li class="menu-state" id="dropdown-menu">

      <a href="#" id="btn-save-menu-items"><?php __('Save menu items'); ?></a>
      <a href="#" id="user-message"><?php __('Saved successfully'); ?></a>

      <?php
      
      //Menu select.
      if($data->menus->size() > 1)
      {
        
        echo $data->menus->as_options('menu_id', 'title', 'id', array(
          'id'=>'btn-select-menu',
          'force_choice'=>true,
          'default'=>$data->menu_id
        ));
        
      }
      
      //If only one menu -> hide menu select box.
      elseif($data->menus->size() == 1){
        echo '<input type="hidden" name="menu_id" value="'.$data->menus->{0}->id.'">';
      }
      
      ?>

    </li>
    
  </menu>
  
  <div class="reset"></div>
    
</menu>


<script id="menu-item-list-item-tmpl" type="text/x-jquery-tmpl">
  <li class="depth_{{if depth}}${depth}{{else}}1{{/if}}" data-id="${id}" rel="${id}">
    <div>
      <a class="menu-item" data-page="{{if page_id}}${page_id}{{/if}}" data-menu-item="${id}" href="?menu=${id}&pid={{if page_id}}${page_id}{{/if}}&site_id=${site_id}">${title}</a>
      <span class="small-icon icon-delete"></span>
    </div>
    {{html subitems}}
  </li>
</script>
