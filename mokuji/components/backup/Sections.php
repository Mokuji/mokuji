<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  /*
    
    # The Sections.php file
    
    This is where you define sections.
    Sections are used to insert a part of a page that is for private use inside the component.
    This allows you to reuse pieces of HTML and allows you to reload by replacing the HTML.
    If your section is very autonomous and might be useful for other components,
    you probably should rewrite it as a Module.php function instead.
    
    Call a section from the client-side using:
      http://mysite.com/index.php?section=backup/function_name
    
    Call a section from the server-side using:
      tx('Component')->sections('backup')->get_html('function_name', Data($options));
    
    Read more about sections here:
      https://github.com/Tuxion/mokuji/wiki/Sections.php
    
  */
  
}
