<?php namespace core; if(!defined('TX')) die('No direct access.');

class File
{

  private
    $uploads,
    $paths=null;

  // fill the paths array
  public function init()
  {

    tx('Data')->files->copyto($this->uploads);

    //add the paths defined in the appropriate .ini file to the allowed paths
    $this->paths = Data(parse_ini_file(PATH_FRAMEWORK.DS.'config'.DS.'file_handling_dirs.ini'))->map(function($v){
      return (substr($v, 0, 1) === DS ? $v : PATH_BASE.DS.$v);
    });

    //add the component "upload" directories
    $this->paths->merge(glob(PATH_COMPONENTS.DS.'*'.DS.'uploads'.DS));

  }

  // register a directory as one allowed to perform serverside file operations in
  public function add_dir($path)
  {

    $path = tx('Url')->parse($path, \core\Url::PATH);

    if(is_dir($path)){
      if(substr(decoct(fileperms($path)), -3) != '777' && !@chmod($path, 0777)){
        throw new \exception\Restriction(
          'Could not change the permissions of \'%s\'. This could be caused by the server not being the owner of the directory and can be '.
          'fixed by customly changing the permissions of the directory to 0777.', $path
        );
        return;
      }
    }

    else{
      if(!@mkdir($path, 0777)){
        throw new \exception\Restriction(
          'Could not create directory \'%s\'. This could be caused by the parent directory not having write-rights. This can be '.
          'fixed by changing the permissions of the parent directory, or creating the subfolder yourself.', $path
        );
      }
    }

    $this->paths[] = $path;

  }

  // check if a directroy can be used as a directory to perform file operations in
  public function check_dir($path)
  {

    $realpath = tx('Url')->parse($path, \core\Url::PATH);

    //!WARNING: temporary removed directory check
    if(empty($realpath) || (false && $this->paths->keyof($realpath) === false)){
      throw new \exception\Authorisation('The directory \'%s\' is not one of the registered file-handling directories:%s', $realpath, $this->paths->as_array());
    }

    return $realpath;

  }

  // return a new instance of the File dependency
  public function file($source=null)
  {
    return new \dependencies\File($source);
  }

  // return a new instance of the Image dependency
  public function image($source=null)
  {
    return new \dependencies\Image($source);
  }

}
