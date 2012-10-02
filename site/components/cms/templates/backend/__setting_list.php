<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $data->as_table(array(
  __('key', 1) => 'key',
  __('value', 1) => 'value',
  __('actions', 1) => array(
    function($row){return '<a class="edit" href="'.url('section=cms/setting_edit&setting_id='.$row->id, true).'">'.__('edit', 1).'</a>';},
    function($row){return '<a class="delete" href="'.url('action=cms/delete_setting&setting_id='.$row->id).'">'.__('delete', 1).'</a>';}
  )
));

?>


<script type="text/javascript">

$(function(){

  $('#com-cms--settings a.edit').on('click', function(e){

    e.preventDefault()
    
    $.ajax({
      url: $(this).attr('href')
    }).done(function(data){
      $('#com-cms--settings').html(data);
    });
    
  });

  $('#com-cms--settings a.delete').on('click', function(e){

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