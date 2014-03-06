<?php namespace core; if(!defined('TX')) die('No direct access.');

class Router
{
  
  public function rest()
  {
    
    $this->check_connection_security();
    
    //Get our route.
    $route = mk('Data')->get->_RESTROUTE;
    $route_segments = explode('/', $route->get());
    $component = array_shift($route_segments);
    $model = array_shift($route_segments);
    $route = Data($route_segments);
    
    //And our method and options.
    $method = mk('Data')->server->REQUEST_METHOD->lowercase()->get();
    $options = mk('Data')->get->without('_RESTROUTE');
    $output = null;
    
    //Base the method we'll call the request method.
    switch($method){
      
      //Methods that need to parse the HTTP body.
      case 'put':
      case 'post':
      case 'patch':
        
        //Get us some data.
        $data = Data(json_decode(file_get_contents("php://input"), true));
        
        //And find our output.
        try{
          $output = mk('Component')->json($component)->_call(
            "{$method}_{$model}", array($data, $route, $options)
          );
        }catch(\Exception $ex){
          $this->process_rest_exception($ex);
        }
        break;
      
      case 'get':
      case 'delete':
        
        //Just call the method already.
        try{
          $output = mk('Component')->json($component)->_call(
            "{$method}_{$model}", array($options, $route)
          );
        }catch(\Exception $ex){
          $this->process_rest_exception($ex);
        }
        
        break;
      
      default:
        throw new \exception\Programmer('Method "%s" not supported.', mk('Data')->server->REQUEST_METHOD);
      
    }
    
    //After doing all that, check to see if we redirected somewhere during the process
    if(mk('Url')->redirected){
      mk('Logging')->log('Router', 'Redirect', mk('Url')->redirect_url);
      header('Location: '.mk('Url')->redirect_url);
      exit;
    }
    
    //What's left?
    //Output! :D
    header('Content-type: application/json; charset=utf-8');
    echo Data($output)->as_json(JSON_UNESCAPED_UNICODE, \dependencies\Data::OPTION_UNSET_AS_NULL);
    
  }
  
