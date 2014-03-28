<?php namespace components\cms; if(!defined('MK')) die('No direct access.');

echo $data->as_table(array(
  __('Address', 1) => 'address',
  __($names->component, 'Login level', 1) => 'login_level',
  __('Actions', 1) => array(
    function($row){return '<a class="edit" href="'.url('section=cms/ip_edit&address='.$row->address, true).'">'.__('Edit', 1).'</a>';},
    function($row){return '<a class="delete" href="'.url('action=cms/delete_ip&address='.$row->address).'">'.__('Delete', 1).'</a>';}
  )
));

?>

<script type="text/javascript">

$(function(){

  $('#com-cms--ip-adresses a.edit').on('click', function(e){

    e.preventDefault()
    
    $.ajax({
      url: $(this).attr('href')
    }).done(function(data){
      $('#com-cms--ip-adresses').html(data);
    });
    
  });

  $('#com-cms--ip-adresses a.delete').on('click', function(e){

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
