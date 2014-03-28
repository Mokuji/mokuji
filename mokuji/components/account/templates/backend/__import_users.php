<?php namespace components\account; if(!defined('MK')) die('No direct access.');
$uid = tx('Security')->random_string(20);
?>

<form method="post" id="<?php echo $uid; ?>" action="<?php echo url('section=account/execute_import_users'); ?>" class="form import-users-form" enctype="multipart/form-data">
  
  <div class="explanation">
    <label><?php __($names->component, 'IMPORT_VERB', 'ucfirst'); ?></label>
    <p><?php __($names->component, 'IMPORT_EXPLANATION_P1'); ?></p>
    <p><?php __($names->component, 'IMPORT_EXPLANATION_P2'); ?></p>
    <p><?php __($names->component, 'IMPORT_EXPLANATION_P3'); ?></p>
  </div>
  
  <div class="ctrlHolder">
    <label for="l_file" accesskey="f"><?php __($names->component, 'CSV file'); ?></label>
    <input class="big large" type="file" accept="text/csv" id="l_file" name="file" required />
    <div class="comment"><?php __($names->component, 'EXCEL_SAVE_AS_CSV'); ?></div>
  </div>
  
  <div class="ctrlHolder">
    <label for="l_delimiter" accesskey="d"><?php __($names->component, 'CSV delimiter'); ?></label>
    <input class="big large" type="text" id="l_delimiter" name="delimiter" value=";" required />
  </div>
  
  <fieldset class="fieldset-user-groups">
    
    <legend><?php echo __($names->component, 'Member of groups'); ?></legend>
    
    <ul>
      <?php
      
      $usersGroups = $data->groups->map(function($group){
        return $group->id->get('string');
      })->as_array();
      
      tx('Sql')
        ->table('account', 'UserGroups')
        ->order('title')
        ->execute()
        ->each(function($group)use($usersGroups){
          echo '<li><label><input type="checkbox" name="user_group['.$group->id.']" value="1"'.(in_array($group->id->get(), $usersGroups) ? ' CHECKED' : '').' /> '.$group->title.'</label></li>'.n;
        });
      
      ?>
    </ul>
    
  </fieldset>
  
  <div class="ctrlHolder">
    <label><?php __($names->component, 'Column names'); ?></label>
    <table class="tx-table" style="width:auto;">
      <thead class="tx-table-head">
        <tr>
          <th><?php __($names->component, 'Database name'); ?></th>
          <th><?php __($names->component, 'CSV name'); ?></th>
        </tr>
      </thead>
      <tbody class="tx-table-body">
        <tr>
          <td><?php __('Email'); ?></td>
          <td><input type="text" name="collumn_name[email]" value="<?php __('Email'); ?>" required /></td>
        </tr>
        <tr>
          <td><?php __('Username'); ?></td>
          <td><input type="text" name="collumn_name[username]" value="<?php __('Username'); ?>" /></td>
        </tr>
        <tr>
          <td><?php __('First name'); ?></td>
          <td><input type="text" name="collumn_name[name]" value="<?php __('First name'); ?>" /></td>
        </tr>
        <tr>
          <td><?php __('Preposition'); ?></td>
          <td><input type="text" name="collumn_name[preposition]" value="<?php __('Preposition'); ?>" /></td>
        </tr>
        <tr>
          <td><?php __('Last name'); ?></td>
          <td><input type="text" name="collumn_name[family_name]" value="<?php __('Last name'); ?>" /></td>
        </tr>
        <tr>
          <td><?php __('Comments'); ?></td>
          <td><input type="text" name="collumn_name[comments]" value="<?php __('Comments'); ?>" /></td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <div class="buttonHolder">
    <input class="primaryAction button black" type="submit" value="<?php __($names->component, 'Import'); ?>" />
  </div>

</form>
