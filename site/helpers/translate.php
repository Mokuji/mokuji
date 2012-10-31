<?php if(!defined('TX')) die('No direct access.');

//Different forms:
//--legacy--
// ($phrase)
// ($phrase, $only_return)
// ($phrase, $only_return, $case)
//
//--w/component--
// ($component, $phrase)
// ($component, $phrase, $case)
// ($component, $phrase, $only_return)
// ($component, $phrase, $case, $only_return)
function __(){
  
  //Get the arguments we want.
  $arguments = func_get_args();
  $args = count($arguments);
  
  //If no arguments are given, return empty string.
  if($args == 0) return ($only_return ? '' : null);
  
  //Component is provided (not legacy)
  if($args > 1 && is_string(data_of($arguments[1]))){
    $component = $arguments[0];
    $phrase = $arguments[1];
    $case = null;
    $only_return = false;
    if($args == 3){
      $case = is_string(data_of($arguments[2])) ? $arguments[2] : null;
      $only_return = is_string(data_of($arguments[2])) ? false : $arguments[2];
    } elseif($args == 4){
      $case = $arguments[2];
      $only_return = $arguments[3];
    }
  }
  
  else{
    //Legacy support.
    $component = null;
    $phrase = $arguments[0];
    $only_return = $args > 1 ? $arguments[1] : false;
    $case = $args > 2 ? $arguments[2] : null;
  }
  
  //Let the core do this part.
  $phrase = tx('Language')->translate($phrase, $component, null, $case);
  
  //Return (translated) phrase.
  if($only_return){
    return $phrase;
  }else{
    echo $phrase;
  }
  
}

/*
function __($phrase, $only_return = false, $case = null)
{
  
  //Let the core do this.
  $phrase = tx('Language')->translate($phrase, null, null, $case);
  
  //Return (translated) phrase.
  if($only_return){
    return $phrase;
  }else{
    echo $phrase;
  }

}
*/

function ___($phrase, $case = null)
{
  return __($phrase, 1, $case);
}
