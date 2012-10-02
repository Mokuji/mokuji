<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $page_list->as_table(array(
  __('Page title', 1) => 'title',
  __('Page type', 1) => function($page){ return $page->component_view->prefered_title; },
  __('Menu items', 1) => function($page_list){
    return $page_list->menu_items->map(function($mi){return $mi->title;})->join(htmlspecialchars(' | '));
  },
  __('actions', 1) => array(
    function($page_list){return '<a class="edit" href="'.url('pid='.$page_list->id, true).'">'.__('edit', 1).'</a>';},
    function($page_list){return '<a class="delete" href="'.url('action=cms/delete_page&page_id='.$page_list->id).'">'.__('delete', 1).'</a>';}
  )
)); ?>

<script type="text/javascript">
  $(function(){
    
    $('#tab-pages a.edit').click(function(e){

      e.preventDefault()
      
      $.ajax({
        url: $(this).attr('href'),
        data: {
          section: 'cms/app'
        },
        success: function(d){
          $('#page-main-right').html(d);
        }
      });
      
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
    
  });
</script>
