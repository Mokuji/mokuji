<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

// echo load_plugin('jquery_datatables');

?>

<div id="user-table">
<form class="form table-operations-container">
  <div class="buttonHolder">
    <select class="table-operations">
      <option class="op-none" value="op-none">-- <?php __($names->component, 'Perform action on selection'); ?> --</option>
      <option class="op-message" value="op-message"><?php __($names->component, 'Send email message to selection'); ?></option>
      <option class="op-activate" value="op-activate"><?php __($names->component, 'Send activation email to selection'); ?></option>
    </select>
  </div>
</form>

<?php

echo $user_list->as_table(array(
  '<input type="checkbox" class="select-all" />' => function($row){ return '<input type="checkbox" class="select-row" name="user_id[]" value="'.$row->id.'" />'; },
  __('Name', 1)                                  => function($row){ return $row->user_info->full_name->otherwise('-'); },
  __('Email address', 1)                         => 'email',
  __($names->component, 'Groups', 1)             => function($row){
    
    return $row->groups->map(function($group){
      return $group->title;
    })->join(', ')->otherwise('-');
    
  },
  __('Administrator', 1)                         => function($row){ return $row->is_administrator->get('boolean') ? __('ja', 1) : __('nee', 1); },
  __($names->component, 'Last login', 1)         => function($row)use($names){
    return ($row->last_login != '' ? $row->last_login : __($names->component, 'Never logged in', 1));
  },
  //__('Comments', 1) => function($row){ return $row->user_info->comments; },
  __('Actions', 1)                               => array(
    function($row){return '<a class="edit" href="'.url('section=account/edit_user&user_id='.$row->id).'">'.__('Edit', 1).'</a>';},
    function($row){return ($row->status->get('int') > 0 ? '<a class="delete" href="'.url('action=account/delete_user&user_id='.$row->id).'">'.__('Delete', 1).'</a>' : '');}
  )
));

?>

</div>

<script type="text/javascript">

  $(function(){

    // $('#user-table table').dataTable();
    
    //Bind the operations.
    $('#user-table ')
    
      /* ---------- Select all ---------- */
      .on('click', '.select-all', function(e){
        
        if($(this).attr('checked') == 'checked'){
          $('#user-table .tx-table .select-row:not(:checked)')
            .attr('checked', 'checked');
        }else{
          $('#user-table .tx-table .select-row:checked')
            .removeAttr('checked');
        }

      });

    /* ---------- Table operations ---------- */

    //Make a copy of the operations at the bottom of the table.
    $('.table-operations-container')
      .clone()
      .toggleClass('operations-bottom')
      .appendTo($('#user-table'));

    $('.table-operations-container')

      .on('change', '.table-operations', function(){
        
        switch($(this).val())
        {
          
          case 'op-none':
            return false;
          
          case 'op-message':
            
            var elements = $('#user-table .tx-table .select-row:checked');
            
            //Only if there are checkboxes checked.
            if(elements.size() <= 0)
              break;
            
            $('#tabs-accounts ul #tabber-mail').show().find('a').trigger('click');
            $("#tab-mail").html('<?php __("Loading"); ?>...');
            
            $.ajax({
              url: '<?php echo url("section=account/compose_mail"); ?>',
              data: elements.serializeArray()
            }).done(function(data){
              $("#tab-mail").html(data);
            });
            
            break;
          
          case 'op-activate':
            
            var elements = $('#user-table .tx-table .select-row:checked');
            
            //Only if there are checkboxes checked.
            if(elements.size() <= 0)
              break;
            
            if(confirm("<?php __('Are you sure?'); ?>")){
              
              $.ajax({
                url: '<?php echo url("action=account/reset_password"); ?>',
                data: elements.serializeArray()
              }).done(function(data){
                alert('Sent activation email to ' + elements.size() + ' users.');
              }).error(function(err){
                console.log(err);
                alert('Error sending activation email.');
              });
              
            }
            
            break;
          
        }
        
        //Switch back to op-none.
        $(this).val('op-none');
        
        return false;
        
      })
      
    ;//End event binding for .table-operations-container.
    
    
    /* ---------- Edit/add user ---------- */
    $('#tab-users .edit').on('click', function(e){

      e.preventDefault();

      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#tab-user").addClass('no-refresh').html(data);
        $('#tabber-user')
          .find('a')
            .trigger('click')
            .text("<?php __($names->component, 'Edit user'); ?>");
      });

    });

    /* ---------- Mail user ---------- */
    $('#tab-users .mail').on('click', function(e){

      e.preventDefault();

      $('#tabs-accounts ul #tabber-mail').show().find('a').trigger('click');

      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#tab-mail").html(data);
      });

    });
    
    /* ---------- Reset password ---------- */
    $('#tab-users .reset_password').on('click', function(e){

      e.preventDefault();

      if(confirm("<?php __('Are you sure?'); ?>")){
        $.ajax({
          url: $(this).attr('href')
        });
      }

    });
    
    /* ---------- Delete user ---------- */
    $('#tab-users .delete').on('click', function(e){

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
