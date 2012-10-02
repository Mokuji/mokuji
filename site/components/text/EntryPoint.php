<?php namespace components\sevendays; if(!defined('TX')) die('No direct access.');

class EntryPoint extends \dependencies\BaseEntryPoint
{

  public function entrance()
  {

    //backend
    if(tx('Config')->system()->check('backend'))
    {

      tx('Config')->system('component', 'cms');
      return tx('Component')->enter('cms');

    }

    //frontend
    else
    {

    }

  }

}
