<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Validator extends Successable
{

  private
    $data=null,
    $rules=array(),
    $errors=array();
  
  public function __construct($data, $rules=array())
  {
  
    $this->data = data_of($data);
    $this->validate($rules);
    
  }
  
  public function __call($rule, $options)
  {
    
    return $this->validate(array($rule=>$options));
    
  }
  
  public function validate($rules=null)
  {
    
    $this->rules = is_array($rules) ? $rules : $this->rules;
    $valid = true;
    
    foreach($this->rules as $key=>$val)
    {
      
      // if the key is manualy set, that will be the rule nd the $val will be the options
      if(is_string($key)){
        $rule = $key;
        $options = (array)$val;
      }
      
      // if it's a numeric key, we can assume the rule has no options
      else{
        $rule = $val;
        $options = array();
      }
      
      if(method_exists($this, "_$rule")){
        $return = call_user_func_array(array($this, "_$rule"), $options);
        $valid = !$valid ?$valid : ((is_null($this->check_rule('required')) && is_null($this->data)) || $return===true);
        if($return !== true){
          $this->errors[] = __(trim($return, '.!? '), true);
        }
      }
      
      else{
        throw new \exception\InvalidArgument('%s is not a valid rule.', ucfirst($rule));
      }
      
    }
    
    $this->_success($valid);
    
  }
  
  // validates a certain rule, if the rule is not defined, validation always ..?
  public function check_rule($certain_rule)
  {
    
    foreach($this->rules as $key => $val)
    {
      
      if(is_string($key)){
        $rule = $key;
        $options = (array)$val;
      }
      
      else{
        $rule = $val;
        $options = array();
      }
      
      if($rule === $certain_rule){
        if(method_exists($this, "_$rule")){
          return call_user_func_array(array($this, "_$rule"), $options) === true;
        }else{
          throw new \exception\InvalidArgument('%s is not a valid rule.', ucfirst($rule));
        }
      }
      
    }
    
    return null;
    
  }
  
  // returns the array of encountered errors
  public function errors()
  {
    return $this->errors;
  }
  
  // retrieves the data after it has been type juggled with
  public function get_data()
  {
    
    return $this->data;
    
  }
  
  // returns true for arrays with a size between $min and $max, for strings with a length between $min and $max, for numbers between $min and $max
  private function _between($min=0, $max=-1)
  {
    
    if(!(is_numeric($min) && is_numeric($max))){
      throw new \exception\InvalidArgument('Expecting numbers for both $min and $max.');
    }
    
    if($max <= $min){
      throw new \exception\InvalidArgument('$min comes first, then $max.');
    }
    
    if($this->check_rule('string')===true){
      if(!(strlen($this->data) >= $min && ($max < 0 ? true : strlen($this->data) <= $max))){
        return "The value must be between $min and $max characters.";
      }
      return true;
    }
    
    elseif($this->check_rule('number')===true){
      if(!($this->data >= $min && ($max < 0 ? true : $this->data <= $max))){
        return "The value must be between $min and $max.";
      }
      return true;
    }
    
    else{
      switch(gettype($this->data))
      {
        
        case 'array':
          if(!(count($this->data) >= $min && ($max < 0 ? true : count($this->data) <= $max))){
            return "The value must contain between $min and $max nodes.";
          }
          return true;
        
        case 'string':
          if(!(strlen($this->data) >= $min && ($max < 0 ? true : strlen($this->data) <= $max))){
            return "The value must be between $min and $max characters.";
          }
          return true;
          
        case 'integer':
        case 'float':
        case 'number':
        case 'double':
          if(!($this->data >= $min && ($max < 0 ? true : $this->data <= $max))){
            return "The value must be between $min and $max.";
          }
          return true;
          
        default:
          return 'The value is of a format which can not lie between 2 numbers: '.gettype($this->data);
      
      }
    }
    
  }
  
  //return false if this is not set
  private function _required()
  {
    
    if($this->data !== null && $this->data !== ""){
      return true;
    }
    
    return __('This is a required field.', 1);
    
  }
  
  // returns false if node is empty
  private function _not_empty()
  {
    
    if($this->_string() === true && (!empty($this->data)))
      return true;
    
    if($this->_number() === true && (!empty($this->data)))
      return true;
    
    return "The value can not be empty.";
    
  }
  
  // checks email address format and domain existance
  private function _email()
  {
    
    if(!filter_var($this->data, FILTER_VALIDATE_EMAIL)){
      return __('The value must be a valid email address.', 1);
    }

    //Removed DNS check because it's too slow.
    //Could crank execution time up to 30s!    
    //This would mean for instance ajax calls won't work for 30 seconds.
    //Or a form submission would wait that long.
    //    $domain = array_get(explode('@', $this->data), 1);
    //    if(!(checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'))){
    //      return "The value must have a valid domain.";
    //    }
    
    return true;
    
  }
  
  // checks if content of this node is numeric
  private function _number($type='int')
  {
    
    switch($type)
    {
      
      case 'int':
      case 'integer':
        $converted = (integer) $this->data;
        break;
      
      case 'float':
        $converted = (float) $this->data;
        break;
        
      case 'double':
        $converted = (double) $this->data;
        break;
        
      default:
        throw new \exception\InvalidArgument('Invalid data type.');
      
    }
    
    if(is_string($this->data) ? (string) $converted === $this->data : $converted === $this->data){
      $this->data = $converted;
      return true;
    }
    
    if(!$this->check_rule('required')){
      $this->data = null;
      return true;
    }
    
    return "The value must be a number.";
  
  }
  
  // validate if the value could be used as a string
  private function _string()
  {
		
    //check if the value is a string, if not.. maybe it's something we can cast to a string?
		if(!is_string($this->data))
		{
			
      if(is_array($this->data) || (is_object($this->data) && !method_exists($this->data, '__toString'))){
        return 'The value must be textual.';
      }
      
      $this->data = (string) $this->data;
      
		}
    
    return true;
    
  }
  
  // validate if the string contains html
  private function _no_html()
  {
    
    if(is_null($this->check_rule('string')) && gettype($this->data) != 'string'){
      return true;
    }
    
    if(preg_match('~(?<=\<\w).*?\>~', $this->data) > 0){
      return "The value may not contain html.";
    }
    
    return true;
    
  }
  
  // greater than
  private function _gt($number)
  {
    
    if($this->check_rule('number') !== false && $this->data > $number){
      return true;
    }
    
    if(!$this->check_rule('required')) return true;
    return "The value must be greater than $number.";
    
  }
  
  // greater than or equal to
  public function _gte($number)
  {
    
    if($this->check_rule('number') !== false && $this->data >= $number){
      return true;
    }
    
    return "The value must be greater than or equal to $number.";
    
  }
  
  // lesser than
  private function _lt($number)
  {
    
    if($this->check_rule('number') !== false && $this->data < $number){
      return true;
    }
    
    return "The value must be lesser than $number.";
    
  }
  
  // lesser than or equal to
  public function _lte($number)
  {
    
    if($this->check_rule('number') !== false && $this->data <= $number){
      return true;
    }
    
    return "The value must be lesser than or equal to $number.";
    
  }
  
  // equal to
  private function _eq($value)
  {
    
    if($this->check_rule('number') !== false && $this->data == $value){
      return true;
    }
    
    return "The value must be equal to $value.";
    
  }
  
  // in
  public function _in()
  {
    
    if(!in_array($this->data, func_get_args(), true)){
      if(!$this->_not_empty() && !$this->check_rule('required')) return true;
      return "The value must be one of the following values: ".implode(', ', func_get_args()).'.';
    }
    
    return true;
    
  }
  
  // not in
  public function _not_in()
  {
    
    if(in_array($this->data, func_get_args(), true)){
      if(!$this->_not_empty() && !$this->check_rule('required')) return true;
      return "The value must not be one of the following values: ".implode(', ', func_get_args()).'.';
    }
    
    return true;
    
  }
  
  // validate a string contains a variable name
  private function _javascript_variable_name()
  {
  
    //This is the old format. Yes it is now possible to use all sorts of unicode characters.
    //We're not going to let you though ÃƒÂ²_ÃƒÂ³
    //This is backwards compatible with javascript 1.5 standards
    //Considering that means the vast majority of Internet Explorer versions this is required.
    if($this->check_rule('string') !== false && preg_match('~^[a-zA-Z_$][0-9a-zA-Z_$]*$~', $this->data) == 1){
      return true;
    }
    
    return 'The value must be a javascript variable name.';
  
  }
  
  private function _boolean()
  {
    
    if(is_bool($this->data))
      return true;
    
    if(is_string($this->data)){
      
      $str = strtolower($this->data);
      $is_true = in_array($str, array('true', '1', 'yes'));
      $is_false = in_array($str, array('false', '0', 'no'));
      $is_bool = $is_true || $is_false;
      
      if($is_bool)
        $this->data = ($is_true ? true : false);
      
      return $is_bool;
      
    }
    
    return 'The value must be a boolean.';
    
  }
  
  private function _array()
  {
    
    $data = data_of($this->data);
    
    if(is_array($data))
      return true;
    
    return 'The value must be an array.';
    
  }
  
  private function _url()
  {
  
    try{
      tx('Url')->parse($this->data);
    } catch (\exception\Unexpected $ue) {
      return 'The value must be a url.';
    }
    
    return true;
    
  }
  
  private function _password()
  {

    //Check if password is not empty.
    if(empty($this->data)){
      return true;
    }
    
    //Validate a password is strong enough.
    if(tx('Security')->get_password_strength($this->data) < SECURITY_PASSWORD_STRENGTH)
      return __('The value must be a strong password please mix at least '.SECURITY_PASSWORD_STRENGTH.
        ' of the following: uppercase letters, lowercase letters, numbers and special characters.', 1);
    
    return true;
    
  }
  
  public function _datetime($target_format='Y-m-d H:i:s')
  {
    
    if($this->_required() !== true){
      $this->data = null;
      return true;
    }
    
    if($this->_not_empty() !== true){
      $this->data = null;
      return true;
    }
    
    $input = $this->data;
    
    switch(gettype($this->data)){
      
      case 'string':
        $input = @strtotime($input);
        if($input === false)
          return 'The value must be a valid date-time value.';
        
      case 'integer':
        $input = @date($target_format, $input);
        if($input === false)
          return 'The value must be a valid date-time value.';
        $this->data = $input;
        return true;
        
      default:
        return 'The value must be a valid date-time value.';
        
    }
    
  }
  
  private function _length($length)
  {
    
    if(!is_int($length))
      throw new \exception\InvalidArgument('$length must be an integer.');
    
    if($this->check_rule('string')===true){
      if(strlen($this->data) !== $length && (strlen($this->data) !== 0 && $this->check_rule('required') !== true)){
        return "The value must be $length characters.";
      }
      return true;
    }
    
    throw new \exception\Programmer('Length check is only implemented for strings.');
    
  }
  
}