  public function start()
  {
    
    $this->check_connection_security();
    
    $contents = '';
    
    if(tx('Data')->get->rest->is_set())
    {
      
      //Get the "rest" path and method.
      $path = tx('Data')->get->rest->get();
      $method = tx('Data')->server->REQUEST_METHOD->lowercase()->get();
      
      //Base the method we'll call off of the request method.
      switch($method){
        case 'get': $methodtype = 'get'; $description = 'Getting'; break;
        case 'post': $methodtype = 'create'; $description = 'Creating'; break;
        case 'put': $methodtype = 'update'; $description = 'Updating'; break;
        case 'delete': $methodtype = 'delete'; $description = 'Deleting'; break;
        default: throw new \exception\Programmer('Method "%s" not supported.', tx('Data')->server->REQUEST_METHOD); break;
      }
      
      //Use PHP $_GET?
      if($method == 'get'){
        $data = tx('Data')->get->copy()->un_set('rest');
      }
      
      //Or parse JSON-input?
      else{
        $data = Data(tx('Data')->xss_clean(json_decode(file_get_contents("php://input"), true)));
      }
      
      //Read the path to get component, method and parameters.
      $parameters = explode('/', $path);
      $component = array_shift($parameters);
      $methodname = array_shift($parameters);
      
      //Finish the description by serializing the method name.
      $description .= ' ' . preg_replace_callback('~(?:_([a-z])|([A-Z]))~', function($matches){
        return ' '.strtolower($matches[1]);
      }, $methodname).'.';
      
      //Call the method. It should return a \dependencies\UserFunction.
      $userfunc = tx($description, function()use($component, $methodtype, $methodname, $data, $parameters){
        return tx('Component')->json($component)->_call(
          "{$methodtype}_{$methodname}", array($data, Data($parameters))
        );
      });
      
      //Decide on the response code.
      if($userfunc->failure())
      {
        
        switch($userfunc->exception->getExCode()){
          case EX_AUTHORISATION: $code = 401; break;
          case EX_EMPTYRESULT: $code = 404; break;
          
          //Validation errors
          case EX_VALIDATION:
          case EX_MODEL_VALIDATION:
            $code = 412; break;
          
          default: $code = 500; break;
        }
        
        set_status_header($code, $userfunc->get_user_message());
        
        $AND = __('And', true, 'l');
        
        //Return field specific errors in JSON for Validation exceptions.
        if($userfunc->exception->getExCode() === EX_VALIDATION){
          $errors = $userfunc->exception->errors();
          for($i = 0, $total = count($errors), $sep = '', $msg = ''; $i < $total; $i++){
            $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
            $sep = ', ';
            if($i == $total-2) $sep = " $AND ";
          }
          echo '{"'.$userfunc->exception->key().'":"'.ucfirst($msg).'."}';
        }
        
        //Return field specific errors in JSON for ModelValidation exceptions.
        if($userfunc->exception->getExCode() === EX_MODEL_VALIDATION){
          
          $errorData = Data();
          
          foreach ($userfunc->exception->errors as $error){
            $sep = '';
            $msg = '';
            $errors = $error->errors();
            $total = count($errors);
            for($i = 0; $i < $total; $i++){
              $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
              $sep = ', ';
              if($i == $total-2) $sep = " $AND ";
            }
            $msg .= '.';
            $errorData->{$error->key()}->set(ucfirst($msg));
          }
          
          echo $errorData->as_json();
          
        }//END - JSON for ModelValidation exceptions.
        
        exit;
        
      }
      
      //Return content as JSON.
      header('Content-type: application/json; charset=utf-8');
      $contents = Data($userfunc->return_value)->as_json(JSON_FORCE_OBJECT);
      
    }
    
    //are we going to execute an action?
    elseif(tx('Data')->get->action->is_set()){
      $ai = $this->parse_action(tx('Data')->get->action->get());
      $contents = tx('Component')->actions($ai['component'])->call($ai['controller'], tx('Data')->{$ai['data']});
      tx('Url')->redirect(url('action=NULL', false, true));
    }
    
    //or load a section
    elseif(tx('Data')->get->section->is_set()){
      $si = $this->parse_section(tx('Data')->get->section);
      $contents = tx('Component')->sections($si['component'])->get_html($si['controller'], tx('Data')->get->options->get());
    }
    
    //maybe a module?
    elseif(tx('Data')->get->module->is_set()){
      $mi = $this->parse_module(tx('Data')->get->module);
      $contents = tx('Component')->modules($mi['component'])->get_html($mi['controller'], tx('Data')->get->options->get());
    }
    
    //load the template
    else{
      $contents = tx('Component')->enter($this->get_component());
    }
    
    //after doing all that, check to see if we redirected somewhere during the process
    if(tx('Url')->redirected && tx('Data')->session->tx->debug->pause_redirects->get() != true){
      tx('Logging')->log('Router', 'Redirect', tx('Url')->redirect_url);
      header('Location: '.tx('Url')->redirect_url);
      exit;
    }
    
    //are we going to load the redirect page?
    elseif(tx('Url')->redirected && tx('Data')->session->tx->debug->pause_redirects->get() == true){
      $contents = tx('Controller')->load_redirect_template(tx('Url')->redirect_url);
    }
    
    //render the page
    tx('Controller')->render_page($contents);
    
  }
  
  private function get_component()
  {
    
    if(tx('Config')->system('component')->is_empty()){
      throw new \exception\InputMissing("tx('Config')->system('component') is not defined.");
    }
    
    return tx('Config')->system('component')->get();
    
  }
  
  private function parse_action($action)
  {
    
    $as = explode('/', $action);
    switch(count($as))
    {
      
      //only a function is given. no data. no handler
      case 1:
        $action = $as[0];
        $data = 'get';
        $handler = $this->get_component();
        break;
        
      //a 'function/data' or 'handler/function'
      case 2:
        
        if(in_array(strtolower($as[1]), array('get', 'post'))){
          $action = $as[0];
          $data = strtolower($as[1]);
          $handler = $this->get_component();
        }
        
        else{
          $action = $as[1];
          $data = 'get';
          $handler = $as[0];
        }
        
        break;
        
      //a 'handler/function/data'
      case 3:
        $action = $as[1];
        $data = strtolower($as[2]);
        $handler = $as[0];
        break;
    }
    
    if(!in_array(strtolower($data), array('get', 'post'))){
      throw new \exception\InvalidArgument("Allowed data types for passing arguments to an action are 'get' or 'post'. So not '%s'", $data);
      return;
    }
    
    if(!method_exists(tx('Component')->actions($handler), $action)){
      throw new \exception\NotFound("Action '%s::%s' does not exist.", $handler, $action);
    }
    
    return array('component' => $handler, 'controller' => $action, 'data' => strtolower($data));
    
  }
  
