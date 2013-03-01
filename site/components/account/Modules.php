<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{

  protected function welcome_user()
  {
    return tx('Data')->session->user;
  }
  
  protected function user_profile($options)
  {
    
    //set user_id if not given
    $options->user_id =
      ($options->user_id->get('int') > 0 ? $options->user_id->get('int') : tx('Account')->user->id->get('int'));
    
    //Validate input.
    $options
      ->user_id->validate('User ID', array('required', 'number'))->back();
    
    //Get the user.
    $user = $this
      ->table('Accounts')
      ->join('UserInfo', $ai)
      ->select("$ai.avatar_image_id", 'avatar_image_id')
      ->select("$ai.username", 'username')
      ->select("$ai.name", 'name')
      ->select("$ai.preposition", 'preposition')
      ->select("$ai.family_name", 'family_name')
      ->pk($options->user_id)
      ->execute_single();
    
    //Check if the user is found.
    $user->is('empty', function(){
      throw new \exception\User('The given user ID is not found.');
    });
    
    //>>TODO Check for permissions here.
    
    return array(
      'has_media' => tx('Component')->available('media'),
      'editable' => $options->user_id->get('int') === tx('Data')->session->user->id->get('int'),
      'need_old_password' => tx('Account')->user->level->get('int') !== 2,
      'user' => $user,
      'options' => $options,
      'image_uploader' => !tx('Component')->available('media') ? '' :
        tx('Component')->modules('media')->get_html('image_uploader', array(
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
