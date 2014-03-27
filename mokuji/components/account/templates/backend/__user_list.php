<?php namespace components\account; if(!defined('TX')) die('No direct access.'); ?>

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

//First columns.
$cols = array(
  '<input type="checkbox" class="select-all" />' => function($row){ return
    '<input type="checkbox" class="select-row" name="user_id[]" value="'.$row->id.'" />'.n.
    '<input type="hidden" class="edit-url" data-edit="'.url('section=account/edit_user&user_id='.$row->id).'" />';
  },
  __('Name', 1)                                  => function($row){ return $row->user_info->full_name->otherwise('-'); },
  __('Email address', 1)                         => 'email'
);

//Only show column 'User groups' if there _are_ user groups.
if($data->num_user_groups->get() > 0) $cols = array_merge($cols, array(
  __($names->component, 'Groups', 1)             => function($row){
    
    return $row->groups->map(function($group){
      return $group->title;
    })->join(', ')->otherwise('-');
    
  }
));

//Shorthand
$yes = '<i class="fa fa-check icon-ok"></i>';
$no = '<i class="fa fa-times icon-remove"></i>';

//Last columns.
$cols = array_merge($cols, array(
  __('Active', 1) => function($row)use($yes,$no){ return $row->is_active->get('boolean') ? $yes : $no; },
  __('Banned', 1) => function($row)use($yes,$no){ return $row->is_banned->get('boolean') ? $yes : $no; },
  __('Admin', 1) => function($row)use($yes,$no){ return $row->is_administrator->get('boolean') ? $yes : $no; },
  // __('Claimable', 1) => function($row)use($yes,$no){ return $row->is_claimable->get('boolean') ? $yes : $no; },
  __($names->component, 'Last login', 1)         => function($row)use($names){
    return ($row->last_login != '' ? $row->last_login : __($names->component, 'Never logged in', 1));
  },
  __('Actions', 1)                               => array(
    function($row){return ('<a class="edit" href="javascript:;">'.__('Edit', 1).'</a>');},
    function($row){return ('<a class="delete" href="'.url('action=account/delete_user&user_id='.$row->id).'">'.__('Delete', 1).'</a>');}
  )
));

//Und jetzt: show le table.
echo $data->users->as_table($cols);

?>

</div>

<script type="text/javascript">

  $(function(){

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
    $('#tab-users .tx-table').on('click', 'td, .edit', function(e){
      
      //Only when you're not clicking something else.
      if(this !== e.target)
        return;
      
      e.preventDefault();
      
      var url = $(this).closest('tr').find('.edit-url').attr('data-edit');
      
      $.ajax(url)
      .done(function(data){
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

        var $row = $(this).closest('tr');

        $.ajax($(this).attr('href'))
          .done(function(){
            $row.fadeOut();
          })
          .error(function(xhr, state, message){
            alert(message);
          });
      }

    });
    
  });
</script>
