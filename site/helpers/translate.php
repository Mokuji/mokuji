<?php if(!defined('TX')) die('No direct access.');

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

function ___($phrase, $case = null)
{
  return __($phrase, 1, $case);
}
