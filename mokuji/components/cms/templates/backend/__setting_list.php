<?php namespace components\cms; if(!defined('MK')) die('No direct access.');

$table_def = array(
  __('Name', 1) => 'key',
  __('Default value', 1) => 'value_default'
);

tx('Language')->multilanguage(function($lang)use(&$table_def){
  $table_def[__($lang->title,1).' '.__('value',1)] = 'value_'.$lang->id;
});

$table_def[__('Actions', 1)] = array(
  function($row){return '<a class="edit" href="'.url('section=cms/setting_edit&setting_key='.$row->key, true).'">'.__('Edit', 1).'</a>';},
  function($row){return '<a class="delete" href="'.url('action=cms/delete_setting&setting_key='.$row->key).'">'.__('Delete', 1).'</a>';}
);

echo $data->as_table($table_def);

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
