<?php namespace components\update\enums; if(!defined('MK')) die('No direct access.');

abstract class PackageType
{
  const CORE = 1;
  const COMPONENT = 2;
  const TEMPLATE = 3;
  const THEME = 4;
}