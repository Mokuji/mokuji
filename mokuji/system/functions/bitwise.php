<?php if(!defined('TX')) die('No direct access.');
  
  // check if a bitwise haystack contains the needle bit
  function checkbit($needle, $haystack){
    return (($haystack & $needle) === $needle);
  }
  
  //counts the amount of bits set to 1
  function count_bits($v){
    $v = $v - (($v >> 1) & 0x55555555);
    $v = ($v & 0x33333333) + (($v >> 2) & 0x33333333);
    return (($v + ($v >> 4) & 0xF0F0F0F) * 0x1010101) >> 24;
  }
