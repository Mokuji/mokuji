<?php namespace components\cms; if(!defined('MK')) die('No direct access.');

echo load_plugin('jquery_datatables');

echo $page_list->as_table(array(
  __($names->component, 'Page title', 1) => 'preferred_title',
  __($names->component, 'Page type', 1) => function($page){ return $page->component_view->preferred_title; },
  __($names->component, 'Menu items', 1) => function($page_list){
    return $page_list->menu_items->map(function($mi){return $mi->title;})->join(htmlspecialchars(' | '));
  },
  __($names->component, 'Page note', 1) => function($row){ return $row->notes->split("\n")->{0}->trim(); },
  __('Actions', 1) => function($page_list){return
    '<a class="edit" href="'.url('pid='.$page_list->id, true).'" data-id="'.$page_list->id.'">'.__('Edit', 1).'</a>'.
    '<a class="delete" href="#" data-id="'.$page_list->id.'">'.__('Delete', 1).'</a>';
  }
));

?>

<script type="text/javascript">

$(function(){
  
  $('#tab-pages a.edit').click(function(e){
    app.Item.loadItemContents(false);
    app.Page.loadPageContents($(e.target).attr('data-id'));
    app.App.activate();
  });

  $('#tab-pages a.delete').click(function(e){
    
    //Prevent going to "#".
    e.preventDefault();
    
    //Canceled?
    if(!confirm('<?php __('Are you sure?'); ?>')){
      return;
    }
    
    //Get the ID.
    var id = $(this).id()
      , that = this;
    
    //Remove from the table.
    $(that).closest('tr').addClass('deleted');
    
    //Delete from server.
    request(DELETE, 'cms/page/'+id)
    
    //If successful, fade the row out.
    .done(function(data){
      $(that).closest("tr").fadeOut();
    })
    
    //If unsuccessful, bring the row back.
    .fail(function(){
      $(that).closest('tr').removeClass('deleted');
    });
    
  });
  

  $('.tx-table').dataTable({
    "bJQueryUI": true,
    "sPaginationType": "full_numbers",
    "aoColumnDefs": [
      { "bSortable": false, "aTargets": [ 3 ] }
    ]
  });


});

</script>
