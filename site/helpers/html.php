<?php if(!defined('TX')) die('No direct access.');


function ul($items)
{
  
  if(is_data($items)) $items = $items->as_array();
  $return = '<ul>';

  foreach($items as $k => $v)
  {
    
    if(is_string($k)){
      $return .= li($k.ul((array)$v));
    }
    
    else{
      $return .= li($v);
    }
    
  }
  
  $return .= '</ul>';
  
  return $return;
  
}

function li($li)
{
  
  return "<li>$li</li>";
  
}

function form_buttons(){
  
  return
    '<div class="buttonHolder">'.
    '  <input class="primaryAction button black" type="submit" value="'.__('Save', 1).'" />'.
    '</div>';

}

