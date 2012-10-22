<?php namespace components\cms; if(!defined('TX')) die('No direct access.');?>

<menu type="toolbar" class="menu-items-toolbar">

  <?php if($data->sites->size() > 1): ?>
    
    <!-- The set of buttons for selecting different sites. Only here when multiple sites are available. -->
    <menu>
    
      <li>
        <?php echo $data->sites->as_options('site_id', 'title', 'id', array(
          'id'=>'btn-select-site',
          'force_choice'=>true,
          'default'=>$data->site_id)
        ); ?>
      </li>
      <li><a href="<?php echo url('view=cms/sites&menu=NULL&pid=NULL'); ?>" id="btn-edit-sites"><?php __('Edit sites'); ?></a></li>
      
    </menu>
    
  <?php endif; ?>
  
  <!-- The set of buttons used to control the menu items. -->
  <menu>
    <li><a href="<?php echo url('section=cms/app&menu=0', true); ?>" id="btn-new-menu-item"><?php __('New menu item'); ?></a></li>
  </menu>
    
  <!-- The set of buttons used to save, refresh or revert the menu items. -->
  <menu>
  
    <li><a href="<?php echo url('section=cms/menu_item_list'); ?>" id="btn-refresh-menu-items"><?php __('Refresh menu items'); ?></a></li>
    <li class="menu-state" id="dropdown-menu">

      <a href="#" id="btn-save-menu-items"><?php __('Save menu items'); ?></a>
      <a href="#" id="user-message"><?php __('Saved successfully'); ?></a>

      <?php
      //Menu select.
      if($data->menus->size() > 1){
        echo $data->menus->as_options('menu_id', 'title', 'id', array(
          'id'=>'btn-select-menu',
          'force_choice'=>true,
          'default'=>$data->menu_id
        ));
      }elseif($data->menus->size() == 1){
        //If only one menu -> hide menu select box.
        echo '<input type="hidden" name="menu_id" value="'.$data->menus->{0}->id.'">';
      }
      ?>

    </li>
    
  </menu>
  
  <div class="reset"></div>
    
</menu>
