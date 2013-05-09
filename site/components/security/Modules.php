<?php namespace components\security; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{
  
  /*
    
    # The Modules.php file
    
    This is where you define modules.
    Modules are used to insert a part of a page that is completely autonomous.
    If your module has dependencies or requires a certain context,
    you probably want to use the Sections.php file.
    Modules can be called in two ways, server-side or client-side.
    This allows you to reload a module by simply replacing the HTML it outputs.
    
    Call a module from the client-side using:
      http://mysite.com/index.php?module=security/function_name
    
    Call a module from the server-side using:
      tx('Component')->modules('security')->get_html('function_name', Data($options));
    
    Read more about modules here:
      https://github.com/Tuxion/tuxion.cms/wiki/Modules.php
    
  */
  
}
