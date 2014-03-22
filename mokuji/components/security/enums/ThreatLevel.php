<?php namespace components\security\enums; if(!defined('MK')) die('No direct access.');

abstract class ThreatLevel
{
  
  const
    TRUSTED = -2,
    LOW     = -1,
    NORMAL  =  0,
    HIGH    =  1,
    EXTREME =  2;
  
}