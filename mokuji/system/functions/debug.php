<?php if(!defined('TX')) die('No direct access.');

function error_handler($errno, $errstr='', $errfile='', $errline='', $context=array()){
  
  if((error_reporting() & $errno) == 0){
    return;
  }
  
  throw new \exception\Error($errno, $errstr, $errfile, $errline, $context);
  
}

function exception_handler($e){
  
  mk('Logging')->log('Debug', 'Uncaught exception', n.$e->getMessage().n.'in '.$e->getFile().'('.$e->getLine().')'.n.$e->getTraceAsString(), false, true);
  mk('Controller')->load_error_template($e);
  
}

function rest_exception_handler($e)
{
  
  mk('Logging')->log('Debug', 'Uncaught exception', n.$e->getMessage().n.'in '.$e->getFile().'('.$e->getLine().')'.n.$e->getTraceAsString(), false, true);
  
  //Use HTTP response code 500 Internal Server Error, because this exception is uncaught.
  set_status_header(500);
  header('Content-type: application/json; charset=utf8');
  
  //This body is just for developers debugging their code.
  //Not to be used for production environments.
  if(DEBUG) echo json_encode(array(
    'error' => array(
      'type' => 'Uncaught exception',
      'message' => $e->getMessage(),
      'file' => $e->getFile(),
      'line' => $e->getLine(),
      'trace' => $e->getTrace()
    )
  ), JSON_PRETTY_PRINT);
  
  exit;
  
}

function exception_handler_image($e){
  
  try
  {
    
    $text = (DEBUG ? $e->getMessage() : __('Image could not be loaded.', MK));
    
    mk('File')->image()
      ->create(300, 300, 'black')
      ->text($text, 'white', 4, 10)
      ->output();
    
    exit;
    
  }catch(\exception\Exception $ex){
    exception_handler($e);
  }
  
}

function trace(){
  static $tracenum = 1;
  $trace = debug_backtrace(false);
  echo "<pre>\n<b style=\"color:red\">trace(".func_num_args().") #$tracenum called in <span style=\"cursor:help\" title=\"".$trace[0]['file']."\">".basename($trace[0]['file'], EXT)."</span> @ {$trace[0]['line']}:</b>\n";
  if(func_num_args() > 1){
    $i = 1;
    foreach(func_get_args() as $arg){
      echo "\n&raquo; Argument $i:\n";
      var_dump($arg);
      $i++;
    }
    echo "<b>\neof: trace #$tracenum</b>";
  }elseif(func_num_args() == 1){
    var_dump(func_get_arg(0));
  }else{
    echo tx('Error')->callstack();
  }
  echo "\n</pre>";
  $tracenum++;
}

function callstack(){
  
  static
    $user_func=false,
    $user_func_file,
    $user_func_line;

  $args = func_get_args();
  
  if(!empty($args) && is_bool($args[0])){
    $echo = array_shift($args);
  }
  
  else{
    $echo = false;
  }
  
  if(!empty($args) && is_array($args[0])){
    $backtrace = array_shift($args);
  }
  
  else{
    $backtrace = debug_backtrace();
  }

  $backtrace = array_reverse($backtrace);
  $trace = '';
  foreach($backtrace as $v)
  {
    
    if($user_func && (empty($v['file']) || empty($v['line']))){
      $user_func = false;
      $v['file'] = $user_func_file;
      $v['line'] = $user_func_line;
    }
    $user_func_file = null;
    $user_func_line = null;
    
    if(!array_key_exists('file', $v)){
      $v['file'] = '?';
    }
    if(!array_key_exists('line', $v)){
      $v['line'] = '?';
    }
    
    switch($v['function']){
      case 'call_user_func':
      case 'call_user_func_array':
        $user_func = true;
        $user_func_file = $v['file'];
        $user_func_line = $v['line'];
      case 'require_once':
      case 'require':
      case 'include_once':
      case 'include':
      case 'error_handler':
      case 'exception_handler':
      case 'callstack':
      case 'trigger_error':
        continue 2;
    }
    
    if(array_key_exists('class', $v)){
      switch($v['class']){
        case 'superclass':
        case 'dependencies\\UserFunction':
          continue 2;
      }
    }
    
    $trace .= "    &raquo; ".(array_key_exists('class', $v) ? $v['class'].'::'.$v['function'] : $v['function'])."(";
    if(array_key_exists('args', $v)){
      $separator = '';
      foreach($v['args'] as $arg){
        $trace .= $separator.argument_to_string($arg);
        $separator = ', ';
      }
    }
    $trace .= ")\n      (<span style=\"cursor:help\" title=\"".$v['file']."\">".basename($v['file'], EXT).'</span> @ '.$v['line'].")\n";
    
  }
  
  if($echo){
    echo "<pre>$trace</pre>";
  }else{
    return $trace;
  }
  
}

function log_msg($namespace, $message){
  
  $namespace_max = 10;
  if(strlen($namespace) > $namespace_max){
    $namespace = substr($namespace, 0, floor($namespace_max/2)).'..'.substr($namespace, ceil($namespace_max/2));
  }
  $separator = '  '.str_repeat(' ', $namespace_max - strlen($namespace));
  
  $file = PATH_BASE.DS.'log.txt';
  $a = fopen($file, 'a');
  $dt = date('Ymd His', time());
  $r = fwrite($a, "\n$dt: $namespace$separator$message");
  fclose($a);
  
  return !!$r;
  
}

