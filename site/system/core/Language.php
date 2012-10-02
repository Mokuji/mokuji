<?php namespace core; if(!defined('TX')) die('No direct access.');

class Language
{
  
  private
    $language_id,
    $language_code;
  
  //Getters for read_only properties.
  public function get_language_id(){ return $this->language_id; }
  public function get_language_code(){ return $this->language_code; }
  
  //in the initiator, we set the language to the first language in the database, or one defined by session vars
  public function init()
  {
    
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
    
    define('LANGUAGE', $lang->get());
    define('LANGUAGE_CODE', tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$lang->get()));
    
    $this->language_id = LANGUAGE;
    $this->language_code = LANGUAGE_CODE;
    
  }
  
  public function get_languages()
  {
    
    return tx('Sql')->execute_query('SELECT * FROM `#__core_languages` ORDER BY `id`');
    
  }
  
  public function translate($phrase, $component=null, $lang_id=null, $case = null)
  {
    
    raw($case, $phrase);
    $component = Data($component);
    $lang_id = Data($lang_id);
    
    //Component variable is ignored for now. But will be used for component specific translations later on.
    
    //Find the language we're looking for.
    if($lang_id->is_set()){
      $language_code = tx('Sql')->execute_scalar('SELECT code FROM #__core_languages WHERE id = '.$lang_id);
    }else{
      $language_code = $this->language_code;
    }
    
    //Load ini file.
    $lang_file = PATH_SITE.'/languages/'.$language_code.'.ini';
    if(!is_file($lang_file)){
      throw new \exception\FileMissing('The file \'%s\' can not be found.', $lang_file);
    }
    
    //Parse ini file.
    $ini_arr = parse_ini_file($lang_file);
    
    //Translate.
    if(array_key_exists($phrase, $ini_arr)){
      $phrase = $ini_arr[$phrase];
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
