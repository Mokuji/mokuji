<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class ComponentViews extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_component_views',
  
    $relations = array(
      'Components' => array('com_id' => 'Components.id'),
      'ComponentViewCustomNames' => array('id' => 'ComponentViewCustomNames.com_view_id')
    );
  
  public function get_component()
  {
    
    return tx('Sql')
      ->table('cms', 'Components')
      ->pk($this->com_id)
      ->execute_single();
    
  }
  
  public function get_custom_names()
  {
    
    return tx('Sql')
      ->table('cms', 'ComponentViewCustomNames')
      ->where('com_view_id', $this->id)
      ->where('lang_id', tx('Language')->get_language_id())
      ->limit(1)
      ->execute_single();
    
  }
  
  public function get_prefered_title()
  {
    
    return $this->custom_names->title->otherwise(__($this->component->name, $this->tk_title, 'ucfirst', true));
    
  }
  
  public function get_prefered_description()
  {
    
    return $this->custom_names->description->otherwise($this->tk_description->is_set() ? __($this->component->name, $this->tk_description, true) : null);
    
  }
  
}
