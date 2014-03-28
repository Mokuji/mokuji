<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'table__hcheck_permissions' => 0,
      'table__check_permissions' => 0,
      'should_claim' => 0
    );
  
  /**
   * Force a reset of the password of the user.
   *
   * @author Beanow
   * @param Integer/Array(Integer) $user_id The user id's to reset the password for.
   * @return \dependencies\UserFunction The user function in which the password is reset.
   */
  public function reset_password($user_id)
  {
    
    $that = $this;
    
    return tx('Resetting password', function()use($user_id, $that){
      
      tx('Logging')->log('Account', 'Reset password', 'Called with: '.Data($user_id)->dump());
      
      //Validate input.
      $user_id = Data($user_id)
        ->each(function($node){
          tx('Logging')->log('Account', 'Reset password', 'Validating for: '.$node);
          return Data($node)->validate('User ID', array('required', 'number', 'gt'=>0));
        });
      
      //Get the users.
      tx('Sql')
        ->table('account', 'Accounts')
        ->pk($user_id)
        ->execute()
        
        //Check users were found.
        ->is('empty', function(){
          tx('Logging')->log('Account', 'Reset password', 'No users found.');
          throw new \exception\User('No User found for this User ID.');
        })
        
        ->each(function($user){
          
          tx('Logging')->log('Account', 'Reset password', 'Init for user: '.$user->email->get('string'));
          
          //Create claim key.
          $claim_key = tx('Security')->random_string(10);
          
          //Set database values.
          $user
            ->password->set(null)->back()
            ->save()
              ->user_info
              ->claim_key->set($claim_key)->back()
              ->set_status('claimable')
              ->save();
          
          //Create various links.
          $links = Data(array(
            'for_link' => url('/', true)->output,
            'claim_link' => url('/?action=account/claim_account/get&id='.$user->id.'&claim_key='.$claim_key, true)->output,
            'unsubscribe_link' => url('/?action=account/unsubscribe/get&email='.urlencode($user->email->get('string')), true)->output
          ));

          $username = $user->username->otherwise($user->user_info->email);
          
          //Send the invitation email.
          if(tx('Component')->available('mail')){

            tx('Component')->helpers('mail')->send_fleeting_mail(array(
              'to' => array('name'=>$user->user_info->username->otherwise(''), 'email'=>$user->email),
              'subject' => __('Claim your account', 1),
              'html_message' => tx('Component')->views('account')->get_html('email_user_password_reset', $links->having('for_link', 'claim_link', 'unsubscribe_link')->merge(array('username' => $username)))
            ))
            
            ->failure(function($info){
              throw $info->exception;
            });
            
          }
          
          else{

            #TODO #BUG
            mail(
              $user->email,
              __('Invitation for', 1).': '.$data->for_title,
              tx('Component')->views('account')->get_html('email_user_invited', $data->having('for_link', 'for_title', 'claim_link', 'unsubscribe_link')->merge(array('username' => $username)))
            );
            
          }
          
          tx('Logging')->log('Account', 'Reset password', 'Succeeded for user '.$user->email->get('string').'.');

        });
      
    });
    
  }
  
  /**
   * Invite a new user to create an account.
   *
   * @author Beanow
   * @param String $data->username The username to give the user. Note: when claiming the user can change this.
   * @param Email $data->email The email address to send an invite to.
   * @param Int $data->level The user level to set the user.
   * @param String $data->for_title What to invite the user for. Example: 'Project Xtra Coolness'.
   * @param String $data->for_link The link to what to invite the user for. Example: '?page_id=1337'.
   * @return \dependencies\UserFunction The user function in which the invitation is sent.
   */
  public function invite_user($data)
  {
    
    return tx('Sending invitation', function()use($data){
      
      //Validate input.
      $data = Data(data_of($data))->having('username', 'email', 'level', 'for_title', 'for_link', 'name', 'preposition', 'family_name', 'comments')
        ->email->validate('Email', array('required', 'email'))->back()
        ->username->validate('Username', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->for_title->validate('For-title', array('required', 'string', 'no_html'))->back()
        ->for_link->validate('For-link', array('required'))->back()
        ->name->validate('Name', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->preposition->validate('Preposition', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->family_name->validate('Family name', array('string', 'between' => array(0, 30), 'no_html'))->back()
        ->comments->validate('Comments', array('string', 'no_html'))->back();
      
      //Check if the user is already created.
      $duplicates = tx('Sql')
        ->table('account', 'Accounts')
        ->where('email', $data->email)
        ->join('UserInfo', $UI)
        ->where("(`$UI.status` & (1 | 4))", '>', 0) //activated or claimable
      ;
      
      if($duplicates->count()->get('int') > 0){
        tx('Logging')->log('Duplicate invite for id '.$duplicates->execute_single()->id);
        return $duplicates->execute_single();
        throw new \exception\User('A user with this email address has already been created.');
      }
      
      //Create the user in the core tables.
      $user = tx('Sql')
        ->model('account', 'Accounts')
        ->email->set($data->email->get('string'))->back()
        ->username->set($data->username)->back()
        ->password->set(null)->back()
        ->level->set($data->level->otherwise(1))->back()
        ->save();
      
      //Create claim key.
      $data->claim_key = tx('Security')->random_string(10);
      
      //Store additional info in the account tables.
      tx('Sql')
        ->model('account', 'UserInfo')
        ->merge($data->having('name', 'preposition', 'family_name', 'comments'))
        ->user_id->set($user->id)->back()
        ->claim_key->set($data->claim_key)->back()
        ->set_status('reclaim')
        ->save();
      
      //Create various links.
      $data->for_link = url($data->for_link->get('string'), true)->output;
      $data->claim_link = url('/?action=account/claim_account/get&id='.$user->id.'&claim_key='.$data->claim_key, true)->output;
      $data->unsubscribe_link = url('/?action=account/unsubscribe/get&email='.urlencode($user->email->get('string')), true)->output;
      
      //Send the invitation email.
      if(tx('Component')->available('mail')){
        
        tx('Component')->helpers('mail')->send_fleeting_mail(array(
          'to' => array('name'=>$data->username->otherwise(''), 'email'=>$user->email),
          'subject' => __('Invitation for', 1).': '.$data->for_title,
          'html_message' => tx('Component')->views('account')->get_html('email_user_invited', $data->having('email', 'for_link', 'for_title', 'claim_link', 'unsubscribe_link'))
        ))
        
        ->failure(function($info){
          throw $info->exception;
        });
        
      }
      
      else{
        
        mail(
          $user->email,
          __('Invitation for', 1).': '.$data->for_title,
          tx('Component')->views('account')->get_html('email_user_invited', $data->having('for_link', 'for_title', 'claim_link', 'unsubscribe_link'))
        );
        
      }
      
      return $user;
      
    });
    
  }
  
  /**
   * Create a new user.
   *
   * @author Beanow
   * @param Email $data->email The email address for the new user.
   * @param String $data->username The username for the new user.
   * @param String $data->password The password for the new user.
   * @param int $data->level The user level to set for the new user (1 or 2).
   * @return \components\account\models\Accounts The account of the newly created user.
   */
  public function create_user($data)
  {
    
    //Validate input.
    $data = $data->having('email', 'username', 'password', 'level', 'name', 'preposition', 'family_name', 'comments')
      ->email->validate('Email address', array('required', 'email'))->back()
      ->password->validate('Password', array('string', 'password'))->back()
      ->username->validate('Username', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->level->validate('User level', array('required', 'number', 'between' => array(1, 2)))->back()
      ->name->validate('Name', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->preposition->validate('Preposition', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->family_name->validate('Family name', array('string', 'between' => array(0, 30), 'no_html'))->back()
      ->comments->validate('Comments', array('string', 'no_html'))->back();
    
    //UPDATED: 28 June 2012, by Beanow
    //Now defaults to the default hashing algorithm and salt settings defined by core-security.
    
    //Get salt and algorithm.
    $data->salt = tx('Security')->random_string();
    $data->hashing_algorithm = tx('Security')->pref_hash_algo();
    
    //Hash the password.
    $data->password->set(tx('Security')->hash(
      $data->salt->get() . $data->password->get(),
      $data->hashing_algorithm
    ));
    
    /* ## No longer using this since 28 June 2012 ##
    //For now we do the ugly thing... ¬_¬
    //But using the data function so it will DIE straight away once it's deprecated.
    $data->password = $data->password->md5();
    */
    
    //Check if the user is already created.
    if(tx('Sql')->table('account', 'Accounts')->join('UserInfo', $ui)->where('email', $data->email)->where("(`$ui.status` & (1|4))", '>', 0)->count()->get('int') > 0){
      return tx('Sql')->table('account', 'Accounts')->join('UserInfo', $ui)->where('email', $data->email)->where("(`$ui.status` & (1|4))", '>', 0)->execute_single();
      // throw new \exception\User('A user with this email address has already been created.');
    }
    
    //Create the user in the core tables.
    $user = tx('Sql')
      ->model('account', 'Accounts')
      ->set($data->having('email', 'username', 'password', 'salt', 'hashing_algorithm', 'level'))
      ->save();
    
    //Store additional info in the account tables.
    tx('Sql')
      ->model('account', 'UserInfo')
      ->set($data->having('name', 'preposition', 'family_name', 'comments')->merge($user->having(array('user_id'=>'id')))->merge(array('status'=>1)))
      ->save();

    //Return the user model.
    return $user;
    
  }
  
  /**
   * Whether the logged in user should claim their account or not.
   *
   * @author Beanow
   * @return Boolean Whether the logged in user should claim their account or not.
   */
  public function should_claim()
  {
    
    $user_info = $this->table('UserInfo')
      ->pk(mk('Account')->id)
      ->execute_single();
    
    //If there's no user info found for the logged in user then return false.
    if(!$user_info->is_set())
      return false;
    
    $should_claim = false;
    
    //Check the user status is claimable.
    $user_info->check_status('claimable')
    ->success(function()use(&$should_claim){
      //If it is then check if the user is logged in.
      $should_claim = mk('Account')->isLoggedIn();
    });
    
    return $should_claim;
    
  }
  
  public function set_group_members($group_id, $members)
  {
    
    raw($group_id, $members);
    
    //Could have been an empty data object.
    $skip = $members === null;
    
    //Validate.
    if(!is_int($group_id))
      throw new \exception\InvalidArgument('Group ID must be an integer.');
    
    if(!$skip && !is_array($members))
      throw new \exception\InvalidArgument('Members must be an array.');
    
    //If there are members provided.
    if(!$skip || count($members) > 0)
    {
      
      //Remove all members not in the list.
      //Like a pro bouncer.
      tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->where('user_id', '!', $members)
        ->execute()
        ->each(function($member){
          $member->delete();
        });
      
      //Find the members that were already inside.
      $alreadyMember = tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->where('user_id', $members)
        ->execute()
        ->map(function($member){
          return $member->user_id->get();
        })
        ->as_array();
      
      //Check the member list again.
      foreach($members as $member){
        
        //For the ones already inside you can just skip them.
        if(in_array($member, $alreadyMember))
          continue;
        
        //For anyone else, invite them in!
        tx('Sql')
          ->model('account', 'AccountsToUserGroups')
          ->set(array(
            'user_id' => $member,
            'user_group_id' => $group_id
          ))
          ->save();
        
      }
      
    }
    
    //If there are no members provided.
    else
    {
      
      //Just remove them all.
      tx('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_group_id', $group_id)
        ->execute()
        ->each(function($member){
          $member->delete();
        });
      
    }
    
  }

  public function get_new_users($limit = 5)
  {
    return $this->table('Accounts')->join('UserInfo', $info)->select("$info.name", 'name')->limit($limit)->execute();
  }
  
  public function import_users($data)
  {
    
    $that = $this;
    return tx('Importing users', function()use($data, $that){
      
      tx('Validating input', function()use($data){
        
        $data = $data->having('overrides', 'retry', 'collumn_name', 'delimiter', 'user_group')
          ->overrides->validate('Overrides', array('array'))->back()
          ->collumn_name->validate('Collumn names', array('array'))->back()
          ->delimiter->validate('CSV delimiter', array('string', 'length'=>1))->back()
          ->user_group->validate('User groups', array('array'))->back();
        
        //Set the user groups if there are any.
        $data->user_group->is('set', function($user_group){
          tx('Data')->session->account->import->user_group->set($user_group->as_array());
        });
        
      })
      
      //If data is not ok, push an error.
      ->failure(function($userfunction){
        
        //Set this as failure.
        $ex = new \exception\Validation("");
        $ex->errors(array(array(
          'message' => $userfunction->get_user_message()
        )));
        $ex->value(false);
        throw $ex;
        
      });
      
      //Perform the import.
      $import = tx('CSV')
        ->import('account', 'users', $data->retry->is_set())
        ->initialize_source_file($data->delimiter->get('string'))
        ->process_import_data('Accounts', $data->collumn_name, array(
          'unique_fields' => array('email', 'username'),
          'overrides' => $data->overrides->as_array()
        ));
      
      //Check for errors.
      $errors = $import->errors();
      if(count($errors) > 0){
        
        //Set this as recoverable error.
        $ex = new \exception\Validation("");
        $ex->errors($errors);
        $ex->value(true);
        throw $ex;
        
      }
      
      //Go over the users.
      $import->resultset()->each(function($user)use($that){
        
        tx('Logging')->log('Account', 'User import', 'Inviting user '.$user->email);
        
        //Invite them.
        tx('Component')->helpers('account')->invite_user($user->merge(array(
          'for_link' => url('pid=1', true)->output,
          'for_title' => 'Import testing'
        )))
          
          ->failure(function($ufu){
            trace($ufu->get_user_message(), $ufu->exception);
          })
          
          ->success(function($ufu)use($that){
            
            //Make them members of the right groups.
            $that->helper('set_user_group_memberships', Data(array(
              'user_group' => tx('Data')->session->account->import->user_group,
              'user_id' => $ufu->return_value
            )));
            
          });
        
      });
      
      return $import->resultset();
      
    });
    
  }
  
  /**
   * Sets the user group memberships for an account.
   *
   * @author Beanow
   * data >> user_group, user_id
   */
  public function set_user_group_memberships($data)
  {
    
    //Set the proper groups.
    if($data->user_group->size() > 0)
    {
      
      //Go over each user group.
      tx('Sql')
        ->table('account', 'UserGroups')
        ->execute()
        ->each(function($usergroup)use($data){
          
          //When we're a part of this group.
          if($data->user_group->offsetExists($usergroup->id))
          {
            //See if there is already an entry for this group.
            tx('Sql')
              ->table('account', 'AccountsToUserGroups')
              ->where('user_id', $data->user_id)
              ->where('user_group_id', $usergroup->id)
              ->count()
              
              //If not, then insert it now.
              ->lt(1, function()use($usergroup, $data){
                tx('Sql')
                  ->model('account', 'AccountsToUserGroups')
                  ->set(array(
                    'user_id' => $data->user_id->get(),
                    'user_group_id' => $usergroup->id->get()
                  ))
                  ->save();
                
              });
            
          }
          
          //When we're not a part of this group.
          else
          {
            //See if there is already an entry for this group.
            tx('Sql')
              ->table('account', 'AccountsToUserGroups')
              ->where('user_id', $data->user_id)
              ->where('user_group_id', $usergroup->id)
              ->execute_single()
              
              //If there is, delete it.
              ->not('empty', function($usergroup){
                $usergroup->delete();
              });
            
          }
          
        });
      
    }
    
    //When there are no user groups provided.
    else
    {
      //Just remove all of them.
      mk('Sql')
        ->table('account', 'AccountsToUserGroups')
        ->where('user_id', $data->user_id)
        ->execute()
        ->each(function($usergroup){
          $usergroup->delete();
        });
      
    }
    
  }
  
  //Checks permissions on hierarchies.
  public function table__hcheck_permissions(\dependencies\Table $table, $meta, $user_id=null)
  {
    
    $meta = Data($meta)->having('access_level_field', 'group_permissions_join', 'user_group_id_field');
    
    //Get the user info we need.
    if($user_id == null || (int)$user_id === mk('Account')->id){
      $user_id = mk('Account')->id;
      $user_level = mk('Account')->level;
    }
    
    elseif($user_id > 0){
      $user_id = (int)$user_id;
      $user_level = mk('Sql')
        ->table('account', 'Accounts')
        ->pk($user_id)
        ->execute_single()
        ->level->otherwise(0)->get('int');
    }
    
    else{
      $user_id = null;
      $user_level = 0;
    }
    
    //Make the query depending on the user level.
    switch($user_level){
      
      //Visitors can only see when access level is 0.
      case 0:
        //Create the table conditions.
        $table
          ->join('__CURRENT__', $IC, function($S, $T, $conditions)use($meta){
            
            $conditions
              
              //Must be parent or self.
              ->add('parents_or_self_lft', array("`$S.lft`", '>=', "`$T.lft`"))
              ->add('parents_or_self_rgt', array("`$S.lft`", '<', "`$T.rgt`"))
              
              //Access level is 0-1, means any user can see, regardless of groups.
              ->add('logged_in_users', array("`$T.{$meta->access_level_field}`", '>', 0))
              
              //Put it together.
              ->combine('invalid_user_level', array('parents_or_self_lft', 'parents_or_self_rgt', 'logged_in_users'), 'AND')
              ->utilize('invalid_user_level');
            
          })
          ->where("`$IC.{$meta->access_level_field}`", null);
        break;
      
      //Normal users are more complex, because... user groups.
      case 1:
        
        //Find the user's groups.
        $groups = Data();
        tx('Sql')
          ->table('account', 'AccountsToUserGroups')
          ->where('user_id', $user_id)
          ->execute()
          ->each(function($link)use($groups){
            $groups->push($link->user_group_id->get());
          });
        
        //Create the table conditions for just logged in users.
        $table
          ->join('__CURRENT__', $IC, function($S, $T, $conditions)use($meta){
            
            $conditions
              
              //Must be parent or self.
              ->add('parents_or_self_lft', array("`$S.lft`", '>=', "`$T.lft`"))
              ->add('parents_or_self_rgt', array("`$S.lft`", '<', "`$T.rgt`"))
              
              //Access level is 0-1, means any user can see, regardless of groups.
              ->add('logged_in_users', array("`$T.{$meta->access_level_field}`", '>', 1))
              
              //Put it together.
              ->combine('invalid_user_level', array('parents_or_self_lft', 'parents_or_self_rgt', 'logged_in_users'), 'AND')
              ->utilize('invalid_user_level');
            
          });
        
        //Depending on whether we have usergroups, also look for matches there.
        if($groups->size() > 0){
          
          $local = $meta->group_permissions_join->{0};
          $foreign = $meta->group_permissions_join->{2};
          
          //Group up with the permission groups too and find authorization paths.
          //But only when the access_level == 2.
          $table->distinct()
            ->join($meta->group_permissions_join->{1}, $VG, function($S, $T, $conditions)use($meta, $groups, $local, $foreign){
              
              $conditions
                
                //Must be tied to invalid categories.
                ->add('to_ics', array("`$S.$local`", "`$T.$foreign`"))
                
                //Access level is 2, means any user can only see, when in one of the right groups.
                ->add('in_my_groups', array("`$T.{$meta->user_group_id_field}`", 'IN', $groups))
                
                //Put it together.
                ->combine('valid_group_paths', array('to_ics', 'in_my_groups'), 'AND')
                ->utilize('valid_group_paths');
                
            });
          
          //Now that we have the data, set the conditions.  
          $table->where(tx('Sql')->conditions()
            ->add('empty_ics', array("`$IC.{$meta->access_level_field}`", null))
            ->add('is_group_access', array("`$IC.{$meta->access_level_field}`", 2))
            ->add('has_valid_groups', array("`$VG.$foreign`", '!', null))
            ->combine('has_group_access', array('is_group_access', 'has_valid_groups'), 'AND')
            ->combine('has_access', array('has_group_access', 'empty_ics'), 'OR')
            ->utilize('has_access')
          );
          
        }
        
        //When no groups are involved, just check for invalid categories not being there.
        else{
          $table->where("`$IC.{$meta->access_level_field}`", null);
        }
        
        break;
      
      //Admins can see everything! (Including the future.)
      case 2:
        break;
      
    }
    
  }
  
  //Checks permissions on individual items.
  public function table__check_permissions(\dependencies\Table $table, $access_level, $group_id, $user_id=null)
  {
    
    raw($access_level, $group_id, $user_id);
    
    //Get the user info we need.
    if($user_id == null || (int)$user_id === mk('Account')->id){
      $user_id = mk('Account')->id;
      $user_level = mk('Account')->level;
    }
    
    elseif($user_id > 0){
      $user_id = (int)$user_id;
      $user_level = mk('Sql')
        ->table('account', 'Accounts')
        ->pk($user_id)
        ->execute_single()
        ->level->otherwise(0)->get('int');
    }
    
    else{
      $user_id = null;
      $user_level = 0;
    }
    
    //Make the query depending on the user level.
    switch($user_level){
      
      //Visitors can only see when access level is 0.
      case 0:
        $table->where($access_level, 0);
        break;
      
      //Normal users are more complex, because... user groups.
      case 1:
        
        //Find the user's groups.
        $groups = Data();
        tx('Sql')
          ->table('account', 'AccountsToUserGroups')
          ->where('user_id', $user_id)
          ->execute()
          ->each(function($link)use($groups){
            $groups->push($link->user_group_id->get());
          });
        
        //Create the table conditions.
        $table->where(tx('Sql')->conditions()
          
          //Access level is 1, means any user can see, regardless of groups.
          ->add('logged_in_users', array($access_level, '<=', 1))
          
          //Access level 2 means we need to be in the right group.
          ->add('group_check_level', array($access_level, 2))
          ->add('in_group', array($group_id, 'IN', $groups))
          ->combine('group_member', array('group_check_level', 'in_group'), 'AND')
          
          //Combine these scenario's.
          ->combine('can_see', array('logged_in_users', 'group_member'), 'OR')
          
          //Depending on whether the user is in any groups at all, pick either the logged in user scenario only, or both.
          ->utilize($groups->size() > 0 ? 'can_see' : 'logged_in_users')
          
        );
        break;
      
      //Admins can see everything! (Including the future.)
      case 2:
        break;
      
    }
    
  }
  
}
