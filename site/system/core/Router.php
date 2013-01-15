<?php namespace core; if(!defined('TX')) die('No direct access.');

class Router
{
  
  public function start()
  {
    
    $contents = '';
    
    //are we going to redirect
    if(tx('Url')->redirected){
      //yes we are, so we skip all the next elseif's
    }
    
    //Quick and dirty implementation of REST.
    elseif(tx('Data')->get->rest->is_set())
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
      $description .= ' ' . preg_replace('~(?:_([a-z])|([A-Z]))~e', '" ".strtolower("\\1")', $methodname) . '.';
      
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
        
        //Return field specific errors in JSON for Validation exceptions.
        if($userfunc->exception->getExCode() === EX_VALIDATION){
          $errors = $userfunc->exception->errors();
          for($i = 0, $total = count($errors), $sep = '', $msg = ''; $i < $total; $i++){
            $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
            $sep = ', ';
            if($i == $total-2) $sep = ' and ';
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
              if($i == $total-2) $sep = ' and ';
            }
            $msg .= '.';
            $errorData->{$error->key()}->set(ucfirst($msg));
          }
          
          echo $errorData->as_json();
          
        }//END - JSON for ModelValidation exceptions.
        
        exit;
        
      }
      
      //Return content as JSON.
      header('Content-type: application/json');
      $contents = Data($userfunc->return_value)->as_json();
      
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
  
}
