<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<dl id="menu_dropdown" class="dropdown">
  <dt><a href="#<?php echo $menus->selected->id ?>"><span><?php echo $menus->selected->title ?></span></a></dt>
  <dd>
    <ul>
      <?php 
      foreach($menus->all AS $menu){
        echo '<li><a href="#'.$menu->id.'">'.$menu->title.'</a></li>';
      }
      ?>
      <li class="new_menu"><form><input type="text" value="" placeholder="<?php __($names->component, 'New menu'); ?>"></form></li>
    </ul>
  </dd>
</dl>
