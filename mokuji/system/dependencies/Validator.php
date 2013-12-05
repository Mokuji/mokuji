<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Validator extends Successable
{
  
  private
    $data=null,
    $rules=array(),
    $errors=array(),
    $translate;
  
  public function __construct($data, $rules=array(), $translate=true)
  {
    
    $this->data = data_of($data);
    $this->translate = $translate;
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
          $this->errors[] = trim($return, '.!? ');
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
  
  //Does a conditional translate with formatting.
  private function ctransf()
  {
    
    $args = func_get_args();
    if($this->translate === true){
      array_unshift($args, null);
      return call_user_func_array('transf', $args);
    }
    else{
      return call_user_func_array('sprintf', $args);
    }
    
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
        return $this->ctransf("The value must be between {0} and {1} characters.", $min, $max);
      }
      return true;
    }
    
    elseif($this->check_rule('number')===true){
      if(!($this->data >= $min && ($max < 0 ? true : $this->data <= $max))){
        return $this->ctransf("The value must be between {0} and {1}.", $min, $max);
      }
      return true;
    }
    
    else{
      switch(gettype($this->data))
      {
        
        case 'array':
          if(!(count($this->data) >= $min && ($max < 0 ? true : count($this->data) <= $max))){
            return $this->ctransf("The value must contain between {0} and {1} nodes.", $min, $max);
          }
          return true;
        
        case 'string':
          if(!(strlen($this->data) >= $min && ($max < 0 ? true : strlen($this->data) <= $max))){
            return $this->ctransf("The value must be between {0} and {1} characters.", $min, $max);
          }
          return true;
          
        case 'integer':
        case 'float':
        case 'number':
        case 'double':
          if(!($this->data >= $min && ($max < 0 ? true : $this->data <= $max))){
            return $this->ctransf("The value must be between {0} and {1}.", $min, $max);
          }
          return true;
          
        default:
          return $this->ctransf("The value is of a format which can not lie between 2 numbers: {0}", gettype($this->data));
      
      }
    }
    
  }
  
  //return false if this is not set
  private function _required()
  {
    
    if($this->data !== null && $this->data !== ""){
      return true;
    }
    
    if(!$this->check_rule('boolean')){
      $this->data = false;
      return true;
    }
    
    return $this->ctransf('This is a required field.');
    
  }
  
  // returns false if node is empty
  private function _not_empty()
  {
    
    if($this->_string() === true && (!empty($this->data)))
      return true;
    
    if($this->_number() === true && (!empty($this->data)))
      return true;
    
    return $this->ctransf("The value can not be empty.");
    
  }
  
  // checks email address format and domain existance
  private function _email()
  {
    
    //Check if not empty.
    if(empty($this->data)){
      return true;
    }
    
    if(!filter_var($this->data, FILTER_VALIDATE_EMAIL)){
      return $this->ctransf('The value must be a valid email address.');
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
    
    $estimate = true;
    
    switch($type)
    {
      
      case 'int':
      case 'integer':
        $estimate = false;
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
    
    //When dealing with absolute values.
    if(!$estimate){
      
      //Check either by string conversion or direct comparison.
      if(is_string($this->data) ? (string) $converted === $this->data : $converted === $this->data){
        $this->data = $converted;
        return true;
      }
      
    }
    
    //When dealing with floating point values, we can't perform a string check, only a comparison when the types are the same.
    else {
      
      //When the types match, we can compare, otherwise just skip checking.
      if(gettype($converted) == gettype($this->data) ? $converted === $this->data : true){
        $this->data = $converted;
        return true;
      }

    }
    
    $raw_data = data_of($this->data);
    if(empty($raw_data) && !$this->check_rule('required')){
      $this->data = null;
      return true;
    }
    
    return $this->ctransf("The value must be a number.");
  
  }
  
  // validate if the value could be used as a string
  private function _string()
  {
		
    //check if the value is a string, if not.. maybe it's something we can cast to a string?
		if(!is_string($this->data))
		{
			
      if(is_array($this->data) || (is_object($this->data) && !method_exists($this->data, '__toString'))){
        return $this->ctransf('The value must be textual.');
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
      return $this->ctransf("The value may not contain html.");
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
    return $this->ctransf("The value must be greater than {0}.", $number);
    
  }
  
  // greater than or equal to
  public function _gte($number)
  {
    
    if($this->check_rule('number') !== false && $this->data >= $number){
      return true;
    }
    
    return $this->ctransf("The value must be greater than or equal to {0}.", $number);
    
  }
  
  // lesser than
  private function _lt($number)
  {
    
    if($this->check_rule('number') !== false && $this->data < $number){
      return true;
    }
    
    return $this->ctransf("The value must be lesser than {0}.", $number);
    
  }
  
  // lesser than or equal to
  public function _lte($number)
  {
    
    if($this->check_rule('number') !== false && $this->data <= $number){
      return true;
    }
    
    return $this->ctransf("The value must be lesser than or equal to {0}.", $number);
    
  }
  
  // equal to
  private function _eq($value)
  {
    
    if($this->check_rule('number') !== false && $this->data == $value){
      return true;
    }
    
    return $this->ctransf("The value must be equal to {0}.", $number);
    
  }
  
  // in
  public function _in()
  {
    
    if(!in_array($this->data, func_get_args(), true)){
      if(!$this->_not_empty() && !$this->check_rule('required')) return true;
      return $this->ctransf("The value must be one of the following values: {0}.", implode(', ', func_get_args()));
    }
    
    return true;
    
  }
  
  // not in
  public function _not_in()
  {
    
    if(in_array($this->data, func_get_args(), true)){
      if(!$this->_not_empty() && !$this->check_rule('required')) return true;
      return $this->ctransf("The value must not be one of the following values: {0}.", implode(', ', func_get_args()));
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
    
    return $this->ctransf('The value must be a javascript variable name.');
  
  }
  
  private function _boolean()
  {
    
    if(is_bool($this->data))
      return true;
    
    if(is_string($this->data)){
      
      $str = strtolower($this->data);
      $is_true = in_array($str, array('true', '1', 'yes'));
      $is_false = in_array($str, array('false', '0', 'no', ''));
      $is_bool = $is_true || $is_false;
      
      if($is_bool)
        $this->data = ($is_true ? true : false);
      
      return $is_bool;
      
    } else {
      
      $this->data = !empty($this->data);
      return true;
      
    }
    
    return $this->ctransf('The value must be a boolean.');
    
  }
  
  private function _array()
  {
    
    $data = data_of($this->data);
    
    if(is_array($data))
      return true;
    
    return $this->ctransf('The value must be an array.');
    
  }
  
  private function _url()
  {
    
    $raw_data = data_of($this->data);
    if(empty($raw_data) && !$this->check_rule('required')){
      $this->data = null;
      return true;
    }
    
    try{
      
      $url = $this->data;
      
      if(strpos($this->data, '://') === false)
        $url = 'http://'.$url;
      
      $segments = tx('Url')->parse($url);
      
      //Must contain a domain at the very least.
      if(!array_key_exists('domain', $segments))
        return $this->ctransf('The value must be a url.');
      
      //See if it's an IP.
      $is_ip = !!filter_var($segments['domain'], FILTER_VALIDATE_IP);
      
      //If it's not an IP, check the domain.
      if(!$is_ip){
        
        //It also can't be localhost, so must have a dot.
        if(strpos($segments['domain'], '.') === false)
          return $this->ctransf('The value must be a url.');
        
        //The domain must have a valid top level domain.
        $domainparts = explode('.', $segments['domain']);
        $tld = end($domainparts);
        if(!in_array($tld, \core\Url::$TOP_LEVEL_DOMAINS))
          return $this->ctransf('The value must be a url.');
        
      }
      
      $this->data = url($url)->output;
      
    } catch (\exception\Unexpected $ue) {
      return $this->ctransf('The value must be a url.');
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
      return $this->ctransf('The value must be a strong password please mix at least {0}'.
        ' of the following: uppercase letters, lowercase letters, numbers and special characters.',
        SECURITY_PASSWORD_STRENGTH);
    
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
          return $this->ctransf('The value must be a valid date-time value.');
        
      case 'integer':
        $input = @date($target_format, $input);
        if($input === false)
          return $this->ctransf('The value must be a valid date-time value.');
        $this->data = $input;
        return true;
        
      default:
        return $this->ctransf('The value must be a valid date-time value.');
        
    }
    
  }
  
  private function _length($length)
  {
    
    if(!is_int($length))
      throw new \exception\InvalidArgument('$length must be an integer.');
    
    if($this->check_rule('string')===true){
      if(strlen($this->data) !== $length && (strlen($this->data) !== 0 && $this->check_rule('required') !== true)){
        return $this->ctransf("The value must be {0} characters.", $length);
      }
      return true;
    }
    
    throw new \exception\Programmer('Length check is only implemented for strings.');
    
  }
  
  private function _component_name()
  {
    
    //Check if value is not empty.
    if(empty($this->data)){
      return true;
    }
    
    if($this->check_rule('string')===true){
      
      //No character outside of this range my be included.
      if(preg_match('~[^a-z_]+~', $this->data) === 0)
        return true;
      
    }
    
    return $this->ctransf("The value must be a valid component name having lowercase and underscore characters only.");
    
  }
  
  /*
   Jabber ID's differ from email addresses in that they allow a lot of characters in the
   identifier and have a resource ID. Bare JID's do not have a resource ID and is often
   used to specify a user or room, rather than a particular client or user in a room.
  */
  
  private function _jid($type=null, $externalOnly=true)
  {
    
    //Check if not empty.
    if(empty($this->data)){
      return true;
    }
    
    //Split the JID in parts.
    $input = (string)$this->data;
    
    //Get the first / and split off the resource on that.
    $resource = null;
    $slashIndex = strpos($input, '/');
    if($slashIndex !== false){
      $resource = substr($input, $slashIndex+1);
      $input = substr($input, 0, $slashIndex);
    }
    
    //Next, see what is required.
    //Note: using this order, since bare strips the resource.
    switch($type){
      
      //Loose spec: [node@]domain[/resource]
      case null:
        $requireNode = false;
        $requireResource = false;
        break;
      
      //'Bare' spec: node@domain
      case 'bare':
        $requireNode = true;
        $requireResource = false;
        
        //Resource should be stripped.
        $resource = null;
        break;
      
      //Resource spec: [node@]domain/resource
      case 'resource':
        $requireNode = false;
        $requireResource = true;
        break;
      
      //Full spec: node@domain/resource
      case 'full':
        $requireNode = true;
        $requireResource = true;
        break;
      
      default:
        throw new \exception\Programmer('Unknown JID type specifier "%s"', $type);
      
    }
    
    $type = $type ? "'$type'" : null;
    
    //Then the @ character.
    $parts = explode('@', $input);
    switch(count($parts)){
      case 2:
        $node = $parts[0];
        $domain = $parts[1];
        break;
      case 1:
        $node = null;
        $domain = $parts[0];
        break;
      default:
        return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    }
    
    /*
      First find out if the node identifier is valid.
      Note: this assumes PHP or your webserver handles unassigned unicode code paths,
        mapping and control characters.
      Invalid characters:
        - whitespace
        - the additional characters ["&'/:<>@]
    */
    if($requireNode && $node === null)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    if($node !== null && preg_match("~^[^ \t\r\n\"&'/:<>@]+$~", $node) !== 1)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    if(strlen($node) >= 1024)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    /*
      Next validate the resource.
      Note: this assumes PHP or your webserver handles unassigned unicode code paths,
        mapping and control characters.
      Invalid characters:
        - whitespace
    */
    if($requireResource && $resource === null)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    if($resource !== null && preg_match("~^[^ \t\r\n]+$~", $resource) !== 1)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    if(strlen($resource) >= 1024)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    //Now validate the domain in a bit of a clunky way.
    //Note: it's always required.
    #TODO: Use the internationalized version of the XMPP spec instead of email domains.
    if(!(
      filter_var($domain, FILTER_VALIDATE_IP,
        $externalOnly ? FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE : null
      ) || filter_var('henk@'.$domain, FILTER_VALIDATE_EMAIL)
    )) return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    if(strlen($domain) >= 1024)
      return $this->ctransf("The value must be a valid {0} Jabber ID.", $type);
    
    //Since we do stripping, set the result.
    $this->data =
      ($node ? $node.'@' : ''). $domain.
      ($resource ? '/'.$resource : '');
    
    //All good!
    return true;
    
  }
  
  private function _phonenumber($countrycode=null)
  {
    
    //Check if not empty.
    if(empty($this->data)){
      return true;
    }
    
    //First strip all dashes, spaces, brackets and dots.
    $input = preg_replace('~[- ().]+~', '', (string)$this->data);
    
    //Next, see if it starts with a 0, thus asking a localized replacement.
    if($countrycode && strlen($input) > 0 && $input[0] === '0')
      $input = $countrycode . substr($input, 1);
    
    //Now go and match it.
    $pattern = '~^\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|'.
      '9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)'.
      '\d{1,14}$~';
    
    if(preg_match($pattern, $input) === 1){
      $this->data = $input;
      return true;
    }
    
    #TODO: Add local pattern restrictions based on the $countrycode variable.
    
    return $this->ctransf("The value must be a valid ".($countrycode ? '' : 'international ')."phone number.");
    
  }
  
}
