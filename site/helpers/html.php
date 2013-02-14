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

function lipsum($count = 1, $return_only = false)
{

  $lipsum =
    str_repeat('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris. Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit. Donec et mollis dolor. Praesent et diam eget libero egestas mattis sit amet vitae augue. Nam tincidunt congue enim, ut porta lorem lacinia consectetur. Donec ut libero sed arcu vehicula ultricies a non tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut gravida lorem. Ut turpis felis, pulvinar a semper sed, adipiscing id dolor. Pellentesque auctor nisi id magna consequat sagittis. Curabitur dapibus enim sit amet elit pharetra tincidunt feugiat nisl imperdiet. Ut convallis libero in urna ultrices accumsan. Donec sed odio eros. Donec viverra mi quis quam pulvinar at malesuada arcu rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In rutrum accumsan ultricies. Mauris vitae nisi at sem facilisis semper ac in est.</p>', $count);

  if($return_only)
    return $lipsum;

  else
    echo $lipsum;

}
