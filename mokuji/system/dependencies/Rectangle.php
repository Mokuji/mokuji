<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Rectangle
{
  
  //Class constants
  const
    UP = 1,
    DOWN = 2,
    AUTO = 3,
    OUTSIDE = 1,
    INSIDE = 2;
  
  //Private properties.
  private
    $width=-1,
    $height=-1;
  
  //Set the width and height.
  public function __construct($width, $height)
  {
    
    //Extract raw data.
    raw($width, $height);
    
    //Set values.
    $this->width = $width;
    $this->height = $height;
    
  }
  
  ##
  ## LOW LEVEL
  ##
  
  //Returns the width.
  public function width()
  {
    
    return $this->width;
    
  }
  
  //Returns the height.
  public function height()
  {
    
    return $this->height;
    
  }
  
  //Set the width, optionally while maintaining aspect ratio.
  public function set_width($width, $maintain_aspect_ratio = false)
  {
    
    //Get raw data.
    raw($width, $maintain_aspect_ratio);
    
    //Don't do much.
    if(!$maintain_aspect_ratio){
      $this->width = $width;
      return $this;
    }
    
    //Maintain aspect ratio.
    $ratio = ($this->width > 0 ? $width / $this->width : 1);
    $this->width = $width;
    $this->height = ($this->height * $ratio);
    
    //Enable chaining.
    return $this;
    
  }
  
  //Set the height, optionally while maintaining aspect ratio.
  public function set_height($height, $maintain_aspect_ratio = false)
  {
    
    //Get raw data.
    raw($height, $maintain_aspect_ratio);
    
    //Don't do much.
    if(!$maintain_aspect_ratio){
      $this->height = $height;
      return $this;
    }
    
    //Maintain aspect ratio.
    $ratio = ($this->height > 0 ? $height / $this->height : 1);
    $this->height = $height;
    $this->width = ($this->width * $ratio);
    
    //Enable chaining.
    return $this;
    
  }
  
  //Round the width and hight numbers back to integers.
  public function round($type = self::AUTO)
  {
    
    //Detect which rounding method to use.
    switch($type){
      case self::UP: $method = 'ceil'; break;
      case self::DOWN: $method = 'floor'; break;
      case self::AUTO: $method = 'round'; break;
    }
    
    //Do the rounding.
    $this->width = $method($this->width);
    $this->height = $method($this->height);
    
    //Enable chaining.
    return $this;
    
  }
  
  
  ##
  ## HIGH LEVEL
  ##
  
  //Fit the rectangle into the given dimensions by resizing it while maintaining aspect ratio.
  public function fit($width = 0, $height = 0, $grow = false)
  {
    
    //Extract raw values.
    raw($width, $height);
    
    //If neither of the arguments are given, do nothing.
    if($width == 0 && $height == 0){
      return $this;
    }
    
    //If the height has not been given, we'll simply set the width.
    if($height == 0){
      return ($grow || $this->width > $width ? $this->set_width($width, true) : $this);
    }
    
    //If the width has not been given, we'll simply set the height.
    if($width == 0){
      return ($grow || $this->height > $height ? $this->set_height($height, true) : $this);
    }
    
    //Get the smallest ratio for each dimension.
    $hRatio = $width / $this->width;
    $vRatio = $height / $this->height;
    $ratio = min($hRatio, $vRatio);
    
    //Do we already fit?
    if(!$grow && $ratio > 1){
      return $this;
    }
    
    //Calculate new dimensions.
    $width = ($this->width * $ratio);
    $height = ($this->height * $ratio);
    
    //Set the width and height.
    $this->set_width($width);
    $this->set_height($height);
    
    //Round down.
    $this->round(self::DOWN);
    
    //Enable chaining.
    return $this;
    
  }
  
  //Fit the rectangle around the given dimensions by resizing it while maintaining aspect ratio.
  public function contain($width = 0, $height = 0, $shrink = false)
  {
    
    //Extract raw values.
    raw($width, $height);
    
    //If neither of the arguments are given, do nothing.
    if($width == 0 && $height == 0){
      return $this;
    }
    
    //If the height has not been given, we'll simply set the width.
    if($height == 0){
      return ($shrink || $this->width < $width ? $this->set_width($width, true) : $this);
    }
    
    //If the width has not been given, we'll simply set the height.
    if($width == 0){
      return ($shrink || $this->height < $height ? $this->set_height($height, true) : $this);
    }
    
    //Get the largest ratio for each dimension.
    $hRatio = $width / $this->width;
    $vRatio = $height / $this->height;
    $ratio = max($hRatio, $vRatio);
    
    //Do we already fit?
    if(!$shrink && $ratio < 1){
      return $this;
    }
    
    //Calculate new dimensions.
    $width = ($this->width * $ratio);
    $height = ($this->height * $ratio);
    
    //Set the width and height.
    $this->set_width($width);
    $this->set_height($height);
    
    //Round up.
    $this->round(self::UP);
    
    //Enable chaining.
    return $this;
    
  }
  
}
