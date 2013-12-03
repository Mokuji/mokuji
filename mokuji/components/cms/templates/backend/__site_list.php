<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $data->as_table(array(
  __($names->component, 'Site title', 1) => 'title',
  __($names->component, 'Domains', 1) => function($site){ return $site->domains->map(function($domain){ return $domain->domain; })->join(', '); },
  __($names->component, 'Path base', 1) => 'path_base',
  __($names->component, 'URL path', 1) => 'url_path',
  __('Actions', 1) => array(
    function($site){return '<a class="edit" href="'.url('section=cms/edit_site&site_id='.$site->id, true).'">'.__('Edit', 1).'</a>';},
    function($site){return '<a class="delete" href="'.url('action=cms/delete_site&site_id='.$site->id, true).'">'.__('Delete', 1).'</a>';}
  )
)); ?>

<script type="text/javascript">
  $(function(){
    
    $('#tab-sites a.edit').click(function(e){
      
      e.preventDefault()
      
      $('#tabber-edit-site')
        .show()
        .find('a')
          .trigger('click');
      
      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#tab-edit-site").html(data);
      });
      
    });

    $('#tab-sites a.delete').click(function(e){

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
