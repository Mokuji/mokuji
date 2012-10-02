<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  public function page_authorisation($pid)
  {
    
    //If we qualify, skip the rest.
    if($this->check_page_authorisation($pid))
      return;
    
    if(tx('Config')->user('login_page')->is_set()){
      $redirect = url(URL_BASE.'?'.tx('Config')->user('login_page'), true);
    }
    
    else{
      $redirect = url(URL_BASE.'?'.tx('Config')->user('homepage'), true);
    }
    
    if($redirect->compare(tx('Url')->url)){
      throw new \exception\User('The login page requires you to be logged in. Please contact the system administrator.');
    }
    
    tx('Url')->redirect($redirect);
    
  }
  
  public function check_page_authorisation($pid){
    
    //Contains which userlevel a page access level corresponds to.
    $baseLevels = array(
      
      //When nothing is required, check for nothing.
      0 => 0,
      
      //When login is required, check for userlevel 1.
      1 => 1,
      
      //When being part of the proper group is required only admins get passed without the group checks.
      2 => 2,
      
      //When admin is required, check for admin.
      3 => 2
      
    );
    
    //Get the page we're talking about.
    $return = NULL;
    $page = tx('Sql')
      ->table('cms', 'Pages')
      ->pk($pid)
      ->execute_single()
      ->is('empty', function()use(&$return){
        //TODO
        $return = false;
        // throw new \exception\InvalidArgument('No page found for this page ID.');
      });
      
    if($return !== NULL){
      return $return;
    }
    
    //If we have the right userlevel, return.
    if(tx('Account')->check_level($baseLevels[$page->access_level->get()])){
      return true;
    }
    
    //If we did not meet the right userlevel, only a group can save us now from being denied access.
    //Which is only when the page access level is set to 2 (logged in and part of a group which is allowed access).
    //But we must still have userlevel 1. Banned users can't have access even if they are part of a group. o_0
    if($page->access_level->get('integer') === 2 && tx('Account')->check_level(1)){
      
      //Find the groups that have access to this page.
      $allowedGroups = tx('Sql')
        ->table('cms', 'PageGroupPermissions')
        ->where('page_id', $page->id)
        ->where('access_level', '>=', '1')
        ->execute()
        ->map(function($row){
          return $row->user_group_id->get();
        });
      
      //Find if we're a member of any of those.
      $howMany = tx('Sql')
        ->table('account', 'UserGroups', $UG)
        ->pk($allowedGroups)
        ->join('AccountsToUserGroups', $ATUG)
          ->where("$ATUG.user_id", tx('Account')->user->id)
        ->count();
      
      //If there's one or more, we get to see the page.
      if($howMany->get('integer') >= 1) return true;
      
    }
    
    //Reaching this point we are not authorised.
    //We'll find where to redirect, or throw an exception.
    return false;
    
  }
  
  public function get_page_info($pid)
  {
    
    static $page_info = array();
    $pid = data_of($pid);
    
    if(array_key_exists($pid, $page_info)){
      return $page_info[$pid];
    }
    
    $return = Data();
    
    $result = tx('Sql')->table('cms', 'Pages', $p)
      ->pk($pid)
      ->join('Templates', $te)
      ->join('Themes', $th)
      ->join('ComponentViews', $cv)
      ->select("$te.name", 'template')
      ->select("$th.name", 'theme')
      ->select("$cv.name", 'view_name')
    ->workwith($cv)
      ->join('Components', $co)
      ->select("$co.name", 'component')
    ->execute_single();

    if($result->is_empty()){
      return false;
    }
    
    $page_info[$pid] = $result;
    
    return $result;
  
  }
  
  public function get_page_permissions($pid)
  {
    
    $page = tx('Sql')
      ->table('cms', 'Pages')
      ->pk($pid)
      ->execute_single();
    
    $userGroupPermissions = Data();
    
    //Get all the usergroups first.
    tx('Sql')
      ->table('account', 'UserGroups')
      ->select('0', 'access_level')
      ->execute()
      ->each(function($userGroup)use($userGroupPermissions){
        $userGroupPermissions->{$userGroup->id->get()}
          ->become($userGroup);
      });
    
    //Get all the access_levels.
    tx('Sql')
      ->table('cms', 'PageGroupPermissions')
      ->where("page_id", $page->id)
      ->execute()
      ->each(function($userGroupPermission)use($userGroupPermissions){
        $userGroupPermissions->{$userGroupPermission->user_group_id}
          ->access_level->set($userGroupPermission->access_level->get());
      });
    
    return Data(array(
      'page_access_level' => $page->access_level->get(),
      'group_permissions' => $userGroupPermissions
    ));
    
  }
  
  public function set_page_permissions($pid, $permissions)
  {
    
    raw($pid);
    $permissions = Data($permissions);
    $knownPermissions = Data();
    
    //Get known group permissions.
    tx('Sql')
      ->table('cms', 'PageGroupPermissions')
      ->where('page_id', $pid)
      ->execute()
      ->each(function($userGroupPermission)use(&$knownPermissions){
        $knownPermissions->{$userGroupPermission->user_group_id->get()}
          ->become($userGroupPermission);
      });
    
    //Go over all usergroups.
    tx('Sql')
      ->table('account', 'UserGroups')
      ->execute()
      
      //For each usergroup.
      ->each(function($userGroup)use($pid, $permissions, $knownPermissions){
        
        echo('Set permissions of '.$userGroup);
        trace($knownPermissions->{$userGroup->id}->dump());

        //Take it's known permission.
        $knownPermissions->{$userGroup->id}
          
          //Create a model if it's not in the known data.
          ->is('empty', function($permission)use($pid, $permissions, $userGroup){
            return tx('Sql')
              ->model('cms', 'PageGroupPermissions')
              ->set(array(
                'page_id' => $pid,
                'user_group_id' => $userGroup->id->get()
              ));
          })
          
          //Now set access_level and save.
          ->access_level->set($permissions->{$userGroup->id->get()}->otherwise(0))->back()
          ->save();
        
      });
    
  }
  
  /**
   * $options[]
   * @id: setting ID
   */
  public function get_settings()
  {

    $q =
      $this
      ->table('CmsConfig');

    if(is_numeric(tx('Data')->get->setting_id->get()))
    {
      $q = $q
      ->where('id', tx('Data')->get->setting_id)
      ->execute_single();
    }
    else
    {
      $q = $q->execute();
    }

    return $q;

  }

}
