<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Resultset extends Data
{
  
  private $model;
  
  // Constructor fills the rows with instances of given model
  public function __construct($result, $model='\\dependencies\\Data')
  {
    
    $rows = array();
    $i = 0;
    while($row = mysql_fetch_assoc($result)){
      $rows[] = new $model($row, $this, $i);
      $i++;
    }
    
    $this->model = $model;
    $this->set($rows);
    
  }
  
  //find a record by primary keys
  public function find()
  {
    
    $model = $this->model;
    $pks = $model::table_data()->primary_keys;
    $args = func_get_args();
    
    if(count($args) !== $pks->size()){
      throw new \exception\InvalidArgument('Expecting the amount of arguments given to equal the amount of primary keys.');
    }
    
    foreach($this as $key => $model)
    {
      
      $primary_keys = $model->having($pks->as_array());
      
      foreach($args as $i => $pk)
      {
        
        if($primary_keys->idx($i)->get() != $pk){
          continue 2;
        }
      
      }
      
      return $model;
    
    }
    
    return Data();
    
  }
  
  // hwalk this resultset to create a list
  public function as_hlist()
  {
    
    $id = null;
    if(func_num_args() == 1){
      if(is_string(func_get_arg(0))){
        $classes = func_get_arg(0);
        $data = null;
      }else{
        $classes = null;
        $data = func_get_arg(0);
      }
    }
    elseif(func_num_args() == 2){
      if(is_array(func_get_arg(0))){
        $options = func_get_arg(0);
        $classes = $options['classes'];
        $id = $options['id'];
      }else{
        $classes = func_get_arg(0);
      }
      $data = func_get_arg(1);
    }
    else{
      $classes = null;
      $data = null;
    }
    
    $list = '<ul'.(is_string($classes) ? ' class="'.$classes.'"' : '').(is_string($id) ? ' id="'.$id.'"' : '').'>'."\n";
    $indent = 2;
    
    $this->hwalk(function($val, $key, $delta)use(&$indent, &$list, $data){
      
      // $properties = array('rel' => $val->ai());
      $properties = array('rel' => $val->id);
      
      $content = (is_null($data)
        ? ($delta > 0
          ? $key
          : $val
        )
        : (is_callable($data)
          ? $data($val, $key, $delta, $properties)
          : $val->extract($data)
        )
      );
      
      $list .= str_repeat(' ', $indent);
      
      if ($delta >= 0) {
        $list .= '<li'.(count($properties) > 0 ? ' '.implode_keys('" ', '="', $properties).'"' : '').'>'.$content;
      }
      
      if ($delta == 0) {
        $list .= '</li>' . "\n";
      }
      elseif ($delta > 0) {
        $indent += 2;
        $list .= '<ul>' . "\n";
      }
      elseif ($delta < 0) {
        $indent -= 2;
        $list .= '</ul></li>'."\n";
      }
      
      
    });
    
    $list .= '</ul>'."\n";
    
    return $list;
    
  }
  
  // hwalk this resultset to create a select field
  public function as_hoptions()
  {
    
    $id = null;
    if(func_num_args() == 1){
      if(is_string(func_get_arg(0))){
        $classes = func_get_arg(0);
        $data = null;
      }else{
        $classes = null;
        $data = func_get_arg(0);
      }
    }
    elseif(func_num_args() == 2){
      if(is_array(func_get_arg(0))){
        $options = func_get_arg(0);
        $classes = $options['classes'];
        $id = $options['id'];
      }else{
        $classes = func_get_arg(0);
      }
      $data = func_get_arg(1);
    }
    else{
      $classes = null;
      $data = null;
    }
    
    $list = '<select'.(is_string($classes) ? ' class="'.$classes.'"' : '').(is_string($id) ? ' id="'.$id.'"' : '').($options['value-location'] === true ? ' onchange="window.location=this.value"' : '').'>'."\n";
    $indent = 0;
    
    $this->hwalk(function($val, $key, $delta)use(&$indent, &$list, $data){
      
      // $properties = array('rel' => $val->ai());
      $properties = array('rel' => $val->id);
      
      $content = (is_null($data)
        ? ($delta > 0
          ? $key
          : $val
        )
        : (is_callable($data)
          ? $data($val, $key, $delta, $properties)
          : $val->extract($data)
        )
      );
      
      if ($delta >= 0) {
        $list .= '<option'.(count($properties) > 0 ? ' '.implode_keys('" ', '="', $properties).'"' : '').'>'.str_repeat('&nbsp;', $indent).$content.'</option>'."\n";
      }
      
      if ($delta > 0) {
        $indent += 2;
      }
      elseif ($delta < 0) {
        $indent -= 2;
      }
      
    });
    
    $list .= '</select>'."\n";
    
    return $list;
    
  }
  
  // multideminsionalizes this resulset based on the hierarchy fields in the models
  public function hdata()
  {
    
    // the model this resultset uses must be an instanceof BaseModel in order to use hierarchy methods
    if(!method_exists($this->model, 'model_data')){
      throw new \exception\Programmer('Can only use hierarchy methods on models. Now using an instance of %s.', $this->model);
    }
    
    $model = $this->model;
    
    // hierarchy fields must be present in model
    if(!(array_key_exists('left', $model::model_data('hierarchy')) && array_key_exists('right', $model::model_data('hierarchy')))){
      throw new \exception\NotFound("Not all hierarchy fields (left and right) have been defined in %s.", $model);
    }
    
    $lft = array_get($model::model_data('hierarchy'), 'left');
    $rgt = array_get($model::model_data('hierarchy'), 'right');
    
    $multidimensionalizer = function($models) use ($lft, $rgt, &$multidimensionalizer)
    {
      
      $skip = 0;
      $i=0;
      $return = Data();
      
      foreach($models as $key => $model)
      {
        
        if($skip > 0){
          $skip--;
          $i++;
          continue;
        }
        
        $gap = $model->{$rgt}->get('int') - $model->{$lft}->get('int');
        
        if($gap > 1){
          $skip = floor($gap/2);
          $return->{null} = $model;
          $return->{null} = $multidimensionalizer($models->slice(($i+1), $skip));
        }
        
        else{
          $return->{null} = $model;
        }
        
        $i++;
        
      }
      
      return $return;
      
    };
    
    return $multidimensionalizer($this);
    
  }
  
  // itterates the resultset and execute callback with a third parameter "delta", which increases or decreases based on the hierarchy fields in the models
  public function hwalk($callback)
  {
    
    // must give a callable callback
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
    }
    
    // the model this resultset uses must be an instanceof BaseModel in order to use hierarchy methods
    if(!method_exists($this->model, 'model_data')){
      throw new \exception\Programmer('Can only use hierarchy methods on models. Now using an instance of %s.', $this->model);
    }
    
    $model = $this->model;
    
    // hierarchy fields must be present in model
    if(!(array_key_exists('left', $model::model_data('hierarchy')) && array_key_exists('right', $model::model_data('hierarchy')))){
      throw new \exception\NotFound("Not all hierarchy fields (left and right) have been defined in %s.", $model);
    }
    
    $lft = array_get($model::model_data('hierarchy'), 'left');
    $rgt = array_get($model::model_data('hierarchy'), 'right');
    
    $walker = function($models) use ($lft, $rgt, &$walker, $callback)
    {

      $models = data_of($models);

      if($models == NULL)
        return;

      $skip=0;
      $i=0;
      $delta=0;
      reset($models);
      
      do
      {
        
        $key = key($models);
        $model = Data(current($models));
        
        // calculate the gap unless this is a reitteration
        $gap = $model->{$rgt}->get('int') - $model->{$lft}->get('int');
        
        // if the current left is one less than the next left, we've got one or more children
        $has_subnodes = false;
        if(next($models)!== false){ 
          $has_subnodes = (Data(current($models))->{$lft}->get('int') === (Data(prev($models))->{$lft}->get('int') + 1));
        }else{
          end($models);
        }

        $callback($model, $key, ($has_subnodes == true ? 1 : $delta));
        
        if($has_subnodes == true)
        {
          $skipTarget = floor($gap/2);
          $skip = 0;
          
          //Verify this skip is correct, by checking the left does not go out of bounds.
          do{
            
            if(next($models) === false)
              break;
            
            $skip++;
            $skipTarget--;
            
            if($model->{$rgt}->get('int') <= current($models)[$lft]){
              prev($models);
              $skip--;
              break;
            }
            
          }while($skipTarget > 0);
          
          //Unwind the array for as much as we wound it up.
          for($j=0; $j < $skip; $j++)
            prev($models);
          
          // array_slices doesn't reset the array pointer(!) -> feedback php.net
          $walker(array_slice($models, ($i+1), $skip));

          $last_subnode = false;
          for($j=0; $j < $skip; $j++)
          {

            if(next($models)===false){
              $last_subnode = true;
              break;
            }

            $i++;

          }

          if($last_subnode) break;

          $delta = -1;
          continue; // reitterate with a negative delta
        }
        
        $delta = 0;
        if(next($models)===false){
          break;
        }
        $i++;
        
      }
      while(true);
      
    };
    
    $walker($this);
    
    return $this;
    
  }
  
  public function as_option_set($key='id')
  {
    
    $option_set = array();
    $model = $this->model;
    
    if((new $model) instanceof BaseModel)
      $title = $model::model_data('title_field');
    else
      $title = 'title';
    
    foreach($this as $row){
      $option_set[$row->{$key}->get()] = $row->{$title}->get();
    }
    
    return $option_set;
    
  }
  
}
