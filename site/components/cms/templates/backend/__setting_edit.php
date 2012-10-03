<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $data->item->as_form($form_id, array(
  'id' => 'hidden',
  'site_id' => 'hidden',
  'autoload' => 'hidden'
));

?>

<script type="text/javascript">

$(function(){

  $('#<?php echo $form_id; ?>').on('submit', function(e){
    e.preventDefault();
    $(this).ajaxSubmit(function(data){
      $('#com-cms--settings').html(data);
    });
  });

});

</script>