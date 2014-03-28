<?php namespace components\cms; if(!defined('MK')) die('No direct access.');

echo $data->item->as_form($form_id, array(
  'address' => 'text'
));

?>

<script type="text/javascript">

$(function(){

  $('#<?php echo $form_id; ?>').on('submit', function(e){
    e.preventDefault();
    $(this).ajaxSubmit(function(data){
      $('#com-cms--ip-addresses').html(data);
    });
  });

});

</script>