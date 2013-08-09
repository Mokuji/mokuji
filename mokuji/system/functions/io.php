<?php if(!defined('MK')) die('No direct access.');

/**
 * Recursively moves a file or directory and it's contents.
 * @param  string $source   The source location (file or directory) to move from.
 * @param  string $target   The target location (file or directory) to move to.
 * @param  mixed  $conflict Conflict resolution: 'source' > keep source files, 'target' > keep target files, null > throw an exception.
 * @return boolean True if successful.
 */
function recursive_move($source, $target, $conflict=null)
{
  
  //If we spot a file, try and move it.
  if(is_file($source)){
    
    //Ensure the target folder exists.
    $target_dir = dirname($target);
    if(!is_dir($target_dir))
      mkdir($target_dir, 0, true);
    
    //Conflict protection.
    if(is_file($target)){
      
      //Keep the source file.
      if($conflict === 'source'){
        unlink($target);
        rename($source, $target);
      }
      
      //Keep the target file.
      elseif($conflict === 'target'){
        unlink($source);
      }
      
      //Undefined, means an error.
      else
        throw new \Exception("File \"".basename($source)."\" already exists in target folder \"".dirname($target)."\".");
      
    }
    
    //No conflicts, do the move.
    else
      rename($source, $target);
    
    return;
    
  }
  
  //If it's not a file, it should be a dir.
  if(!is_dir($source))
    throw new \Exception("Source \"$source\" is neither a file nor a directory.");
  
  //For each source file in the dir, do it again!
  $files = scandir($source);
  foreach($files as $file){
    
    //Skip these fake locations.
    if(in_array($file, array('.','..'))) continue;
    
    recursive_move($source.DS.$file, $target.DS.$file, $conflict);
    
  }
  
  //In theory all contents are moved. Delete the empty source folder.
  //Note: it could be a symlink to a folder, in which case rmdir should not be used.
  if(is_link($source))
    unlink($source);
  else
    rmdir($source);
  
  return true;
  
}

/**
 * Recursively deletes a file or directory and it's contents.
 * @param  string $location The location (file or directory) to delete.
 * @return boolean True if successful.
 */
function recursive_delete($location)
{
  
  //Files and links are easy.
  if(is_file($location) || is_link($location)){
    unlink($location);
    return true;
  }
  
  //Directories need recursion though.
  if(is_dir($location)){
    
    //For each source file in the dir, do it again!
    $files = scandir($location);
    foreach($files as $file){
      
      //Skip these fake locations.
      if(in_array($file, array('.','..'))) continue;
      
      recursive_delete($location.DS.$file);
      
    }
    
    //Now delete this.
    rmdir($location);
    
    return true;
    
  }
  
  throw new \Exception("Unknown entity on path \"$source\"");
  
}