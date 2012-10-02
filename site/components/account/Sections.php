<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected function edit_user()
  {
    
    return $this
      ->table('Accounts')
      ->join('UserInfo', $ui)
      ->select("$ui.name", 'name')
      ->select("$ui.preposition", 'preposition')
      ->select("$ui.family_name", 'family_name')
      ->pk(tx('Data')->get->user_id)
      ->execute_single();
    
  }
  
  protected function edit_user_group($options)
  {
    
    $options = tx('Data')->get->having('user_group_id')->merge($options->having('user_group_id'));
    
    $group = tx('Sql')
      ->table('account', 'UserGroups')
      ->pk($options->user_group_id)
      ->execute_single()
      ->is('empty', function(){
        return tx('Sql')
          ->model('account', 'UserGroups');
      });
    
    $members = $group->users->map(function($member){
      return $member->id;
    })->as_array();
    
    return array(
      'group' => $group,
      'users' => tx('Sql')
        ->table('account', 'Accounts', $AC)
        ->join('UserInfo', $UI)
          ->where("(`$UI.status` & (1|4))", '>', 0)
        ->execute($AC)
        ->map(function($user)use($group, $members){
          
          //Add their membership status for the group we're editing.
          $user->is_member->set(in_array($user->id->get(), $members));
          
          //Return the user.
          return $user;
          
        })
    );
    
  }
  
  protected function user_list()
  {
    
    return $this
      ->table('Accounts')
      ->join('UserInfo', $ui)
      ->select("$ui.status", 'status')
      ->where(tx('Sql')->conditions()
        ->add('1', array("(`$ui.status` & 1)", '1'))
        ->add('2', array("(`$ui.status` & 4)", '4'))
        ->combine('3', array('1', '2'), 'OR')
        ->utilize('3')
      )
      ->order('level', 'DESC')
      ->order('email')
      ->execute();
    
  }
  
  protected function group_list()
  {
    
    return tx('Sql')
      ->table('account', 'UserGroups')
      ->order('title')
      ->execute();
    
  }
  
  protected function compose_mail()
  {
    
    return array(
      'default_user_email' => $this
        ->table('Accounts')
        ->pk(tx('Data')->get->user_id)
        ->execute()
        ->map(function($node){ return $node->id->get('int'); }),
      'users' => $this
        ->table('Accounts')
        ->join('UserInfo', $ui)
        ->select("$ui.status", 'status')
        ->where("(`$ui.status` & (1|4))", '>', 0)
        ->execute()
    );
    
  }

  protected function login_form()
  {
    return array();
  }

  protected function profile()
  {
    return tx('Data')->session->user;
  }
  
  protected function import_users()
  {
    
    return array();
    
  }
  
  protected function execute_import_users()
  {
    
    return $this->helper('import_users', tx('Data')->post);
    
  }

}
