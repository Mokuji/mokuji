<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class File
{
  
  protected
    $cache_time=604800,
    $source='',
    $dir='',
    $file='',
    $info=array();
  
  public function __construct($file=null)
  {
    
    if(is_string($file)){
      $this->from_file($file);
    }
    
  }
  
  //set default cache time
  public function cache_time($set=604800)
  {
    $this->cache_time = (int) $set;
  }
  
  public function from_file($source)
  {
    
    $f = tx('Url')->parse($source, \core\Url::PATH | \core\Url::FILE);

    if(empty($f['path'])){
      throw new \exception\InputMissing('The requested file should be inside a directory. We couldn\'t find one in URI: \'%s\'.', $source);
    }
    
    elseif(empty($f['file'])){
      throw new \exception\InputMissing('Could not extract a valid filename from "%s".', $source);
    }
    
    else{
      $dir = tx('File')->check_dir($f['path']);
      $source = $dir.$f['file'];
    }

    if(!is_file($source)){
      throw new \exception\NotFound('The file \'%s\' could not be found in \'%s\'.', $f['file'], $dir);
      return;
    }
    
    $this->source = $source;
    $this->dir = $dir;
    $this->file = $f['file'];
    $finfo = \finfo_open();
    
    $mime_info = new \finfo(FILEINFO_MIME_TYPE);
    
    $this->info['size'] = filesize($source);
    $this->info['extension'] = strtolower(pathinfo($f['file'], PATHINFO_EXTENSION));
    $this->info['name'] = basename($f['file'], '.'.$this->info['extension']);
    $this->info['mime'] = $mime_info->file($source);
    
    return $this;
    
  }
  
  public function save($save)
  {
    
    if(empty($this->source)){
      throw new \exception\InputMissing('No file selected.');
    }
    
    tx('File')->check_dir($save);
    copy($this->source, $save);
    
    return $this;
    
  }
  
  public function output($options=null)
  {
    
    $options = Data($options);
    
    $this->create_output_headers();
    
    tx('Logging')->log('File', 'Output', 'Start sending.');
    
    if(function_exists('http_send_file'))
      @http_send_file($this->source);
    else
      @readfile($this->source);
    
    tx('Logging')->log('File', 'Output', 'SUCCEEDED');
    
    $src = $this->source;
    $options->delete_after_output->is('true', function()use($src){
      tx('Logging')->log('File', 'Output', 'Deleting file after output. '.$src);
      unlink($src);
      tx('Logging')->log('File', 'Output', 'Deleted!');
    });
    
    exit;
    
  }
  
  protected function create_output_headers()
  {
    
    if(empty($this->source)){
      throw new \exception\InputMissing('No file selected.');
    }
    
    // Getting headers sent by the client.
    $headers = apache_request_headers();

    // Checking if the client is validating his cache and if it is current.
    if(array_key_exists('If-Modified-Since', $headers) && (strtotime($headers['If-Modified-Since']) == filemtime($this->source))){
      set_status_header(304);
      header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($this->source)).' GMT');
    }
    
    else{
      set_status_header(200);
      header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($this->source)).' GMT');
    }
    
    if(is_numeric($this->info['size'])){
      header('Content-Length: '.$this->info['size']);
    }
    
    if($this->cache_time > 0){
      header("Cache-Control: public, max-age=".$this->cache_time);
      header('Expires: '.gmdate('D, d M Y H:i:s', time()+$this->cache_time).' GMT');
    }
    
    header("Content-type: ".$this->info['mime']);
    
  }
  
  public function download($options=null)
  {
    $options = Data($options);
    
    header('Content-Disposition: attachment; filename="'.(is_string($options->as->get()) ? $options->as : $this->file).'";');
    header('Content-Transfer-Encoding: binary');
    
    $options->un_set('as');
    $this->output($options);
  }
  
}
