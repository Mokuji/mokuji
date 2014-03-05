<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Image extends File
{
  
  private
    $image,
    $use_cache=false,
    $jpeg_quality=100,
    $sharpen_after_resize=true,
    $allow_shrink=true,
    $allow_growth=false,
    $original=null,
    $diverted=false;
  
  public function has_diverted()
  {
    return !!$this->diverted;
  }
  
  protected function divert()
  {
    $this->diverted = true;
    mk('Logging')->log('Image', 'Diverted');
  }
  
  public function get_width(){
    return $this->info['width'];
  }
  
  public function get_height(){
    return $this->info['height'];
  }

  //initialize the image
  public function __construct($file=null)
  {

    mk('Logging')->log('Image', 'Constructor ['.$file.'].');
    $this->original = Data();
    parent::__construct($file);

  }

  //destroy the image resource
  public function __destruct()
  {

    mk('Logging')->log('Image', 'Destructor.');
    if(is_resource($this->image)){
      imagedestroy($this->image);
    }

  }

  //enable the usage of cache for the changes made in this image
  public function use_cache($set=true)
  {
    mk('Logging')->log('Image', 'Use cache = '.$set.'.');
    $this->use_cache = (bool) $set;
    return $this;
  }

  //set jpeg quality
  public function jpeg_quality($set=100)
  {
    mk('Logging')->log('Image', 'JPEG quality = '.$set.'.');
    $this->jpeg_quality = (int) ($set > 100 ? 100 : ($set < 0 ? 0 : $set));
    return $this;
  }

  //turn sharpening on or off
  public function sharpening($set=true)
  {
    mk('Logging')->log('Image', 'Sharpening = '.$set.'.');
    $this->sharpen_after_resize = (bool) $set;
    return $this;
  }

  //set the allowance of "shrinking" the image, if set to false, any action that will make the image smaller in dimensions will be canceled
  public function allow_shrink($set=true)
  {
    mk('Logging')->log('Image', 'Allow shrink = '.$set.'.');
    $this->allow_shrink = (bool) $set;
    return $this;
  }

  //set the allowance of "growing" the image, if set to false, any action that will make the image larger in dimensions will be canceled
  public function allow_growth($set=true)
  {
    mk('Logging')->log('Image', 'Allow growth = '.$set.'.');
    $this->allow_growth = (bool) $set;
    return $this;
  }

  //create an image resource from a filepath
  public function from_file($source)
  {

    mk('Logging')->log('Image', 'From file ['.$source.'].');
    parent::from_file($source);
    $this->image = null;
    $this->info($source);

    return $this;

  }

  //creates an image resource
  public function create($width, $height, $color=null, $type='jpeg')
  {

    mk('Logging')->log('Image', 'Create ['.$width.', '.$height.', '.$color.', '.$type.'].');
    $this->image = imagecreatetruecolor((int)$width, (int)$height);
    imagefill($this->image, 0, 0, $this->color($color));
    // header('Content-type: image/jpeg');
    // imagejpeg($this->image);
    // exit;

    $this->source = '';
    $this->dir = '';
    $this->file = '';

    $this->info(array(
      'width' => $width,
      'height' => $height,
      'type' => $type,
      'mime' => 'image/'.$type,
      'extension' => $type
    ));

    return $this;

  }

  //resize the image, caching can be used
  public function resize($width=0, $height=0)
  {
   
    ini_set('memory_limit', -1);
    
    //Create a log entry.
    mk('Logging')->log('Image', 'Resize ['.$width.', '.$height.'].');
    
    //Check if we have something to work with.
    if(empty($this->source)){
      throw new \exception\InputMissing('No image selected. ->save() first.');
    }
    
    //Extract raw values.
    raw($width, $height);
    
    //Create a Rectangle to represent the image.
    $R = new Rectangle($this->info['width'], $this->info['height']);
    
    //Strict resize?
    if($width > 0 && $height > 0){
      $R->set_width($width)->set_height($height)->round();
    }
    
    //Auto-resize based on width?
    if($width > 0){
      $R->set_width($width, true)->round();
    }
    
    //Auto-resize based on height?
    elseif($height > 0){
      $R->set_height($height, true)->round();
    }
    
    //Set the width and height as they are now.
    $width = $R->width();
    $height = $R->height();
    
    // did it grow and is that allowed?
    if($this->allow_growth === false && ($width > $this->info['width'] || $height > $this->info['height'])){
      mk('Logging')->log('Image', 'Resize', 'Tried to grow when not allowed.');
      $this->divert();
      return $this;
    }

    // did it shrink and is that allowed?
    if($this->allow_shrink === false && ($width < $this->info['width'] || $height < $this->info['height'])){
      mk('Logging')->log('Image', 'Resize', 'Tried to shrink when not allowed.');
      $this->divert();
      return $this;
    }

    //Should we look in our cache?
    if($this->use_cache === true)
    {

      // do we have one in our cache?
      $cache_dir = $this->cache_dir();
      $cache_file = $cache_dir.DS.$this->info['name']."_resize-$width-$height".'.'.$this->info['extension'];

      if(is_file($cache_file) && filemtime($this->source) < filemtime($cache_file))
      {

        if($this->original->is_set()){
          $original_data = $this->original->get();
        }

        else{
          $original_data = array(
            'source'  => $this->source,
            'dir'     => $this->dir,
            'file'    => $this->file,
            'info'    => $this->info
          );
        }

        $this->info(null);
        $this->from_file($cache_file);
        $this->original = Data($original_data);
        
        mk('Logging')->log('Image', 'Resize', 'Re-using cached file.');
        
        return $this;
      }

      // do we have an image in our cache which is smaller than the original but bigger than the resize?
      $best = array('w' => $this->info['width'], 'h' => $this->info['height']);

      $cached_files = glob($cache_dir.DS.$this->info['name']."_resize-[0-9]+-[0-9]+".'.'.$this->info['extension']);

      if(is_array($cached_files) && count($cached_files) > 0)
      {
        foreach($cached_files as $file)
        {

          preg_match('~_resize-(?<w>[0-9]+)-(?<h>[0-9]+)~', tx('Url')->parse($file, \core\Url::FILE), $matches);

          if($matches['w'] > $width && $matches['h'] > $height && $matches['w'] < $best['w'] && $matches['h'] < $best['h']){
            $best = array(
              'w' => $matches['w'],
              'h' => $matches['h'],
              'src' => $file
            );
          }

        }
      }

      if(array_key_exists('src', $best))
      {
        if($this->original->is_set()){
          $original_data = $this->original->get();
        }

        else{
          $original_data = array(
            'source'  => $this->source,
            'dir'     => $this->dir,
            'file'    => $this->file,
            'info'    => $this->info
          );
        }

        $this->info(null);
        $this->from_file($best['src']);
        $this->original = Data($original_data);
        
        mk('Logging')->log('Image', 'Resize', 'Found a close match ['.$best['w'].', '.$best['h'].']');
        
      }

    }

    //create the new image
    $new = imagecreatetruecolor($width, $height);

    if($this->info['type'] == 'png'){
      imagealphablending($new, false);
      imagesavealpha($new, true);
      imagefilledrectangle($new, 0, 0, $width, $height, imagecolorallocatealpha($new, 255, 255, 255, 127));
    }

    $this->prepare_sourcefile();

    imagecopyresampled($new, $this->image, 0, 0, 0, 0, $width, $height, $this->info['width'], $this->info['height']); // do the resize in memory
    imagedestroy($this->image);

    //sharpen?
    if($this->sharpen_after_resize === true){
      $this->sharpen($new, $this->info['width'], $width);
    }

    if(!$this->original->is_set()){
      $this->original = Data(array(
        'source'  => $this->source,
        'dir'     => $this->dir,
        'file'    => $this->file,
        'info'    => $this->info
      ));
    }

    $this->image = $new;
    $this->info(array(
      'width'=>$width,
      'height'=>$height,
      'size'=>null
    ));
    
    //Save to the cache?
    if($this->use_cache === true)
    {

      if($cache_dir===false){
        throw new \exception\Programmer('Invalid cache.');
      }

      if($this->original->is_set()){
        $original_data = $this->original->get();
      }

      else{
        $original_data = array(
          'source'  => $this->source,
          'dir'     => $this->dir,
          'file'    => $this->file,
          'info'    => $this->info
        );
      }
      
      
      $this->save($cache_file);
      $this->original = Data($original_data);

      mk('Logging')->log('Image', 'Resize', 'Saved to cache'.$cache_file);
      
    }

    return $this;

  }

  //create a new image based on a crop of the old one, caching can be used
  public function crop($x=0, $y=0, $width=0, $height=0)
  {

    ini_set('memory_limit', -1);

    mk('Logging')->log('Image', 'Crop ['.$x.', '.$y.', '.$width.', '.$height.'].');

    if(empty($this->source)){
      throw new \exception\InputMissing('No image selected. ->save() first.');
    }

    $x = data_of($x);
    $y = data_of($y);
    $width = data_of($width);
    $height = data_of($height);

    //If nothing is set, we don't need to do anything.
    if($width == 0 && $height == 0 && $x == 0 && $y == 0){
      mk('Logging')->log('Image', 'No crop applied (no parameters).');
      return $this;
    }

    //Allow growth?
    //Growth for crop means: get pixels outside of image region.
    if($this->allow_growth === false &&
        ($x < 0 || $y < 0 || $width + $x > $this->info['width'] || $height + $y > $this->info['height']))
    {

      mk('Logging')->log('Image', 'No crop applied (growing where not allowed).');
      $this->divert();
      return $this;

    }

    //Allow shrink?
    //Shrink for crop means: remove pixels from the image through crop.
    if($this->allow_shrink === false &&
        ($x > 0 || $y > 0 || $width < $this->info['width'] || $height < $this->info['height']))
    {
      
      mk('Logging')->log('Image', 'No crop applied (shrinking where not allowed).');
      $this->divert();
      return $this;
      
    }
    
    //Calculate width and height.
    $width = ($width > 0 ? $width : ($this->info['width'] - $x));
    $height = ($height > 0 ? $height : ($this->info['height'] - $y));
    
    //Should we look in our cache?
    if($this->use_cache === true)
    {

      // do we have one in our cache?
      $cache_dir = $this->cache_dir();
      $cache_file = $cache_dir.DS.$this->info['name'].'_crop-'.$x.'-'.$y.'-'.$width.'-'.$height.'.'.$this->info['extension'];

      if(is_file($cache_file) && filemtime($this->source) < filemtime($cache_file))
      {
        if($this->original->is_set()){
          $original_data = $this->original->get();
        }

        else{
          $original_data = array(
            'source'  => $this->source,
            'dir'     => $this->dir,
            'file'    => $this->file,
            'info'    => $this->info
          );
        }

        $this->info(null);
        $this->from_file($cache_file);
        $this->original = Data($original_data);

        return $this;
      }

      //>>TODO look for cropped images that are usable to crop from.

    }

    $new = imagecreatetruecolor($width, $height);
    
    if($this->info['type'] == 'png'){
      imagealphablending($new, false);
      imagesavealpha($new, true);
      imagefilledrectangle($new, 0, 0, $width, $height, imagecolorallocatealpha($new, 255, 255, 255, 127));
    }
    
    $this->prepare_sourcefile();

    imagecopyresampled($new, $this->image, 0, 0, $x, $y, $width, $height, $width, $height);
    imagedestroy($this->image);

    if(!$this->original->is_set()){
      $this->original = Data(array(
        'source'  => $this->source,
        'dir'     => $this->dir,
        'file'    => $this->file,
        'info'    => $this->info
      ));
    }

    $this->image = $new;
    $this->info(array(
      'width'=>$width,
      'height'=>$height,
      'size'=>null
    ));

    //Save to the cache?
    if($this->use_cache === true)
    {

      if($cache_dir===false){
        throw new \exception\Programmer('Invalid cache.');
      }

      if($this->original->is_set()){
        $original_data = $this->original->get();
      }

      else{
        $original_data = array(
          'source'  => $this->source,
          'dir'     => $this->dir,
          'file'    => $this->file,
          'info'    => $this->info
        );
      }

      $this->save($cache_file);
      $this->original = Data($original_data);

    }

    return $this;

  }

  //write text on the image
  public function text($text, $color=null, $font=4, $x=2, $y=null, $line_spacing=3)
  {

    mk('Logging')->log('Image', 'Text ['.$text.', '.$color.', '.$font.', '.$x.', '.$y.', '.$line_spacing.'].');
    $text = (array) $text;

    //calculate if a string needs to be split
    $re = false;
    foreach($text as $key => $string)
    {

      $width = imagefontwidth($font)*strlen($string);

      if($width > ($this->info['width']-($x*2))){
        //$text[$key] = str_split($string, ceil(strlen($string)/2));
        $text[$key] = str_split($string, floor(($this->info['width']-($x*2)) / imagefontwidth($font)));
        $re = true;
      }

    }

    //if the text was too long and has been split
    if($re) return $this->text(array_flatten($text), $color, $font, $x, $y, $line_spacing);

    //calculate heights
    $line_height = imagefontheight($font)+$line_spacing;
    $height = ($line_height * count($text))-$line_spacing+(is_int($y) ? $y : 0);

    //check if it all fits
    if($height > $this->info['height']){
      throw new \exception\Programmer('
        The text does not fit in the image. Try using a smaller font (now %s),
        a larger image (now %s&times;%s), a shorter text (now %s characters) or
        a smaller starting Y position (now %s).',
        $font, $this->info['width'], $this->info['height'], strlen(implode('', $text)), (is_int($y) ? $y : 'automatically calculated')
      );
    }

    //calculate the starting position
    $current_y = (is_int($y) ? $y : ($this->info['height'] / 2) - ($height / 2));

    //prepare
    $this->prepare_sourcefile();

    //create text
    foreach($text as $string)
    {
      imagestring($this->image, $font, $x, $current_y, $string, $this->color($color));
      $current_y += $line_height;
    }

    return $this;

  }

  //save the image to given location (or true to save over old file)
  public function save($save)
  {

    mk('Logging')->log('Image', 'Save ['.$save.'].');
    if(!is_resource($this->image)){
      return parent::save($save);
    }

    $image_function = 'image'.$this->info['type'];

    if(!is_callable($image_function)){
      throw new \exception\Exception('%s not supported.', ucfirst($this->info['type']));
    }

    if($save === true){
      $image_function($this->image, $this->source, ($this->info['type']=='jpeg' ? $this->jpeg_quality : null), null);
    }

    elseif(is_string($save))
    {

      tx('File')->check_dir($save);
      $image_function($this->image, $save, ($this->info['type']=='jpeg' ? $this->jpeg_quality : null), null);
      $this->from_file($save);

    }

    @imagedestroy($this->image);
    $this->image = null;

    return $this;

  }

  //output the image to the browser with the appropriate headers
  public function output($options = null)
  {
    
    mk('Logging')->log('Image', 'Output.');
    //if the image is unmodified
    if(!is_resource($this->image)){
      tx('Logging')->log('Image', 'Output', 'From unchanged file.');
      mk('Logging')->log('Image', 'From unchanged file. '.$this->source);
      header("Accept-Ranges:bytes");
      parent::output();
    }
    
    mk('Logging')->log('Image', 'From changed file.');
    
    header("Accept-Ranges:bytes");
    $this->create_output_headers();
    header("Content-type: image/".$this->info['type'], true);
    
    $image_function = 'image'.$this->info['type'];
    $image_function($this->image, null, ($this->info['type']=='jpeg' ? $this->jpeg_quality : null), null);
    
    tx('Logging')->log('Image', 'Render image', 'SUCCEEDED');
    exit;

  }
  
  //resizes in such a way that the full image fits within the maximum dimensions given.
  public function fit($width=0, $height=0)
  {
    
    //Create a rectangle to represent the image.
    $R = new Rectangle($this->info['width'], $this->info['height']);
    
    //Fit the rectangle in the given dimensions.
    $R->fit($width, $height);
    
    //Do the resize.
    return $this->resize($R->width(), $R->height());
    
  }
  
  //Resizes and crops in such a way that the full dimensions provided
  // are filled with as broad a view of the image possible.
  // Note: when cropping, the image is centered.
  public function fill($width, $height)
  {
    
    //Create a rectangle to represent the image.
    $R = new Rectangle($this->info['width'], $this->info['height']);
    
    //Make the rectangle contain and wrap tight around the given area.
    $R->contain($width, $height, true);
    
    //Do a resize first.
    $this->resize($R->width(), $R->height());
    
    //Find out if we need to do a crop.
    if($R->width() > $width || $R->height() > $height){
      
      //See how much needs to be cropped.
      $hDiff = $R->width() - $width;
      $vDiff = $R->height() - $height;
      
      //Based on that, find the coordinates we need to start our crop from.
      $x = floor($hDiff / 2);
      $y = floor($vDiff / 2);
      
      //Since we already know the width and height, do the crop now.
      $this->crop($x, $y, $width, $height);
      
    }
    
    //Be nice.
    return $this;
    
  }

  // creates, chmods and registers the cache directory if needed, returns the absolute path or false on failure
  private function cache_dir($subfolder=null)
  {

    mk('Logging')->log('Image', 'Cache dir = '.$subfolder.'.');
    //If we're already in the cache folder, return current folder.
    if($this->original->is_set() && $this->original->dir.'cache'.DS == $this->dir){
      return $this->dir;
    }

    if(!is_dir($this->dir.'cache')){
      if(!@mkdir($this->dir.'cache', 0777)){
        return false;
      }
    }

    elseif(substr(decoct(fileperms($this->dir.'cache')), -3) != '777' && !@chmod($this->dir.'cache', 0777)){
      throw new \exception\Restriction(
        'Could not change the permissions of \'%s\'. This could be caused by the server not being the owner the directory and can be '.
        'fixed by customly changing the permissions of the directory to 0777.', $this->dir.'cache'
      );
      return false;
    }

    if($subfolder != null){
      $cache_dir = $this->dir.'cache'.DS.$subfolder;
    }
    else{
      $cache_dir = $this->dir.'cache';
    }
    tx('File')->add_dir($cache_dir.DS);

    return $cache_dir;

  }

  //convert the sourcefile to an image resource
  private function prepare_sourcefile()
  {

    mk('Logging')->log('Image', 'Prepare sourcefile.');
    if(is_resource($this->image)){
      return $this;
    }

    $image_function = "imagecreatefrom{$this->info['type']}";

    if(!is_callable($image_function)){
      throw new \exception\Exception('%s not supported.', ucfirst($this->info['type']));
    }

    ini_set('memory_limit', '-1');
    $this->image = $image_function($this->source);

    return $this;

  }

  //sharpens the image based on original width and final width
  private function sharpen(&$image, $intOrig, $intFinal)
  {

    mk('Logging')->log('Image', 'Sharpen ['.$image.', '.$intOrig.', '.$intFinal.'].');
    $intFinal = $intFinal * (750.0 / $intOrig);
    $intA     = 52;
    $intB     = -0.27810650887573124;
    $intC     = .00047337278106508946;
    $intRes   = $intA + $intB * $intFinal + $intC * $intFinal * $intFinal;

    $sharp = max(round($intRes), 0);
    
    # Use doubles here to fix a 5.5.9 bug: https://bugs.php.net/bug.php?id=66714
    $matrix = array(
        array(-1.0, -2.0, -1.0),
        array(-2.0, (double)$sharp + 12, -2.0),
        array(-1.0, -2.0, -1.0)
    );

    imageconvolution($image, $matrix, $sharp, 0);
    $this->info(array('size'=>null));

  }

  //returns a color that can be used in image functions
  private function color($color)
  {

    mk('Logging')->log('Image', 'Color ['.$color.'].');
    if(!is_array($color))
    {

      switch($color){
        case 'white': $color = array(255, 255, 255); break;
        case 'red': $color = array(255, 0, 0); break;
        case 'green': $color = array(0, 255, 0); break;
        case 'blue': $color = array(0, 0, 255); break;
        case 'black':
        default:
          $color = array(0, 0, 0); break;
      }

    }

    return imagecolorallocate($this->image, $color[0], $color[1], $color[2]);

  }

  //sets info from an image resource, a path to a file or an array with info
  private function info($source)
  {
    
    $source = data_of($source);

    if(is_resource($source))
    {

      $info = array(
        'width' => imagesx($source),
        'height' => imagesy($source),
        'size' => null
      );

    }

    elseif(is_string($source))
    {

      $info = getimagesize($source);

      $info = array(
        'width' => $info[0],
        'height' => $info[1],
        'type' => image_type_to_extension($info[2], false),
        'mime' => $info['mime']
      );

    }

    elseif(is_array($source)){
      $info = $source;
    }

    elseif(is_null($source)){
      $this->info = array();
      return $this;
    }

    $this->info = array_merge($this->info, $info);

    return $this;

  }

}
