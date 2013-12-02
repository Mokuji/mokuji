<?php namespace core; if(!defined('TX')) die('No direct access.');

class Data
{

	public 
    $post,
    $get,
    $request,
    $session,
    $server,
    $files,
    $env,
    $cookie;
  
  public function init()
	{
    
    $datatypes = array(
			'post'=>$_POST,
			'get'=>$_GET,
      'request'=>$_REQUEST,
      'session'=>((isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : array()),
			'server'=>$_SERVER,
			'files'=>$_FILES,
			'env'=>$_ENV,
			'cookie'=>$_COOKIE
		);
    
		//filter all data and put them in appropiate arrays, then unset the data arrays to prevent direct use
		foreach($datatypes as $type => $global)
		{
			if(get_magic_quotes_gpc()) $global = $this->undo_magic_quotes($global);
      switch($type){
				case 'server':
				case 'files':
				default:
          $global = $this->xss_clean($global);
			}
      $this->{$type} = Data($global);
		}
		
		unset($_POST, $_GET, $_SERVER, $_FILES, $_ENV, $_COOKIE, $_REQUEST);
    $_SESSION = array();
    
    //Make sure session is kept after fatals.
    register_shutdown_function(function(){
      tx('Logging')->log('Data', 'Session', 'The session was restored.');
      tx('Data')->restore_session();
    });
		
	}
	
  public function xss_clean($str)
	{
		// http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
		// +----------------------------------------------------------------------+
		// | Copyright (c) 2001-2006 Bitflux GmbH                                 |
		// +----------------------------------------------------------------------+
		// | Licensed under the Apache License, Version 2.0 (the "License");      |
		// | you may not use this file except in compliance with the License.     |
		// | You may obtain a copy of the License at                              |
		// | http://www.apache.org/licenses/LICENSE-2.0                           |
		// | Unless required by applicable law or agreed to in writing, software  |
		// | distributed under the License is distributed on an "AS IS" BASIS,    |
		// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
		// | implied. See the License for the specific language governing         |
		// | permissions and limitations under the License.                       |
		// +----------------------------------------------------------------------+
		// | Author: Christian Stocker <chregu@bitflux.ch>                        |
		// +----------------------------------------------------------------------+
		//
		// Kohana Modifications:
		// * Changed double quotes to single quotes, changed indenting and spacing
		// * Removed magic_quotes stuff
		// * Increased regex readability:
		//   * Used delimeters that aren't found in the pattern
		//   * Removed all unneeded escapes
		//   * Deleted U modifiers and swapped greediness where needed
		// * Increased regex speed:
		//   * Made capturing parentheses non-capturing where possible
		//   * Removed parentheses where possible
		//   * Split up alternation alternatives
		//   * Made some quantifiers possessive
		// * Handle arrays recursively

		if (is_array($str) OR is_object($str))
		{
			foreach ($str as $k => $s)
			{
				$str[$k] = $this->xss_clean($s);
			}

			return $str;
		}

		// Remove all NULL bytes
		$str = str_replace("\0", '', $str);

		// Fix &entity\n;
		$str = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $str);
		$str = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $str);
		$str = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $str);
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$str = preg_replace('#(?:on[a-z]+|xmlns)\s*=\s*[\'"\x00-\x20]?[^\'>"]*[\'"\x00-\x20]?\s?#iu', '', $str);

		// Remove javascript: and vbscript: protocols
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $str);
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $str);
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $str);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#ius', '$1>', $str);

		// Remove namespaced elements (we do not need them)
		$str = preg_replace('#</*\w+:\w[^>]*+>#i', '', $str);

		do
		{
			// Remove really unwanted tags
			$old = $str;
			// $str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
			$str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|frame(?:set)?|i(layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
		}
		while ($old !== $str);

		return $str;
    
	}
  
  // destructor puts session array back in to $_SESSION and stores postdata in session if this page redirects
	public function __destruct()
	{
    
    if(tx('Url')->redirected){
      $this->post->copyto($this->session->tx->postdata);
    }else{
      $this->session->tx->postdata->un_set();
    }
    
  }
  
  public function restore_session()
  {
    $_SESSION = $this->session->as_array();
  }
	
  public function __get($name)
  {
    if(method_exists($this, $name)){
      return call_user_func(array($this, $name));
    }else{
      throw new \exception\NotFound('Valid dataglobals are: post; get; session; server; files; env; cookie; filter. %s requested.', ucfirst($name));
    }
  }
  
  // custom filter method to merge get over session filters
	public function filter($component)
	{
    
    try{
      tx('Component')->check($component);
    }
    
    catch(\exception\Programmer $e){
      throw new \exception\InvalidArgument("Component %s is not valid.", $component);
      return false;
    }
    
    return $this->merge($this->session->{$component}->filters, $this->get);
    
	}
	
  //custom postdata function to get postdata from session
  public function postdata()
  {
  
    return $this->session->tx->postdata;
  
  }
  
  private function undo_magic_quotes($array, $top_level = true)
  {
    $new_array = array();
    foreach($array as $key => $value){
      if(!$top_level){
        $new_key = stripslashes($key);
        if ($new_key !== $key){
          unset($array[$key]);
        }
        $key = $new_key;
      }
      $new_array[$key] = (is_array($value) ? $this->undo_magic_quotes($value, false) : stripslashes($value));
    }
    return $new_array;
  }

  public function merge()
  {
    
    if(func_num_args() < 2){
      throw new \exception\InvalidArgument('Expecting 2 or more arguments. %s Given.', func_num_args());
      return false;
    }
    
    $merge = array();
    
    foreach(func_get_args() AS $arg)
    {
      //var_dump($arg);
      if(!is_data($arg)){
        throw new \exception\InvalidArguments("Expecting Data() for all parameters. %s given as argument %s.", ucfirst(gettype($arg)), array_search($arg, func_get_args()));
        return false;
      }
      
      $merge[] = $arg->as_array();
      
    }
    
    $merged = call_user_func_array('array_merge_recursive_distinct', $merge);
    
    return Data($merged);
  
  }
  
}


