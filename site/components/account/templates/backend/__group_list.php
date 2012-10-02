<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

// echo load_plugin('jquery_datatables');

?>

<div id="group-table">

<?php

echo $data->as_table(array(
  __('Title', 1) => 'title',
  __('Description', 1) => 'description',
  __('Member count', 1) => function($row){ return $row->users->size(); },
  __('Actions', 1) => array(
    function($row){return '<a class="edit" href="'.url('section=account/edit_user_group&user_group_id='.$row->id).'">'.__('edit', 1).'</a>';},
    function($row){return '<a class="delete" href="'.url('action=account/delete_user_group&user_group_id='.$row->id).'">'.__('delete', 1).'</a>';}
  )
));

?>

</div>

<script type="text/javascript">

  $(function(){
    
    /* ---------- Edit/add group ---------- */
    $('#group-table .edit').on('click', function(e){
      
      e.preventDefault();
      
      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#tab-group").addClass('no-refresh').html(data);
        $('#tabber-group')
          .find('a')
            .trigger('click')
            .text("<?php __('Edit group'); ?>");
      });
      
    });
    
    /* ---------- Delete user ---------- */
    $('#group-table .delete').on('click', function(e){
      
      e.preventDefault();
      
      if(confirm("<?php __('Are you sure?'); ?>")){
        
        $(this).closest('tr').fadeOut();
        
        $.ajax({
          url: $(this).attr('href')
        });
      }
      
    });
    
  });
</script>
