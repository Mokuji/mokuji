<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

echo load_plugin('nestedsortable');
echo load_plugin('jquery_message');

?>

<script type="text/javascript">

  $(function(){

    $('ul.category_list').nestedSortable({
      disableNesting: 'no-nest',
      forcePlaceholderSize: true,
      handle: 'div',
      helper: 'clone',
      listType: 'ul',
      items: 'li',
      maxLevels: 3,
      opacity: .6,
      placeholder: 'placeholder',
      revert: 250,
      tabSize: 25,
      tolerance: 'pointer',
      toleranceElement: '> div'
    })
    
    .on('sortupdate', function(){
      
      $('.save').show();
      
    });

    $('.save').click(function(e){
      
      var target = this, message='Something went wrong.';
      
      e.preventDefault();
      
      $.ajax({
        url: $(target).attr('href'),
        type: 'POST',
        dataType: 'JSON',
        data: {
          menu_items: $('ul.category_list').nestedSortable('toArray', {startDepthCount: 0, attribute: 'rel', expression: (/()([0-9]+)/), omitRoot: true})
        }
      })
      
      .done(function(data){
        message = data.message;
        $(target).hide();
      })
      
      .then(function(){
        $('.message').text(message).show().delay(1000).fadeOut();
      });

    });

  });
    
</script>

<?php

//display list
echo $menu_item_list->as_hlist('category_list nestedsortable', function($cat, $key, $delta, &$properties){

  return
    '<div>'.
    '  <a class="category" href="'.url('cat='.$cat->id.'&section=gallery/item_list').'">'.$cat->title.'</a>'.
    '  <a href="'.url('action=gallery/category_delete&category_id='.$cat->id).'" class="small-icon icon-delete"></a>'.
    '</div>';
});

?>

<a href="<?php echo url('section=menu/edit_menu_item'); ?>" id="new-category"><?php __('New menu item'); ?></a>
<button class="save" hidden href="<?php echo url('section=menu/json_update_menu_items') ?>"><?php __('Save changes'); ?></button>
<div class="message"></div>


<style type="text/css">


/* =Nested sortable styles
-------------------------------------------------------------- */

  .nestedsortable .placeholder {
    background-color: #cfcfcf;
  }

  .nestedsortable .ui-nestedSortable-error {
    background:#fbe3e4;
    color:#8a1f11;
  }

  .nestedsortable,
  .nestedsortable ul{
    margin: 0;
    padding: 0;
    list-style-type: none;
  }
    .nestedsortable ul{
      padding-left: 30px;
    }
      .nestedsortable ul ul{
        padding-left: 60px;
      }
        .nestedsortable ul ul ul{
          padding-left: 90px;
        }

  .nestedsortable li{
    margin: 0 0 7px 0;
    padding: 0;
  }
    .nestedsortable li div{
      background:#E2E2E2;
      padding: 3px;
      margin:0;
      margin-bottom:2px;
      cursor: move;
    }

  .nestedsortable .notice {
    color: #c33;
  }


</style>
