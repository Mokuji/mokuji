<?php namespace components\cms; if(!defined('MK')) die('No direct access.');

echo $data->item->as_form($form_id, array(
  'title'=>array('required'=>true),
  'domain'=>array('required'=>true),
  'path_base'=>array('required'=>true),
  'url_path'=>array('required'=>true)
));

?>

<script type="text/javascript">

$(function(){

  $('#<?php echo $form_id; ?>').on('submit', function(e){
    e.preventDefault();
    $(this).ajaxSubmit(function(data){
      
      $('#tab-sites')
        .html(data);
      
      $('#tabber-sites')
        .show()
        .find('a')
          .trigger('click');
      
    });
  });

});

</script>
