<?php namespace core; if(!defined('TX')) die('No direct access.');

class Language
{
  
  private
    $language_id,
    $language_code,
    $caching,
    $translations,
    $translating_started;
  
  //Getters for read_only properties.
  public function get_language_id(){ return $this->language_id; }
  public function get_language_code(){ return $this->language_code; }
  
  //Short notation for some getters.
  public function __get($key)
  {
    switch($key){
      case 'id': return $this->get_language_id();
      case 'code': return $this->get_language_code();
    }
  }
  
  //Setter for language_id.
  public function set_language_id($id){
    
    $id = Data($id);
    
    if($this->translating_started)
      throw new \exception\Programmer('Can\'t set language, translating has already started');
    
    tx('Validating language.', function()use($id){
      $id->validate('Language', array('number'=>'integer'));
      $this->language_code = tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$id)->get();
    })
    
    ->success(function($info)use($id){
      $this->language_id = $id->get();
    });
    
  }
  
  //in the initiator, we set the language to the first language in the database, or one defined by session vars
  public function init()
  {
    
    //Default is that we use caching.
    $this->caching = true;
    $this->translations = array();
    $this->translating_started = false;
    
    $language = null;
    
    //easy access to language variables in session
    $lang = tx('Data')->session->tx->language;
    
    //if the session defines a language
    if($lang->is_set())
    {
      
      tx('Validating language.', function()use($lang){
        $lang->validate('Language', array('number'=>'integer'));
        tx('Sql')->execute_scalar('SELECT id FROM #__core_languages WHERE id = '.$lang);
      })
      
      ->failure(function($info)use($lang){
        $lang->un_set();
        tx('Session')->new_flash('error', $info->get_user_message());
      });
      
    }
    
    //if the language is not in the session
    if( ! $lang->is_set())
    {
      
      tx('Setting language from database.', function()use($lang){
        $lang->set(tx('Sql')->execute_scalar('SELECT id FROM #__core_languages ORDER BY id ASC LIMIT 1'))
        ->is('empty', function(){
          throw new \exception\NotFound('No languages have been set up');
        });
      })
      
      ->failure(function($info)use($lang){
        $lang->un_set();
        throw new \exception\NotFound($info->get_user_message());
      });
      
    }
    
    //define('LANGUAGE', $lang->get());
    //define('LANGUAGE_CODE', tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$lang->get()));
    
    $this->language_id = $lang->get();
    $this->language_code = tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$lang->get())->get();
    
  }
  
  public function get_languages()
  {
    
    return tx('Sql')->execute_query('SELECT * FROM `#__core_languages` ORDER BY `id`');
    
  }
  
  public function multilanguage(\Closure $closure)
  {
    
    $this->get_languages()->each($closure);
    return $this;
    
  }
  
  public function translate($phrase, $component=null, $lang_id=null, $case = null)
  {
    
    $this->translating_started = true;
    
    raw($case, $phrase, $component);
    $lang_id = Data($lang_id);
    
    //Find the language we're looking for.
    if($lang_id->is_set()){
      $language_code = tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$lang_id);
    }else{
      $language_code = $this->language_code;
    }
    
    //See if we need to load this from file.
    if(!$this->caching || !array_key_exists($language_code, $this->translations) || !array_key_exists($component ? $component : DS, $this->translations[$language_code])){
      
      //Load json file.
      $lang_file = ($component ? PATH_COMPONENTS.DS.$component : PATH_SITE).DS.'i18n'.DS.$language_code.'.json';
      
      //Parse file.
      try
      {
        
        if(is_file($lang_file)){
          $arr = json_decode(file_get_contents($lang_file), true);
        }
        
      }
      catch(\exception $e){ /* best effort */ }
      
      //Fallback.
      if(!isset($arr) || !is_array($arr))
        $arr = array();
      
      //Create an array for this language in the cache if it doesn't exist yet.
      if(!array_key_exists($language_code, $this->translations))
        $this->translations[$language_code] = array();
      
      //Cache this per language, then per component.
      $this->translations[$language_code][$component ? $component : DS] = $arr;
      
    }
    
    //If we can get it from cache.
    else {
      $arr = $this->translations[$language_code][$component ? $component : DS];
    }
    
    //Translate.
    if(array_key_exists($phrase, $arr)){
      $phrase = $arr[$phrase];
    }
    
    //If the translation is not found in this file, and we specified a component, fall back on the core translation files.
    else if($component) {
      tx('Logging')->log('Translate', 'Com '.$component.' fallback', $phrase);
      return $this->translate($phrase, null, $lang_id, $case);
    }
    
    //Convert case?
    switch($case)
    {
      case 'ucfirst':
        $phrase = ucfirst($phrase);
        break;
      case 'l':
      case 'lower':
      case 'lowercase':
        $phrase = strtolower($phrase);
        break;
      case 'u':
      case 'upper':
      case 'uppercase':
        $phrase = strtoupper($phrase);
        break;
    }
    
    return $phrase;
    
  }
  
}
