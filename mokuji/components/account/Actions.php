<?php namespace components\account; if(!defined('TX')) die('No direct access.');

use \components\account\classes\ControllerFactory as CF;
use \dependencies\account\ManagementTasks;

class Actions extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      
      'login' => 0,
      'register' => 0,
      'claim_account' => 0,
      'use_password_reset_token' => 0,
      
      'logout' => 1,
      'save_avatar' => 1,
      'edit_profile' => 1
      
    );
  
  protected function use_password_reset_token($data)
  {
          
    //Link to custom login page is available.
    if( mk('Config')->user()->login_page->not('empty')->get('bool') )
      $redirect_url = url(mk('Config')->user()->login_page.'&password_forgotten=token&token=KEEP', true);
    else
      $redirect_url = url('/admin/?password_forgotten=token&token=KEEP', true);
    
    mk('Url')->redirect($redirect_url);
    
  }
  
  protected function become_user($data)
  {
    
    $id = $data->user_id->get('int');
    
    mk('Attempting to become another user.', function()use($id){
      CF::getInstance()->Session->becomeUser($id);
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });
    
  }
  
  protected function login($data)
  {
    
    //Extract needed data.
    $data = $data->having('email', 'pass');
    
    //Wrap in exception handler.
    mk('Logging in.', function()use($data){
      
      //Use the Session controller to log the user in.
      CF::getInstance()->Session->loginUser(
        $data->email->get(),
        $data->password->get(),
        ($data->persistent->get('string') === '1')
      );

    })
    
    //Pass on the exception.
    ->failure(function($info){
      throw $info->exception;
    });
    
    //Build the URL and redirect.
    $prev = mk('Url')->previous();
    if($prev !== false) mk('Url')->redirect($prev);
    mk('Url')->redirect(url('email=NULL&pass=NULL', false, ($prev !== false)));

  }

  protected function logout($data)
  {
    
    mk('Logging out.', function(){
      CF::getInstance()->Session->logoutUser();
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });

  }

  protected function register($data)
  {
    
    mk('Registering a new account.', function()use($data){
      
      $data = $data->having('email', 'username', 'password');
      $data->merge(array('level' => 1));
      
      $user = \dependencies\account\ManagementTasks::createUser($data);
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
      
    });
    
    mk('Url')->redirect('email=NULL&username=NULL&password=NULL');
    
  }
  
  protected function edit_profile($data)
  {
    
    mk('Editing profile', function()use($data){
      
      //Validate input.
      $data = $data->having('id', 'avatar_image_id', 'username', 'password_old', 'password1', 'password2', 'name', 'preposition', 'family_name')
        ->id->validate('User ID', array('required', 'number', 'gt'=>0))->back();
      
      //Check if operation is allowed.
      //Must be admin or your account.
      if(!(mk('Account')->isAdmin() || mk('Account')->id === $data->id->get('int'))){
        throw new \exception\Authorisation('You\'re not allowed to edit this user profile.');
      }
      
      //Get the user object.
      $user = mk('Sql')->table('account', 'Accounts')
        ->pk($data->id)
        ->execute_single();
        
      //Get the user info object.
      $user_info = mk('Sql')->table('account', 'UserInfo')
        ->where('user_id', $data->id)
        ->execute_single();
      
      //Check if the user is found. This should not fail when the user is logged in,
      // but it could fail if you're an admin trying to edit a non-existing user.
      $user->is('empty', function(){
        throw new \exception\User('User with this ID is not found.');
      });
            
      //Validate password
      $data->password1->is('empty', function()use(&$data){
        
        //See if a password should have been given.
        if(mk('Component')->helpers('account')->should_claim())
          throw new \exception\Validation('You are required to set a new password.');
        
        //If no new password is given; un_set the password.
        $data->password1->un_set();
        $data->password2->un_set();
        $data->password_old->un_set();

      })->failure(function()use($user, &$data){

        $data
          ->password1->validate('New password', array('required', 'password'))->back()
          ->password2->validate('Confirm new password', array('required'))->back();

        //Check the passwords are equal.
        $data->password1->eq($data->password2)
          ->success(function()use($user, &$data){
            
            //See if we need an old password.
            if(!mk('Account')->isAdmin())
            {
              
              //See if we're using improved hashing.
              $user->hashing_algorithm->not('empty')
                
                //Use improved hashing.
                ->success(function()use($user, $data){
                  
                  //Apply salt, if any.
                  $spass = $user->salt->otherwise('')->get('string') . $data->password_old->get();
                  
                  //Apply hashing algorithm.
                  $hspass = mk('Security')->hash($spass, $user->hashing_algorithm);

                  //Compare hashes.
                  if($user->password->get() !== $hspass)
                    throw new \exception\Validation('Old password is incorrect.');
                  
                })
                
                //Use the old way.
                ->failure(function()use($user, $data){
                  
                  if(md5($data->password_old->get()) !== $user->password->get()){
                    throw new \exception\Validation('Old password is incorrect.');
                  }
                  
                })
                
              ;//END - password checking.
              
            }
            
            //UPDATED: 4 July 2012, by Beanow
            //Now defaults to the default hashing algorithm and salt settings defined by core-security.
            
            //Get salt and algorithm.
            $data->salt = mk('Security')->random_string();
            $data->hashing_algorithm = mk('Security')->pref_hash_algo();
            
            //Hash using above information.
            $data->password = mk('Security')->hash(
              $data->salt->get() . $data->password1->get(),
              $data->hashing_algorithm
            );
            
            //Unset password1 and password2.
            $data
              ->password1->un_set()->back()
              ->password2->un_set()->back()
              ->password_old->un_set()->back();
            
          })
          
          //If passwords are not equal, throw exception.
          ->failure(function(){
            throw new \exception\Validation('Passwords are not the same.');
          });
        
      });
      
      //Store data in database.
      $user->set(true, $data)->save();
      $user_info->merge($data->having('name', 'preposition', 'family_name'))->save();

      //See if we should claim the user.
      $user_info
        ->check_status('claimable', function($user_info){

          //Set status and unset claim key.
          $user_info
            ->set_status('claimed')
            ->claim_key->un_set()->back()
            ->save();
          
        });
            
    })
    
    //Show error message.
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    //Show notification.
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
    
    //Redirect.
    mk('Url')->redirect(url(($data->redirect_url->is_set() ? $data->redirect_url : 'id=NULL'), true));
    
  }
  
  protected function save_avatar($data)
  {

    //Check if operation is allowed.
    if(!(mk('Account')->isAdmin() || mk('Account')->id === $data->user_id->get('int'))){
      throw new \exception\Authorisation('You\'re not allowed to edit this user profile.');
    }
    
    tx($data->user_id->get('int') > 0 ? 'Updating an avatar.' : 'Adding a new avatar.', function()use($data){

      mk('Sql')->table('account', 'UserInfo')->pk($data->user_id)->execute_single()->is('empty')
        ->success(function($user_info)use($data){
          mk('Sql')->model('account', 'UserInfo')->set($data->having('avatar_image_id'))->save();
        })
        ->failure(function($user_info)use($data){
          $user_info->merge($data->having('avatar_image_id'))->save();
        });

    })

    ->failure(function($info){

      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    // mk('Url')->redirect('section=sevendays/project_list&project_id=NULL');
    
  }
  
  protected function deactivate_user($data)
  {
    $this->set_user_status($data->push('status', 'deactivated'));
  }

  protected function delete_user($data)
  {
    
    $uid = $data->user_id->validate('User #ID', array('required', 'number'));
    
    try{
      ManagementTasks::deleteUser($data->user_id);
    }
    catch(\exception $ex){
      set_status_header('500', $ex->getMessage());
      die($ex->getMessage());
    }
    exit;
    
  }
  
  //Note: do not provide integer statusses when using this function.
  //The validation converts it to strings.
  protected function set_user_status($data)
  {
    
    mk('Changing user-status.', function()use($data){
      
      //Validate input.
      $data = $data->having('user_id', 'status')
        ->user_id->validate('User #ID', array('required', 'number'))->back()
        ->status->validate('New User Status', array('required', 'string'))->back();
      
      //Set status.
      mk('Sql')
        ->table('account', 'UserInfo')
        ->pk($data->user_id)
      ->execute_single()
        ->set_status($data->status)
        ->save();
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    });
    
    mk('Url')->redirect('user_id=NULL&status=NULL');
    
  }
  
  protected function reset_password($data)
  {
    
    $this->helper('reset_password', $data->user_id)
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
   
    exit;
    
  }
  
  protected function claim_account($data)
  {
    
    mk('Claiming account.', function()use($data){
      
      //Validate input.
      $data = $data->having('id', 'claim_key')
        ->id->validate('User ID', array('required', 'number', 'gt'=>0))->back()
        ->claim_key->validate('Claim key', array('required', 'string'))->back();
      
      $user = mk('Sql')
        ->table('account', 'UserInfo')
        ->where('user_id', $data->id)
        ->execute_single();
      
      $error = false;
      
      //Check user is found.
      $user->is('empty', function()use(&$error){
        $error = true;
      });
      
      //Check if user is claimable.
      if(!$error){
        
        $user->check_status('not_claimable', function($user)use(&$error){
          $error = true;
        });
        
      }
      
      //Check the claim key is right.
      if(!$error){
        
        $user->claim_key->eq($data->claim_key)
        ->failure(function()use(&$error){
          $error = true;
        }); 
        
      }
      
      //Use identical error messages and send them from the same line of code.
      //To make finding claimable accounts impossible through this action.
      if($error !== false)
        throw new \exception\User('Claim is invalid.');
      
      //Don't claim the user in the database here.
      //Use mk('Component')->helpers('account')->should_claim() to check if the account should be claimed.
      //Then do the actual claiming when editing the user profile.
      
      //Get the account data.
      $account = $user->account;
      
      //Insert this login session in the database.
      mk('Sql')
        ->table('account', 'UserLogins')
        ->where('session_id', "'".mk('Session')->id."'")
        ->execute_single()
        ->is('empty', function()use($account, &$user_login){

          $user_login = mk('Sql')->model('account', 'UserLogins')
            ->set(array(
              'user_id' => $account->id,
              'session_id' => mk('Session')->id,
              'dt_expiry' => date('Y-m-d H:i:s', time() + (2 * 3600)), //2 hours to set your password.
              'IPv4' => mk('Data')->server->REMOTE_ADDR,
              'user_agent' => mk('Data')->server->HTTP_USER_AGENT,
              'date' => time()
            ))
            ->save();

        })->failure(function($row)use(&$user_login){
          $user_login = $row;
        });
      
      mk('Logging')->log('Account', $user_login->dt_expiry, date('Y-m-d H:i:s', time() + (2 * 3600)));
      
      //Set user in session.
      mk('Account')->setUserData($account->having('id', 'email', 'username', 'level'));
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
    
    mk('Url')->redirect('id=NULL&claim_key=NULL');
    
  }
  
  protected function send_mail($data)
  {
    
    throw new \exception\Deprecated();
    
  }
  
  protected function insert_user_groups($data)
  {
    
    mk('Creating user group.', function()use($data){
      
      //Store members, because validator will otherwise remove it.
      $members = $data->members;
      
      //Remove ID, because you don't need that when inserting.
      $data->id->un_set();
      
      //Save the data.
      $model = load_model('account', 'UserGroups');
      $group = $model::validated_create($data)
        ->save();
      
      //Set group members.
      mk('Component')->helpers('account')
        ->set_group_members($group->id, $members);
      
      return $group;
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
    
    mk('Url')->redirect('section=account/group_list');
    
  }
  
  protected function update_user_groups($data)
  {

    mk('Updating user group.', function()use($data){
      
      //Store members, because validator will otherwise remove it.
      $members = $data->members;
      
      //Further inforce validation to require ID.
      $data->id->validate('ID', array('required', 'number'=>'integer'));
      
      //Validate.
      $model = load_model('account', 'UserGroups');
      $data = $model::validate_data($data);
      
      //Make sure any unset fields are removed.
      string_if_null($data, 'description');
      
      //Merge data.
      $group = mk('Sql')
        ->table('account', 'UserGroups')
        ->pk($data->id)
        ->execute_single()
        ->is('empty', function(){
          throw new \exception\User('Could not update because no entry was found in the database with id %s.', $data->id);
        })
        ->merge($data)
        ->save();
      
      //Set group members.
      mk('Component')->helpers('account')
        ->set_group_members($group->id, $members);

      return $group;
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
    
    mk('Url')->redirect('section=account/group_list');
    
  }
  
  protected function delete_user_group($data)
  {
    
    mk('Deleting user group.', function()use($data){
      
      //Validate.
      $data = $data->having('user_group_id')
        ->user_group_id->validate('ID', array('required', 'number'=>'integer'))->back();;
      
      //Find record.
      return mk('Sql')
        ->table('account', 'UserGroups')
        ->pk($data->user_group_id)
        ->execute_single()
        ->is('empty', function(){
          throw new \exception\User('Could not delete because no entry was found in the database with id %s.', $data->id);
        })
        ->delete();
      
    })
    
    ->failure(function($info){
      mk('Controller')->message(array(
        'error' => $info->get_user_message()
      ));
    })
    
    ->success(function($info){
      mk('Controller')->message(array(
        'notification' => $info->get_user_message()
      ));
    });
    
    mk('Url')->redirect('section=account/group_list');
    
  }
  
  protected function cancel_import_users()
  {
    
    //If a tmp file is present, delete it.
    mk('Data')->session->account->import->file->is('set', function($file){
      @unlink($file->get());
    });
    
    //Clear all other session data, since we're quitting...
    mk('Data')->session->account->import->un_set();
    
    mk('Url')->redirect('section=account/import_users');
    
  }
  
}
