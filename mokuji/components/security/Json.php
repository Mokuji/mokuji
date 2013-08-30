<?php namespace components\security; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  /*
    
    # The Json.php file
    
    This is where you define REST calls.
    They are mostly used for asynchronous operations, such as jQuery.restForm.
    If you need the operation to cause a pageload, you probably need the Actions.php file.
    
    REST calls are prefixed based on the request type.
    For example, calling ?rest=component_name/function_name using an HTTP GET request
    calls get_function_name in the corresponding Json.php file.
    
    The prefixes:
      HTTP GET     = get_function_name
      HTTP PUT     = update_function_name
      HTTP POST    = create_function_name
      HTTP DELETE  = delete_function_name
    
    Read more about actions here:
      https://github.com/Tuxion/tuxion.cms/wiki/Json.php
    
  */
  
}
