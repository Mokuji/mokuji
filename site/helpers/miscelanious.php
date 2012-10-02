<?php if(!defined('TX')) die('No direct access.');

function url($url, $discard_old_querystring=false, $build_on_redirect=false, $keep_module_id=false)
{
  
  return new \dependencies\Url(data_of($url), array(
    'discard_old_querystring' => $discard_old_querystring,
    'build_on_redirect' => $build_on_redirect,
    'keep_module_id' => $keep_module_id
  ));
  
}

function set_status_header($code=200, $text=null){
  
  $stati = array(
    200	=> 'OK',
    201	=> 'Created',
    202	=> 'Accepted',
    203	=> 'Non-Authoritative Information',
    204	=> 'No Content',
    205	=> 'Reset Content',
    206	=> 'Partial Content',

    300	=> 'Multiple Choices',
    301	=> 'Moved Permanently',
    302	=> 'Found',
    304	=> 'Not Modified',
    305	=> 'Use Proxy',
    307	=> 'Temporary Redirect',

    400	=> 'Bad Request',
    401	=> 'Unauthorized',
    403	=> 'Forbidden',
    404	=> 'Not Found',
    405	=> 'Method Not Allowed',
    406	=> 'Not Acceptable',
    407	=> 'Proxy Authentication Required',
    408	=> 'Request Timeout',
    409	=> 'Conflict',
    410	=> 'Gone',
    411	=> 'Length Required',
    412	=> 'Precondition Failed',
    413	=> 'Request Entity Too Large',
    414	=> 'Request-URI Too Long',
    415	=> 'Unsupported Media Type',
    416	=> 'Requested Range Not Satisfiable',
    417	=> 'Expectation Failed',

    500	=> 'Internal Server Error',
    501	=> 'Not Implemented',
    502	=> 'Bad Gateway',
    503	=> 'Service Unavailable',
    504	=> 'Gateway Timeout',
    505	=> 'HTTP Version Not Supported'
  );
  
  if(!array_key_exists($code, $stati)){
    throw new \exception\InvlaidArgument('Invalid status code "%s" given. Valid status codes are: %s.', $code, implode(', ', array_keys($stati)));
  }
  
  if(!is_string($text)){
    $text = $stati[$code];
  }

  $server_protocol = tx('Data')->server->SERVER_PROTOCOL->get();

  if(substr(php_sapi_name(), 0, 3) == 'cgi'){
    header("Status: $code $text", true);
  }
  
  elseif($server_protocol == 'HTTP/1.1' || $server_protocol == 'HTTP/1.0'){
    header("$server_protocol $code $text", true, $code);
  }
  
  else{
    header("HTTP/1.1 $code $text", true, $code);
  }
  
}

function file_upload_error_message($error_code) {
  $error_code = data_of($error_code);
  switch ($error_code) { 
  case UPLOAD_ERR_INI_SIZE: 
    return 'The uploaded file exceeds the upload_max_filesize directive in php.ini ('.(int)ini_get('upload_max_filesize').'MB)'; 
  case UPLOAD_ERR_FORM_SIZE: 
    return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; 
  case UPLOAD_ERR_PARTIAL: 
    return 'The uploaded file was only partially uploaded'; 
  case UPLOAD_ERR_NO_FILE: 
    return 'No file was uploaded'; 
  case UPLOAD_ERR_NO_TMP_DIR: 
    return 'Missing a temporary folder'; 
  case UPLOAD_ERR_CANT_WRITE: 
    return 'Failed to write file to disk'; 
  case UPLOAD_ERR_EXTENSION: 
    return 'File upload stopped by extension'; 
  default: 
    return 'Unknown upload error'; 
  } 
}

if(!function_exists('apache_request_headers')){

  function apache_request_headers() {
    $arh = array();
    $rx_http = '/\AHTTP_/';
    foreach(tx('Data')->server as $key => $val) {
      if( preg_match($rx_http, $key) ) {
        $arh_key = preg_replace($rx_http, '', $key);
        $rx_matches = array();
        // do some nasty string manipulations to restore the original letter case
        // this should work in most cases
        $rx_matches = explode('_', $arh_key);
        if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
          foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
          $arh_key = implode('-', $rx_matches);
        }
        $arh[$arh_key] = $val;
      }
    }
    return( $arh );
  }

}