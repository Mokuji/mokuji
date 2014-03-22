<?php namespace components\security\enums; if(!defined('MK')) die('No direct access.');

abstract class SuspicionLevel
{
  
  const
    NONE    = -2,
    LOW     = -1,
    NEUTRAL =  0,
    HIGH    =  1,
    CERTAIN =  2;
  
}