  private function parse_section($section)
  {
    
    $section_array = explode('/', data_of($section));
    
    switch(count($section_array))
    {
      
      case 1:
        $component = $this->get_component();
        $controller = $section_array[0];
        break;
        
      case 2:
        $component = $section_array[0];
        $controller = $section_array[1];
        break;
        
      default:
        throw new \exception\InvalidArgument('Expecting section to consist of 1 or 2 parts separated by a forward slash.');
        return;
        
    }
    
    return array('component'=>$component, 'controller'=>$controller);
    
  }
  
  private function parse_module($module)
  {
    
    $module_array = explode('/', data_of($module));
    
    switch(count($module_array))
    {
      
      case 1:
        $component = $this->get_component();
        $controller = $module_array[0];
        break;
        
      case 2:
        $component = $module_array[0];
        $controller = $module_array[1];
        break;
        
      default:
        throw new \exception\InvalidArgument('Expecting module to consist of 1 or 2 parts separated by a forward slash.');
        return;
        
    }
    
    return array('component'=>$component, 'controller'=>$controller);
    
  }
  
  //If needed, switch to secure protocol or back.
  private function check_connection_security()
  {
    
    if(tx('Config')->user('tls_mode')->get() === 'always' && tx('Url')->url->segments->scheme->get() !== 'https')
      tx('Url')->redirect(url('')->segments->merge(array('scheme' => 'https'))->back()->rebuild_output());
    
    elseif(tx('Config')->user('tls_mode')->get() === 'never' && tx('Url')->url->segments->scheme->get() !== 'http')
      tx('Url')->redirect(url('')->segments->merge(array('scheme' => 'http'))->back()->rebuild_output());
    
    //In case this redirects us. Do it now.
    if(mk('Url')->redirected){
      mk('Logging')->log('Router', 'Redirect', mk('Url')->redirect_url);
      header('Location: '.mk('Url')->redirect_url);
      exit;
    }
    
  }
  
  //Customizes the response for errors during REST calls.
  private function process_rest_exception($ex)
  {
    
    $class = get_class($ex);
    $ns = 'exception\\';
    switch($class){
      case $ns.'Authorisation': $code = 401; break;
      case $ns.'EmptyResult': $code = 404; break;
      
      //Validation errors
      case $ns.'Validation':
      case $ns.'ModelValidation':
        $code = 412; break;
      
      //By default, use the uncaught exception handler.
      default: throw $ex;
      
    }
    
    set_status_header($code, $ex->getMessage());
    
    $AND = __('And', true, 'l');
    
    //Return field specific errors in JSON for Validation exceptions.
    if($class === $ns.'Validation'){
      $errors = $ex->errors();
      for($i = 0, $total = count($errors), $sep = '', $msg = ''; $i < $total; $i++){
        $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
        $sep = ', ';
        if($i == $total-2) $sep = " $AND ";
      }
      mk('Logging')->log('Core', 'REST call', 'Validation error. '.'{"'.$ex->key().'":"'.ucfirst($msg).'."}');
      die('{"'.$ex->key().'":"'.ucfirst($msg).'."}');
    }
    
    //Return field specific errors in JSON for ModelValidation exceptions.
    if($class === $ns.'ModelValidation'){
      
      $errorData = Data();
      
      foreach ($ex->errors as $error){
        $sep = '';
        $msg = '';
        $errors = $error->errors();
        $total = count($errors);
        for($i = 0; $i < $total; $i++){
          $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
          $sep = ', ';
          if($i == $total-2) $sep = " $AND ";
        }
        $msg .= '.';
        $errorData->{$error->key()}->set(ucfirst($msg));
      }
      mk('Logging')->log('Core', 'REST call', 'Model validation error. '.$errorData->as_json());
      die($errorData->as_json());
      
    }//END - JSON for ModelValidation exceptions.
    
  }
  
}
