<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

echo $data->group->as_form($id, array(
  'id' => array('type' => 'hidden', 'label'=>'ID'),
  'title' => array('label' => 'Title'),
  'description' => array('label' => 'Description'),
  'members' => array(
    'label' => 'Group members',
    'custom_field' => true,
    'type' => 'custom',
    'custom_html' =>
      '<select id="members" name="members[]" class="comboselect" multiple="multiple">'.n.
        $data->users->map(function($user){
          return '<option value="'.$user->id.'"'.($user->is_member->is_true() ? ' selected="selected"' : '').'>'.$user->user_info->full_name->otherwise($user->email).'</option>';
        })->join(n).n.
      '</select>'
  )
));

?>
<script type="text/javascript">
$(function(){
  
  //Create comboselects.
  $('#<?php echo $id; ?>')
    .find('select.comboselect')
    .comboselect({});
  
});
</script>
