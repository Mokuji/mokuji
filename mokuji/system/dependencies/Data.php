<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Data extends Successable implements \Serializable, \IteratorAggregate, \ArrayAccess
{
  
  ###
  ###  PROPERTIES
  ###
  
  private
    $key=false,
    $data=null,
    $i=0,
    $context=false;

  
  
  ###
  ###  SYSTEM
  ###
  
  // the constructor sets the data and context
  public function __construct($data=null, $context=false, $key=false)
  {
    
    $this->_set_context($context, $key);
    $this->set($data);
    
  }
  
  // if nothing refers to her anymore, we will kill her children
  public function __destruct()
  {
    
    if($this->is_parent())
    {
      foreach($this->data as $node){
        unset($node);
      }
    }
    
  }
  
  // when this object is cloned, all childnodes will be clones aswell and given a new context
  public function __clone()
  {
    
    if($this->is_parent())
    {
    
      foreach($this->data as $key => $val){
        $this->data[$key] = clone $val;
        $this->data[$key]->_set_context($this, $key);
      }
    
    }
  
  }
  
  // semi-magic method implemented by \Serializable. Called when an instance of this class is serialized and should return serialized data
  public function serialize()
  {
    
    return serialize(array('data'=>$this->data));
    
  }
  
  // semi-magic method implemented by \Serializable. Should fill the new instance created by unserialize with the data given in serialize
  public function unserialize($d)
  {
    
    $data = unserialize($d);
    $this->set($data['data']);
    
  }
  
  // function used internally when it is tried to get a subnode from a string
  public function _attempt_unserialize()
  {
    
    $unserialized = @unserialize($this->get());
    
    if($unserialized === false){
      return false;
    }
    
    return true;
    
  }
  
  // semi-magic method implemented by \IteratorAggregate. Called when this object is iterated by foreach() and should return a new \ArrayIterator(); with data to be iterated as arg
  public function getIterator()
  {
    
    if(!is_array($this->get()))
    {
      
      if($this->is_set() && is_string($this->get()) && $this->_attempt_unserialize()){
        return $this->getIterator();
      }
      
      else{
        $iterator = $this->as_array();
      }
      
    }
    
    else{
      $iterator = $this->get();
    }
    
    // if(count($iterator) == 0 && DEBUG){
      // echo "<!-- Iterating over empty Data($this->key) -->";
    // }
    
    return new \ArrayIterator($iterator);
    
  }
  
  // simi-magic method implemented by \ArrayAccess
  public function offsetGet($key)
  {
    
    return $this->extract($key);
    
  }
  
  // simi-magic method implemented by \ArrayAccess
  public function offsetSet($key, $val)
  {
    
    $this->__set($key, $val);
    
  }
  
  // simi-magic method implemented by \ArrayAccess
  public function offsetExists($key)
  {
  
    return $this->extract($key)->is_set();
  
  }
  
  // simi-magic method implemented by \ArrayAccess
  public function offsetUnset($key)
  {
  
    $this->extract($key)->un_set();
  
  }
  
  
  
  ###
  ###  GETTERS
  ###
  
  // the magic get method returns -and if needed creates- a childnode for us
  public function __get($key)
  {
    
    // if this node has been set to a string, we can assume that it might be a serialized object because we're trying to get a subnode of it
    if($this->is_leafnode() && is_string($this->get())){
      $this->_attempt_unserialize();
    }
    
    // if this is still a leafnode after unserialization, we clear the node's data and turn it into an array to be filled up with the requested subnode
    if($this->is_leafnode()){
      $this->clear();
      $this->data = array();
    }
    
    // extract raw data from the given $key
    $key = data_of($key);
    
    // allow auto-increament by giving null or empty
    if(is_null($key) || is_bool($key) || $key === ''){
      $key = $this->i+1;
    }
    
    // cast floating point numbers to string
    if(is_numeric($key) && !is_int($key)){
      $key = (string) $key;
    }
    
    // we are now sure that this is an array, if the subnode does not exist we will create one
    if(!array_key_exists($key, $this->data))
    {
      
      $this->data[$key] = new Data(null, $this, $key);
      
      if(is_int($key) && $key > $this->i){
        $this->i = $key;
      }
      
    }
    
    // return requested subnode
    return $this->data[$key];
    
  }
  
  public function idx($key)
  {
    
    if($key < 0) $key = $this->size() + $key;
    if($key < 0) $key = 0;

    
    if(empty($this->data)){
      return Data();
    }
      
    reset($this->data);
    $i = 0;

    do{
      if($i < $key){
        $i++;
      }else{
        return current($this->data);
      }
    }
    
    while($i <= $key && next($this->data));
    
  }

  // the extract function accepts different input types to return a childnode, most importantly; an array to create a chain - array('user', 'name') = ->user->name
  public function extract($id=null)
  {
    
    $id = data_of($id);
    
    if(is_array($id))
    {
      
      $return = $this;
      
      foreach($id as $node){
        $return = $return->__get($node);
      }
      
      return $return;
      
    }
    
    return $this->__get($id);
    
  }
  
  // returns the actual value of a node, accepts offset and length to cut strings or arrays
  public function get($as=null)
  {
  
    if(is_null($as)){
      return $this->data;
    }
    
    switch(strtolower($as))
    {
      case 'int':
      case 'integer':
        return (int) $this->data;
      case 'string':
        return (string) $this->data;
      case 'bool':
      case 'boolean':
        return (bool) $this->data;
      case 'float':
        return (float) $this->data;
      case 'double':
        return (double) $this->data;
      case 'array':
        return (array) $this->data;
      default:
        return $this->data;
    }
    
  
  }
  
  // if this object is treated like a string, it's value will be used instead
  public function __toString()
  {
    
    if(!$this->is_set()){
      $return = '';
    }
    
    elseif($this->is_leafnode()){
      $return = $this->get('string');
    }
    
    else{
      $return = "\n";
      foreach($this->data as $node){
        $return .= "$node\n";
      }
    }
    
    return $return;
    
  }
  
  // Returns all content of this node (including its children) as an array
  public function as_array($serialized=false)
  {
    
    if($this->is_empty()){
      return array();
    }
    
    if($this->is_leafnode()){
      return array($this->data);
    }
    
    //create output array
    $array = array();
    
    //for every value
    foreach($this->data AS $key => $val)
    {
      
      //if it is set
      if($val->is_set())
      {
        
        //if val is a leafnode
        if($val->is_leafnode())
        {
          //extract its value
          $array[$key] = $val->get();
        }
        
        //if val is not a leafnode
        else
        {
          //convert its value to a subarray, or a serialized Data object
          $sub = $val->as_array();
          
          if(count($sub) > 0){
            $array[$key] = ($serialized===true ? $val->serialized() : $sub);
          }
          
        }
        
      }
      
    }
    
    return $array;
    
  }
  
  // Iterates this node to create an html select field
  // as_options($name, $title, $value[, $default[, $tooltip[, $multiple[, $placeholder_text]]]])
  public function as_options()
  {
    
    //If we're empty then nothing should be done.
    if($this->is_empty())
      return;
    
    //arguments
    if(func_num_args() < 3){
      throw new \exception\InvalidArgument('Expecting at least three arguments to be passed to Data::as_options()');
    }
    
    $name = func_get_arg(0);
    $title = func_get_arg(1);
    $value = func_get_arg(2);
    $options = func_num_args() > 3 ? Data((array)func_get_arg(3)) : Data();//default, tooltip, multiple, placeholder_text

    //select
    $select = "\n".'<select'.($options->id->is_set() ? ' id="'.$options->id.'"' : '').' class="tx-select" name="'.$name.'"'.($options->multiple->get() ? ' multiple="multiple"' : '').'>'."\n\n";
    if(!$options->multiple->get() && !$options->force_choice->is_true())
      $select .= '  <option value="">-- '.__($options->placeholder_text->is_set() ? $options->placeholder_text->get('string') :'Please select an option', 1).' --</option>'."\n\n";
    
    //Unwind $default.
    if(is_array(data_of($options->default)))
      $options->default = $options->default->as_array();
    else
      $options->default = data_of($options->default);
    
    //options
    foreach($this->getIterator() as $row)
    {
      
      if(!$row instanceof \dependencies\Data)
        throw new \exception\InvalidArgument('Input is not a multidimentional Data object. Type found: %s', ucfirst(gettype($row)));
      
      //resolve title
      if(is_string($title)){
        $title_str = $row->__get($title);
      }
      
      elseif(is_callable($title)){
        $title_str = $title($row);
      }
      
      else{
        throw new \exception\InvalidArgument('$title is of invalid datatype '.ucfirst(gettype($title)).'. String or Callable expected.');
      }
      
      //See if we need to apply indenting.
      if($options->indent_field->is_set()){
        $indent_field = $options->indent_field->get('string');
        $depth = max(0, $row->__get($indent_field)->get('int') - 1);
        $title_str = str_repeat('&nbsp;|-&nbsp;', $depth) . $title_str;
      }
      
      //resolve value
      if(is_string($value)){
        $value_str = data_of($row->__get($value));
      }
      
      elseif(is_callable($value)){
        $value_str = $value($row);
      }
      
      else{
        throw new \exception\InvalidArgument('$value is of invalid datatype '.ucfirst(gettype($value)).'. String or Callable expected.');
      }
      
      //resolve default
      if(is_callable($options->default->get())){
        $call = $options->default->get();
        $default_bool = $call($row);
      }
      
      elseif(is_array($options->default->get())){
        $default_bool = in_array($value_str, $options->default->get());
      }
      
      else{
        $default_bool = $options->default->get() == $value_str;
      }
      
      //resolve tooltip
      if(is_string($options->tooltip->get())){
        $tooltip_str = $row->__get($options->tooltip->get());
      }
      
      elseif(is_callable($options->tooltip->get())){
        $call = $options->tooltip->get();
        $tooltip_str = $call($row);
      }
      
      elseif($options->tooltip->get() != null){
        throw new \exception\InvalidArgument('$options->tooltip is of invalid datatype '.ucfirst(gettype($options->tooltip->get())).'. String or Callable expected.');
      }
      
      else{
        $tooltip_str = '';
      }
      
      //resolve rel
      if(is_string($options->rel->get())){
        $rel_str = $row->__get($options->rel);
      }else{
        $rel_str = '';
      }

      $select .= '  <option rel="'.$rel_str.'" value="'.$value_str.'" title="'.str_max(trim(strip_tags($tooltip_str)), 80, '...').'"'.($default_bool ? ' selected="selected"' : '').'>'.$title_str.'</option>'."\n\n";
      
    }
    
    //end select
    $select .= '  </select>'."\n\n";
    
    return $select;
    
  }
  
  // Itterates this node to create an html table
  public function as_table()
  {
    
    //arguments
    if(func_num_args() < 1){
      throw new \exception\InvalidArgument('Expecting at least one argument to be passed to Data::as_table()');
    }
    
    elseif(is_array(func_get_arg(0))){
      $name = null;
      $data = func_get_arg(0);
      $foot = func_num_args() > 1 ? func_get_arg(1) : null;
    }
    
    elseif(func_num_args() < 2){
      throw new \exception\InvalidArgument('Expecting argument two to be given when argument one is of type "string" in Data::as_table()');
    }
    
    else{
      $name = func_get_arg(0);
      $data = func_get_arg(1);
      $foot = func_num_args() > 2 ? func_get_arg(2) : null;
    }
    
    //table
    $table = "\n".'<table class="tx-table">'."\n\n";
    
    //caption
    $table .= is_string($name) ? '  <caption class="tx-table-caption">'.$name.'</caption>'."\n\n" : '';
    
    //table head
    $table .= '  <thead class="tx-table-head">'."\n";
    $table .= '    <tr>'."\n";
    foreach($data as $key => $val){
      $table .= '      <th'.(is_array($val) ? ' colspan="'.count($val).'"' : '').'>'.(is_string($key) ? $key : '&nbsp;').'</th>'."\n";
    }
    $table .= '    </tr>'."\n";
    $table .= '  </thead>'."\n\n";
    
    //table footer
    $table .= '  <tfoot class="tx-table-foot">';
    if(is_array($foot))
    {
      
      $table .= "\n".'    <tr>'."\n";
      
      foreach($data as $key => $val)
      {
        
        if(is_array($val) && is_array($foot[$key]))
        {
          
          foreach($val as $i => $v){
            $table .= '      <td>'.(array_key_exists($key, $foot) ? $foot[$key][$i] : '&nbsp;').'</td>'."\n";
          }
          
        }
        
        else{
          $table .= '      <td'.(is_array($val) ? ' colspan="'.count($val).'"' : '').'>'.(array_key_exists($key, $foot) ? $foot[$key] : '&nbsp;').'</td>'."\n";
        }
        
      }
      
      $table .= '    </tr>'."\n";
      
    }
    $table .= '  </tfoot>'."\n\n";
    
    //table body
    $table .= '  <tbody class="tx-table-body">'."\n";
    foreach($this->getIterator() as $row)
    {
      
      $table .= '    <tr>'."\n";
      foreach($data as $key => $val)
      {
        
        if(!is_array($val)){
          $val = array($val);
        }
        
        foreach($val as $i => $v)
        {
          
          if(is_string($v)){
            $table .= '      <td>'.($row->__get($v)->is_set() ? $row->__get($v) : '&nbsp;').'</td>'."\n";
          }
          
          elseif(is_callable($v)){
            $table .= '      <td>'.$v($row).'</td>'."\n";
          }
          
        }
      
      }
      $table .= '    </tr>'."\n";
      
    }
    $table .= '  </tbody>'."\n\n";
    
    //close table
    $table .= '</table>'."\n";
    
    return $table;
    
    
  }

  // Iterates this node to create a list
  public function as_list()
  {
    
    if(func_num_args() == 1){
      $classes = null;
      $data = func_get_arg(0);
    }
    elseif(func_num_args() == 2){
      $classes = func_get_arg(0);
      $data = func_get_arg(1);
    }
    else{
      $classes = null;
      $data = null;
    }
    
    $list = '<ul'.(is_string($classes) ? ' class="'.$classes.'"' : '').'>'."\n";
    
    $this->each(function($val, $key)use(&$list, $data){
      
      $properties = array();
      
      if(is_null($data)){
        $content = ($val->is_parent() ? $key : $val);
      }
      
      elseif($data instanceof \Closure){
        $content = $data($val, $key, $properties);
      }
      
      else{
        $content = $val->extract($data);
      }
      
      $list .= '<li'.(count($properties) > 0 ? ' '.implode_keys('" ', '="', $properties).'"' : '').'>'.$content.'</li>';
      
    });
    
    $list .= '</ul>'."\n";
    
    return $list;
    
  }
  
  // Itterates this node and its children to create a list
  public function as_rlist()
  {
    
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
      $classes = func_get_arg(0);
      $data = func_get_arg(1);
    }
    else{
      $classes = null;
      $data = null;
    }
    
    $list = '<ul'.(is_string($classes) ? ' class="'.$classes.'"' : '').'>'."\n";
    $indent = 2;
    
    $this->walk(function($val, $key, $delta)use(&$indent, &$list, $data){
      
      $properties = array();
      
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
      
      if($delta >= 0){
        $list .= '<li'.(count($properties) > 0 ? ' '.implode_keys('" ', '="', $properties).'"' : '').'>'.$content;
      }
      if($delta == 0){
        $list .= '</li>'."\n";
      }
      elseif($delta > 0){
        $indent += 2;
        $list .= '<ul>'."\n";
      }
      elseif($delta < 0){
        $indent -= 2;
        $list .= '</ul></li>'."\n";
      }
      
    });
    
    $list .= '</ul>'."\n";
    
    return $list;
    
  }
  
  // Returns all content of this node (including its children) as JSON
  public function as_json($flags = JSON_FORCE_OBJECT, $options = 0)
  {
    return json_encode($this->as_array(), $flags);
  }
  
  // returns string representation of all this node's data
  public function dump($format = true, $l=0)
  {
    
    $output = ($this->is_godnode() ? get_class($this) : '['.$this->key.']').' = ';
    
    if($this->is_leafnode()){
      $output .= var_export($this->get(), true);
    }
    
    else
    {
      $l++;
      $output .= ($format ? "\n".str_repeat('  ', $l) : '').get_class($this).'(';
      foreach($this->data as $data){
        $output .= ($format ? "\n".str_repeat('  ', $l+1) : '').$data->dump($format, $l+1).', ';
      }
      $output .= ($format ? "\n".str_repeat('  ', $l) : '').')';
      
    }
    
    return $output;
  
  }

  // Returns serialized string representation of this instance
  public function serialized()
  {
    return serialize($this);
  }
  
  // if the value of this node is a serialized value, this function will return the unserialized result
  public function unserialized()
  {
    
    if(!is_string($this->get())){
      throw new \exception\InvalidArgument('Can not unserialize anything other than a string. This is a %s.', $this->type());
    }
    
    $unserialized = unserialize($this->get());
    
    if($unserialized === false){
      throw new \exception\Unexpected('Could not unserialize.');
    }
    
    return $unserialized;
    
  }
  
  
  
  ###
  ###  CONVERTERS
  ###
  
  // sets this node the the return value of $this->{$converter}([argument[, ...]])
  public function convert()
  {
    
    if(func_num_args() == 0){
      throw new \exception\InvliadArguments('Expecting at least one argument to be passed to Data::convert()');
    }
    
    $arguments = func_get_args();
    $converter = array_shift($arguments);
    
    if(!is_string($converter)){
      throw new \exception\InvliadArguments('Data::convert() is expecting argument 1 to be string. %s given.', ucfirst(gettype(func_get_arg(0))));
    }
    
    if(!method_exists($this, $converter)){
      throw new \exception\InvliadArguments('Expecting $converter (argument 1 passed to Data::convert()) to be the name of a method of \dependencies\Data, "%s" given.', $converter);
    }
    
    $return = call_user_func_array(array($this, $converter), $arguments);
    
    if(!is_data($return)){
      throw new \exception\Programmer('Method "%s" executed by Data::convert() did not return a Data node.', $converter);
    }
    
    return $this->set($return);
    
  }

  
  
  ###
  ###  RETURNS NEW DATA OBJECTS
  ###
  
  // return a deep clone of $this, the clone will not be in the same context
  public function copy()
  {
    return clone $this;
  }
  
  // return the parent of this node, false when without parent
  public function & back()
  {
    return $this->context;
  }
  
  // returns a copy of this node having only the subnodes of which the keys were in the argument list passed to having
  public function having()
  {
    
    $return = Data();
    
    if(func_num_args() == 1 && is_array(func_get_arg(0))){
      $keys = func_get_arg(0);
    }
    
    else{
      $keys = array_flatten(func_get_args());
    }
    
    foreach($keys as $key1 => $key2)
    {
      
      if(is_string($key1)){
        $return->__get($key1)->set($this->__get($key2));
      }
      
      else{
        $return->__get($key2)->set($this->__get($key2));
      }
      
    }
    
    return $return;
    
  }
  
  // returns a copy of this node without having the subnodes of which the keys were in the argument list passed to without
  public function without()
  {
    
    $return = $this->copy();
    
    if(func_num_args() == 1 && is_array(func_get_arg(0))){
      $keys = func_get_arg(0);
    }
    
    else{
      $keys = array_flatten(func_get_args());
    }
    
    foreach($keys as $key1 => $key2)
    {
      
      if(is_string($key1)){
        $return->__get($key1)->un_set();
      }
      
      else{
        $return->__get($key2)->un_set();
      }
      
    }
    
    return $return;
    
  }
  
  // returns a copy of this node having only the subnodes which made the given callback return true
  public function filter($callback)
  {
    
    if($this->is_leafnode()){
      return $this;
    }
    
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
    }
    
    $return = Data();
    
    foreach($this as $k => $v){
      if($callback($v, $k) === true){
        $return->__get($k)->set($v);
      }
    }
    
    return $return;
    
  }
  
  // returns a new node containing the formatted string based on the contents of this node
  public function format($format = '%s')
  {
    
    if($this->is_empty()){
      return Data();
    }
    
    return Data(sprintf($format, $this->get()));
    
  }
  
  // returns a new node containing the given value of this node is empty
  public function otherwise($default)
  {
    
    return ($this->is_empty() ? Data($default) : $this);
    
  }
  
  // map as new DataArray
  public function map($callback)
  {
    
    $array = array();
    
    foreach($this as $key => $node)
    {
      
      if($node->is_set())
      {
        
        $val = $callback($node, $key);
        
        if(is_array($val) && count($val) == 1 && is_string(key($val))){
          $array[key($val)] = current($val);
        }
        
        elseif(is_array($val)){
          $array = array_merge($array, array_values($val));
        }
        
        elseif(is_null($val)){
          continue;
        }
        
        else{
          $array[] = $val;
        }
        
      }
      
    }
    
    return Data($array);
    
  }
  
  // trim specified characters off the start end end of the node
  public function trim($charlist=' ')
  {
    
    if(!$this->is_set()){
      return Data();
    }
    
    if($this->is_leafnode()){
      return Data(trim($this->get('string'), $charlist));
    }
    
    else
    {
      
      return $this->copy()->walk(function($node)use($charlist){
        if($node->is_leafnode()){
          $node->set(trim($node->get('string'), $charlist));
        }
      });
      
    }
    
  }
  
  // split the string value of this node into pieces, give string to use it as delimiter or int to split into chunks of given size
  public function split($s=null)
  {
    
    if($this->is_empty()){
      return Data();
    }
    
    if($this->type() !== 'string'){
      throw new \exception\Restriction('Can only Data::split() text nodes. This is a %s node.', $this->type());
    }
    
    if(empty($s) || (is_int($s) && $s < 1)){
      $split = str_split($this->__toString());
    }
    
    elseif(is_int($s)){
      $split = str_split($this->__toString(), $s);
    }
    
    elseif(is_string($s)){
      $split = explode($s, $this->__toString());
    }
    
    return Data($split);
    
  }
  
  // returns a string created of all childnodes converted to string and joined together by the given $separator
  public function join($separator='')
  {
    
    $return = '';
    $s = '';
    
    foreach($this as $key => $val){
      $return .= $s . $val;
      $s = $separator;
    }
    
    return Data($return);
    
  }
  
  // returns a slice of the string or array
  public function slice($offset=0, $length=null)
  {
    
    switch($this->type()){
      case 'array': return Data(array_slice($this->data, $offset, $length));
      case 'string': return Data(substr($this->data, $offset, $length));
      default: throw new \exception\Programmer('Can only ->slice() strings or arrays. This is a %s.', $this->type());
    }
    
  }
  
  // perform a regular expression and return a new data node containing the matches
  public function parse($regex, $flags=0)
  {
    
    if($this->type() !== 'string'){
      throw new \exception\Restriction('Can only Data::parse() text nodes. This is a %s node.', $this->type());
    }
    
    if(!is_string($regex)){
      throw new \exception\Restriction('Expecting $regex to be string. %s given.', ucfirst(gettype($regex)));
    }
    
    try{
      preg_match($regex, $this->get(), $matches, $flags);
      return Data($matches);
    }
    
    catch(\exception\Error $e){
      throw new \exception\Programmer('An error occured while parsing "%s" using "%s": %s', $this->get(), $regex, $e->getMessage());
    }
    
  }
  
  // returns a lowercased version of the node
  public function lowercase()
  {
    
    if(!$this->is_set()){
      return Data();
    }
    
    if($this->is_leafnode()){
      return Data(strtolower($this->get('string')));
    }
    
    else
    {
      
      return $this->copy()->walk(function($node){
        if($node->is_leafnode()){
          $node->set(strtolower($node->get('string')));
        }
      });
      
    }
    
  }
  
  // returns an uppercased version of the node
  public function uppercase()
  {
    
    if(!$this->is_set()){
      return Data();
    }
    
    if($this->is_leafnode()){
      return Data(strtoupper($this->get('string')));
    }
    
    else
    {
      
      return $this->copy()->walk(function($node){
        if($node->is_leafnode()){
          $node->set(strtoupper($node->get('string')));
        }
      });
      
    }
    
  }
  
  // returns an md5 hashed copy of this node
  // :'[ why did you do this???
  // I hope I can deprecate this soon
  public function md5()
  {
    
    if(!$this->is_set()){
      return Data();
    }
    
    if($this->is_leafnode()){
      return Data(md5($this->get('string')));
    }
    
    else
    {
      
      return $this->copy()->walk(function($node){
        if($node->is_leafnode()){
          $node->set(md5($node->get('string')));
        }
      });
      
    }
    
  }
  
  // returns a version of this node with all strings html escaped
  public function html_escape($flags = 50)
  {
    
    if(!$this->is_set()){
      return Data();
    }
    
    if($this->is_leafnode()){
      return Data(htmlentities($this->get('string'), $flags, 'UTF-8'));
    }
    
    else
    {
      
      return $this->copy()->walk(function($node)use($flags){
        if($node->is_leafnode()){
          $node->set(htmlentities($node->get('string'), $flags, 'UTF-8'));
        }
      });
      
    }
    
  }
  
  // returns a reversed (reversing done based on datatype) copy of this node
  public function reverse()
  {
    
    if($this->is_leafnode())
    {
      
      switch($this->type())
      {
        case 'string':
          $reversed = strrev($this->get());
          break;
        default:
          return $this;
      }
      
    }
    
    else{
      $reversed = array_reverse($this->get());
    }
    
    return Data($reversed);
    
  }
  
  
  
  ###
  ###  SETTERS
  ###
  
  // the magic set function calls ->set()
  public function __set($key, $val)
  {
    
    $this->extract($key)->set($val);
  
  }
  
  // Converts given data to Data objects and sets the data of this node to it. args([mixed $merge,] mixed $val)
  public function set()
  {
    
    //handle arguments
    switch(func_num_args())
    {
      case 1:
        $val = func_get_arg(0);
        $merge = false;
        break;
      case 2:
        $val = func_get_arg(1);
        $merge = (func_get_arg(0) === 0 ? false : func_get_arg(0));
        break;
      default:
        throw new \exception\InvalidArgument('Expecting one or two arguments for Data::set([mixed $merge, ]mixed $val). %s Given', func_num_args());
        return $this;
    }
    
    //break out of closures
    while($val instanceof \Closure){
      $val = $val($this);
    }
    
    //break out of Data objects
    if(is_data($val)){
      $val = $val->get();
    }
    
    //setting empty data is unsetting
    if($merge === false && ($val === null || $val === array())){
      $this->un_set();
      return $this;
    }
    
    //clear before setting
    if($merge === false){
      $tmpdata = $this->data;
      $this->clear();
    }
    
    //we will loop through the array, and put each individual value in our data
    if(is_array($val))
    {
      
      //set data to be an empty array
      if($merge === false || $this->is_leafnode()){
        $this->data = array();
      }
      
      //put the given array into the data object
      foreach($val AS $key => $subval)
      {
        
        //if a data object is inserted as value, store a copy of that object to prevent it being in multiple Data nodes
        if(is_data($subval))
        {
          
          if($subval === $this){
            $subject = Data($tmpdata);
          }else{
            $subject = $subval->copy();
          }
          
          $subject->_set_context($this, $key);
          
          if($merge !== false && array_key_exists($key, $this->data)){
            $merged = $this->data[$key]->copy()->set((is_int($merge) ? $merge-1 : $merge), $subject);
            $subject->set($merged);
          }
          
        }
        
        //if anything other than a Data node was inserted, we will create a new node or merge over the old one
        else
        {
          
          if($merge !== false && array_key_exists($key, $this->data)){
            $subject = $this->data[$key]->set((is_int($merge) ? $merge-1 : $merge), $subval);
          }
          
          else{
            $subject = new Data($subval, $this, $key);
          }
          
        }
        
        if(is_int($key) && $key > $this->i){
          $this->i = $key;
        }
        
        $this->data[$key] = $subject;
        
      }
      
    }
    
    //unless it's something else, in which case we'll assume that it is a leafnode
    else
    {
      
      $this->data = $val;
      
    }

    return $this;
  
  }
  
  // Pushes a new value into this node: push([$key=null, ]$val)
  public function push()
  {
    
    if(func_num_args() == 1){
      $key = null;
      $val = func_get_arg(0);
    }
    
    elseif(func_num_args() == 2){
      $key = func_get_arg(0);
      $val = func_get_arg(1);
    }
    
    else{
      throw new \exception\InvalidArguments('Data::push one or two arguments. %s Given.', func_num_args());
    }
    
    $this->__get($key)->set($val);
    
    return $this;
    
  }
  
  // Converts given data to Data objects and merges it with the data already present. $deep can be set to any interger to merge into that level of depth
  public function merge($val, $deep=true)
  {
    
    return $this->set($deep, $val);
    
  }
  
  // have this node 'become'- or in essense; inside it's context be replaced by- given Data
  public function become(Data $data)
  {
    
    if($this->is_childnode()){
      $this->context->data[$this->key] = $data->copy()->_set_context($this->context, $this->key);
      $this->_clear_context();
      return $data;
    }
    
    else{
      return $this->set($data->copy()->get());
    }
    
  }
  
  // moves this node to given variable, and return the variable for chaining
  public function & moveto(&$to)
  {
  
    $return =& $this->copyto($to);
    $this->un_set();
    $this->_clear_context();
    
    return $return;
    
  }
  
  // does the same as move, but also keeps this node present at it's former location
  public function & copyto(&$to)
  {
    
    if(is_data($to) && $to->is_childnode()){
      $to->become($this);
    }
    
    else{
      $to = $this->copy();
      $to->_clear_context();
    }
    
    return $to;
    
  }
  
  // un_set's this node, or if arguments are given, the nodes inside with names corresponding to the given arguments
  public function un_set()
  {
    
    if(func_num_args() > 0){
      foreach(func_get_args() as $key){
        $this->__get($key)->un_set();
      }
      return $this;
    }
    
    $this->clear();
    
    if($this->is_childnode()){
      $this->context->data[$this->key] = null;
      unset($this->context->data[$this->key]);
    }
    
    return $this;
    
  }
  
  // remove all data inside this node
  public function clear()
  {
    
    $this->i = 0;
    $this->data = null;
    return $this;
    
  }
  
  // redirect unset() to the data array, and unset self if this contains no more data
  public function __unset($key)
  {
    
    $this->data[$key]->clear();
    
    if($this->size() == 0){
      $this->clear();
    }
    
  }
  
  // used internally to handle context
  public function _set_context($context, $key)
  {
    
    $this->context = $context;
    $this->key = $key;
    
    if(!$this->is_leafnode())
    {
      
      foreach($this->data as $key=>$node){
        $node->_set_context($this, $key);
      }
      
    }
    
    return $this;
    
  }
  
  // used internally to handle context
  public function _clear_context()
  {
    
    $this->context = false;
    $this->key = false;
    
    return $this;
    
  }
  
  
  
  ###
  ###  INFORMATION
  ###
  
  // returns true if the value of this node is equal to true
  public function is_true()
  {
  
    return $this->get() === true;
  
  }
  
  // returns true if the value of this node is equal to false
  public function is_false()
  {
  
    return $this->get() === false;
  
  }
  
  // returns true if this node is set, and false if it's node
  public function is_set()
  {
    
    return ! is_null($this->data);
    
  }
  
  // returns true if this node has no children
  public function is_leafnode()
  {
    
    return ! is_array($this->data);
    
  }
  
  // returns true if this node has a parent node
  public function is_childnode()
  {
    
    return ($this->context !== false);
    
  }
  
  // returns true if this node has childnodes (is not a leafnode)
  public function is_parent()
  {
    
    return is_array($this->data);
    
  }
  
  // returns true if this node has no parents
  public function is_godnode()
  {
    
    return ($this->context === false);
    
  }
  
  // returns true for empty nodes
  public function is_empty()
  {
    
    return empty($this->data);
    
  }
  
  // returns true if the value of this node is numeric
  public function is_numeric()
  {
    return is_numeric($this->get());
  }
  
  // returns (int) depth of this node, starting from 1 (first generation) for godnodes
  public function generation()
  {
    
    $i = 1;
    $current = $this;
    
    while($current = $current->back()){
      $i++;
    }
    
    return $i;
    
  }
  
  // returns the size of this node: the number of _set_ children or the number of characters
  public function size()
  {
    
    switch($this->type()){
      case 'string': return strlen($this->get());
      case 'array': 
        $size = 0;
        foreach($this->data as $v){if($v->is_set()) $size++;}
        return $size;
      case 'integer':
      case 'float':
      case 'double':
        return $this->get();
      case 'NULL':
        return 0;
    }
    
  }
  
  // returns datatype
  public function type()
  {
    
    return gettype($this->data);
    
  }
  
  // returns the keys of the childnodes
  public function keys()
  {
    
    if($this->is_leafnode()){
      return false;
    }
    
    return Data(array_keys($this->data));
    
  }
  
  // returns the key name that this node is assigned to in it's parent, false if without parent
  public function key()
  {
    
    return $this->key;
    
  }
  
  // returns true if the node by given name has a value that could be interpreted as "true"
  public function check($node_name)
  {
    
    return ($this->is_set() && $this->is_parent() && array_key_exists($node_name, $this->data) && $this->data[$node_name]->get() == true);
    
  }
  
  // returns the key of given data node (or data inside the data node), false if not found
  public function keyof($node)
  {
    
    if($this->is_leafnode()){
      return false;
    }
    
    if(is_data($node)){
      return array_search($node, $this->data, true);
    }
    
    $key = false;
    
    foreach($this->data as $k => $v){
      if($v->get() === $node){
        $key = $k;
        break;
      }
    }
    
    return $key;
    
  }
  
  
  
  ###
  ###  VALIDATION
  ###
  
  public function add_rules()
  {
    
    throw new \exception\Deprecated('Rules are now directly passed to Data::validate()');
    
  }
  
  // validates given rules
  public function validate($name, array $rules, $translate=true)
  {
    
    $validator = new Validator($this->get(), $rules, $translate);
    
    if($validator->failure())
    {
      
      $errors = $validator->errors();
      for($i = 0, $total = count($errors), $sep = '', $msg = ''; $i < $total; $i++){
        $msg .= $sep.strtolower(substr($errors[$i], 0, 1)).substr($errors[$i], 1);
        $sep = ', ';
        if($i == $total-2) $sep = ' and ';
      }
      
      $message = ucfirst($msg).'.';
      
      $e = new \exception\Validation("'%s' has an invalid format: %s", ucfirst($name), $message);
      $e->key($this->key());
      $e->value($this->get());
      $e->title($name);
      $e->errors($errors);
      
      throw $e;
      
    }
    
    return $this->set($validator->get_data());
    
  }
  
  // calls the _enforce_[rule] method for every [rule] set in $this->rules, expecting that method to then shape the data of this node to obey the rules
  public function enforce_rules($recursive=false)
  {
  
    throw new \exception\Deprecated('Conversions are now made using Data::convert()');
  
  }
  
  // returns array of validation errors
  public function validation_errors($names=array())
  {
    throw new \exception\Deprecated('Validation errors are now thrown in an \exception\Validation.');
  }
  
  
  
  ###
  ###  EXTENDING SUCCESSABLE
  ###
  
  // uses successable to implement greater then with short notation
  public function gt($value, $callback=null)
  {
    
    return $this->is($this->data > data_of($value), $callback);
    
  }
  
  // uses successable to implement lesser then with short notation
  public function lt($value, $callback=null)
  {
  
    return $this->is($this->data < data_of($value), $callback);
    
  }
  
  // uses successable to implement equals with short notation
  public function eq($value, $callback=null)
  {
  
    return $this->is($this->data == data_of($value), $callback);
    
  }
  
  // extend parent::is() functionality with the possibility to give strings to check for $this->is_[check]()
  public function is($check, $callback=null)
  {
    
    
    if(is_string($check))
    {
      
      if(!method_exists($this, "is_$check")){
        throw new \exception\InvalidArgument('%s is not a valid check.', ucfirst($check));
      }
      
      return parent::is($this->{"is_$check"}(), $callback);
      
    }
    
    else{
      return parent::is($check, $callback);
    }
    
  }
  
  // extend parent::not() functionality with the possibility to give strings to check for !$this->is_[check]()
  public function not($check, $callback=null)
  {
  
    if(is_string($check))
    {
      
      if(!method_exists($this, "is_$check")){
        throw new \exception\InvalidArgument('%s is not a valid check.', ucfirst($check));
      }
      
      return parent::not($this->{"is_$check"}(), $callback);
      
    }
    
    else{
      return parent::not($check, $callback);
    }
  
  }
  
  
  
  ###
  ###  ITTERATORS
  ###
  
  // call $callback($val, $key) for each node in this Data object
  public function each($callback)
  {
    
    
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
      return $this;
    }
    
    foreach($this as $key => $node){
      $r = $callback($node, $key);
      if($r === false){
        break;
      }
    }
    
    return $this;
    
  }
  
  // the same as each, except returns false when one fails the truth test
  public function all($callback)
  {
    
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
      return $this;
    }
    
    foreach($this as $key => $node){
      $r = $callback($node, $key);
      if($r === false){
        return false;
      }
    }
    
    return true;
    
  }
  
  // the same as each, except returns false when all fail the truth test
  public function any($callback)
  {
    
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
      return $this;
    }
    
    foreach($this as $key => $node){
      $r = $callback($node, $key);
      if($r === true){
        return true;
      }
    }
    
    return false;
    
  }
  
  // call $callback($val, $key, $delta) for each node and subnodes in this Data object
  public function walk($callback)
  {
    
    // must give a callable callback
    if(!is_callable($callback)){
      throw new \exception\InvalidArgument('Expecting $callback to be callable. It is not.');
    }
    
    $walker = function($nodes) use (&$walker, $callback)
    {
    
      $nodes = $nodes->get();
      $delta = 0;
      
      do
      {
      
        $key = key($nodes);
        $node = current($nodes);
        $delta = ($delta==0 && $node->is_parent() ? 1 : $delta);
        $callback($node, $key, $delta);
      
        if($node->is_parent() && $delta >= 0){
          $walker($node);
          $delta = -1;
          continue;
        }
        
        $delta = 0;
        if(next($nodes)===false) break;
      
      }
      while(true);
    
    };
    
    $walker($this);
    
    return $this;
    
  }
  
  ###
  ###  Sorting
  ###
  
  /**
   * Sorts the data object by key.
   *
   * @author Beanow
   * @return Data Returns $this
   */
  public function ksort()
  {
    
    if(gettype($this->data) == 'array')
      ksort($this->data);
    
    return $this;
    
  }
  
}
