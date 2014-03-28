<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'register' => 0,
      'welcome_user' => 0,
      'user_profile' => 1
    );
  
  protected function register($options)
  {
    
    return array(
      'logged_in' => mk('Account')->isLoggedIn(),
      'model' => mk('Sql')->model('account', 'Accounts'),
      'target_url' => $options->target_url->otherwise(url('pid=KEEP&menu=KEEP',true)->output),
      'captcha' => mk('Account')->isLoggedIn() ? '' : mk('Component')->helpers('security')->call('generate_captcha'),
      'captcha_reload' => mk('Account')->isLoggedIn() ? '' : mk('Component')->helpers('security')->call('reload_captcha_js')
    );
    
  }
  
  protected function welcome_user()
  {
    return tx('Data')->session->user;
  }
  
  protected function user_profile($options)
  {
    
    //set user_id if not given
    $options->user_id =
      ($options->user_id->get('int') > 0 ? $options->user_id->get('int') : mk('Account')->id);
    
    //Validate input.
    $options
      ->user_id->validate('User ID', array('required', 'number'))->back();
    
    //Get the user.
    $user = $this
      ->table('Accounts')
      ->join('UserInfo', $ai)
      ->select("$ai.avatar_image_id", 'avatar_image_id')
      ->select("$ai.name", 'name')
      ->select("$ai.preposition", 'preposition')
      ->select("$ai.family_name", 'family_name')
      ->pk($options->user_id)
      ->execute_single();
    
    //Check if the user is found.
    $user->is('empty', function(){
      throw new \exception\User('The given user ID is not found.');
    });
    
    #TODO: Check for permissions here.
    
    return array(
      'has_media' => mk('Component')->available('media'),
      'editable' => $options->user_id->get('int') === mk('Data')->session->user->id->get('int'),
      'need_old_password' => !mk('Account')->isAdmin(),
      'user' => $user,
      'options' => $options,
      'image_uploader' => !mk('Component')->available('media') ? '' :
        mk('Component')->modules('media')->get_html('image_uploader', array(
          'ids' => array(
            'main' => 'file-container',
            'header' => 'file-header',
            'drop' => 'file-drop',
            'filelist' => 'file-filelist',
            'upload' => 'file-upload',
            'browse' => 'file-browse'
          ),
          'auto_upload' => true,
          'callbacks' => array(
            'ServerFileIdReport' => 'plupload_avatar_image_id_report'
          )
        ))
    );
    
  }
  
}
