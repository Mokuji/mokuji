<?php namespace components\security\enums; if(!defined('MK')) die('No direct access.');

abstract class ProtectionLevel
{
  
  const
    LOW     = -1,
    NORMAL  =  0,
    HIGH    =  1;
  
}