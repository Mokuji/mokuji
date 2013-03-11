<?php namespace core; if(!defined('TX')) die('No direct access.');

use \dependencies\CsvImporter;

class Csv
{
  
  //Creates an import script.
  public function import($component, $title, $retry=false)
  {
    return new CsvImporter($component, $title, $retry);
  }
  
}
