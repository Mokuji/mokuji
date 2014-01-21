<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected function create_profiles($data, $sub_routes)
  {
    
    $model = mk('Sql')->model('backup', 'Profiles')
      ->set($data)
      ->validate_model();
    
    //Check for duplicates.
    mk('Sql')->table('backup', 'Profiles')
      ->pk("'{$data->name}'")
      ->count()->validate('Duplicate profile count', array('boolean'))
      ->is('true', function()use($data){
        $vex = new \exception\Validation('Duplicate entry, '.$data->name);
        $vex->key('name');
        $vex->errors(array('Duplicate entry'));
        throw $vex;
      });
    
    return $model->save();
    
  }
  
  protected function update_profiles($data, $sub_routes)
  {
    
    return mk('Sql')->model('backup', 'Profiles')
      ->set($data)
      ->validate_model()
      ->save();
    
  }
  
  protected function delete_profiles($data, $sub_routes)
  {
    
    return mk('Sql')->table('backup', 'Profiles')
      ->pk("'{$data->name}'")
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\NotFound('No profile with this name.');
      })
      ->delete();
    
  }
  
  protected function get_execute_profile($options, $sub_routes)
  {
    
    return array(
      'path' => $this->helper('backup_database', mk('Sql')->table('backup', 'Profiles')->pk("'".$sub_routes->{0}."'")->execute_single())
    );
    
  }
  
}
