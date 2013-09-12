<?php if(!defined('TX')) die('No direct access.');

/**
* get an array of all positions of given substr, with an optional starting offset
*/
function strapos($haystack, $needle, $offset=0){
  $return = array();
  while($a = strpos($haystack, $needle, $offset) && $a !== false){
    $return[] = $a;
    $offset = $a;
  }
  return $return;
}

/**
* get depths of opening/closing character sets in a given string with optional ignoring
*/
function strapos_depths($haystack, $opening=false, $closing=false, $ignored=false){

  $ignore = off;
  $depth = 0;
  $occurence = 0;
  $return = array();
  foreach(str_split((string)$haystack) AS $i => $char)
  {
    if($ignore === off){
      switch($char){
        case $ignored:
          $ignore = on;
          break;
        case $opening;
          $return[$occurence][$depth]['opening'] = $i;
          $depth++;
          break;
        case $closing;
          $depth--;
          $return[$occurence][$depth]['closing'] = $i;
          break;
      }
      if($depth < 1){
        $occurence++;
      }
    }elseif($ignore === on && $char === '\''){
      $ignore = off;
    }
  }
  
  return $return;

}

/**
* extract the classname out of a full-namepspaced string
*/
function baseclass($classname){
  return substr(strrchr($classname, '\\'), 1);
}

//parse_str with a normal return value
function parse_string($input){
  parse_str($input, $output);
  return $output;
}

/**
* Cut off a string when it is too long.
*/
function str_max($input, $max, $append='')
{
  $max = (int)$max;
  if(strlen($input) > $max + strlen($append))
    return trim(substr($input, 0, $max)).$append;
  return $input;
}
  
/**
 * Prints a string if the provided condition is true.
 */
function cond_print($check, $string)
{
  
  raw($check, $string);
  
  if($check === true){
    echo $string;
  }
  
}

/**
 * Converts a version string to a valid function name.
 * 
 * Example: '1.2.2-beta' => '1_2_2_beta'
 * 
 * @see http://development.mokuji.org/40/versioning?menu=43
 * @param  string $version Version string.
 * @return string Function name variation of the version.
 */
function vtfn($version)
{
  raw($version);
  return str_replace('.', '_', str_replace('-', '_', $version));
}