<?php if(!defined('TX')) die('No direct access.');

function curl_call($url, $post=array())
{
  
  raw($url, $post);
  
  tx('Logging')->log('CURL call', 'Start', 'Starting curl_call for url '.$url);
  
  //When using curl. Curl needs to be installed.
  if (!function_exists('curl_init')) {
    throw new \exception\Exception('The curl_call helper needs the CURL PHP extension.');
  }
  
  //Create curl handle.
  $handle = curl_init();
  
  //Set the default options.
  $options = array(
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 60,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT      => 'tx.cms-curl_call-1.0',
  );
  
  //Take the URL and post fields from arguments.
  $options[CURLOPT_URL] = $url;
  
  //Only set postfields if they are present.
  if(isset($post) && is_array($post) && count($post) > 0)
    $options[CURLOPT_POSTFIELDS] = http_build_query($post, null, '&');
  
  //Disable the 'Expect: 100-continue' behaviour. This causes CURL to wait for 2 seconds if the server does not support this header.
  if (isset($options[CURLOPT_HTTPHEADER])) {
    $existing_headers = $options[CURLOPT_HTTPHEADER];
    $existing_headers[] = 'Expect:';
    $options[CURLOPT_HTTPHEADER] = $existing_headers;
  } else {
    $options[CURLOPT_HTTPHEADER] = array('Expect:');
  }
  
  //Set the options.
  curl_setopt_array($handle, $options);
  
  //Make the call.
  $result = curl_exec($handle);
  
  //In case of an error, throw it.
  if ($result === false) {
    $e = new \exception\Unexpected('Curl call failed, [%s] %s', curl_errno($handle), curl_error($handle));
    curl_close($handle);
    throw $e;
  }
  
  tx('Logging')->log('CURL call', 'Done', 'Finished curl_call for url '.$url);
  
  //Otherwise, close and return.
  $return_data = array(
    'type' => curl_getinfo($handle, CURLINFO_CONTENT_TYPE),
    'size' => curl_getinfo($handle, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
    'data' => $result
  );
  curl_close($handle);
  return $return_data;
  
}
