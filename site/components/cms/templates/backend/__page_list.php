<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo load_plugin('jquery_datatables');

echo $page_list->as_table(array(
  __($names->component, 'Page title', 1) => 'preferred_title',
  __($names->component, 'Page type', 1) => function($page){ return $page->component_view->preferred_title; },
  __($names->component, 'Menu items', 1) => function($page_list){
    return $page_list->menu_items->map(function($mi){return $mi->title;})->join(htmlspecialchars(' | '));
  },
  __($names->component, 'Page note', 1) => function($row){ return $row->notes->split("\n")->{0}->trim(); },
  __('Actions', 1) => array(
    function($page_list){return
      '<a class="edit" href="#" data-id="'.$page_list->id.'">'.__('Edit', 1).'</a>'.
      '<a class="delete" href="'.url('action=cms/delete_page&page_id='.$page_list->id).'">'.__('Delete', 1).'</a>';
    }
  )
)); ?>

<script type="text/javascript">

$(function(){
  
  $('#tab-pages a.edit').click(function(e){
    app.Item.loadItemContents(false);
    app.Page.loadPageContents($(e.target).attr('data-id'));
    app.App.activate();
  });

  $('#tab-pages a.delete').click(function(e){

    e.preventDefault()
    
    if(confirm('<?php __('Are you sure?'); ?>')){

      var that = $(this);
      $(that).closest('tr').addClass('deleted');

      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $(that).closest("tr").fadeOut();
      });
     
    }
    
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
