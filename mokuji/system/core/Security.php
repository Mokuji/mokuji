<?php namespace core; if(!defined('TX')) die('No direct access.');

class Security
{
  
  const
    PASSWORD_STRENGTH_VERY_WEAK = 1,
    PASSWORD_STRENGTH_WEAK = 2,
    PASSWORD_STRENGTH_ACCEPTABLE = 3,
    PASSWORD_STRENGTH_STRONG = 4;
  
  const
    OUTPUT_BINARY = 0,
    OUTPUT_HEX = 1,
    OUTPUT_BASE64 = 2,
    OUTPUT_DECIMAL = 3;
  
  public static
    
    /**
     * Hashing algorithm preferences.
     *
     * Algorithms not included are listed below.
     * Grouped by output size and ordered by current cryptographic strength.
     * Note that this MUST be ordered from small to large output!!
     *
     * Last review of available algorithms:
     *   March 19th 2012 - PHP 5.4.0
     *
     * Priority reasons:
     *   128 bits: ripemd128 is more scrutinized than snefru, both are secure.
     *   160 bits: ripemd160 has not been broken yet while sha1 has a known collission attack.
     *             sha1 is still safe enough to be enabled though. Might be useful as sha1 is faster.
     *   224 bits: sha224 has not been broken yet.
     *   256 bits: sha256 has not been broken yet.
     *   384 bits: sha384 has not been broken yet.
     *   512 bits: sha512 is the most scrutinized algorithm,
     *             but whirlpool has not been broken and is similarly secure.
     *
     * Discouraged hashing algorithms:
     *   Broken through preimage attacks        : md4, md2
     *   Broken through collission attacks      : md5, gost, haval
     *   Not standards compliant                : tiger128/160/192,3/4
     *   Not included for bloating output size  : ripemd256/320
     *   No documentation found                 : snefru256
     *   Not a cryptographic hash               : adler32, crc32, crc32b, fnv132, fnv164, joaaat
     *   Removed since PHP 5.4.0                : salsa10, salsa20
     *
     */
    $HASH_PREFERENCES = array(
      '128' => array('ripemd128', 'snefru', 'md5'),
      '160' => array('ripemd160', 'sha1'),
      '224' => array('sha224'),
      '256' => array('sha256'),
      '384' => array('sha384'),
      '512' => array('sha512', 'whirlpool')
    ), //END - $hash_preferences
    
    //The default hashing algorithm to use.
    $HASH_DEFAULT = 'sha256';
  
  /**
   * Caches an internal state, which is stored in the database when this object destructs.
   * Used as part of the final fallback option for a source of randomness.
   * @var string
   */
  private $internal_state;
  
  /**
   * Stores which random source was used last.
   * Cached in a variable because we don't want to write this to the database multiple times per request.
   * @var string
   */
  private $last_random_source;
  
  /**
   * Takes care of some pending database operations.
   */
  public function __destruct()
  {
    
    //Should we update the internal state?
    if(isset($this->internal_state))
      mk('Config')->user('security_io_entropy', $this->internal_state, NULL);
    
    //Should register the random source?
    if(isset($this->last_random_source))
      mk('Config')->user('security_last_random_source', $this->last_random_source, NULL);
    
  }
  
  /**
   * Checks the password supplied is strong enough.
   *
   * @param String $password The password to get the strength of.
   * @return int Returns an integer indicating the password strength. See the constants of this class.
   */
  public function get_password_strength($password)
  {
    
    $password = Data(data_of($password))
      ->validate('Password', array('string')); //Must be a string.
    
    $strength = 0; 
    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[Ã‚Â¬!"Ã‚Â£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/'); 
    foreach($patterns as $pattern) 
    {
      if(preg_match($pattern,$password,$matches))
        $strength++;
    }
    
    return $strength;
    
  }
  
  /**
   * Gets the prefered hashing algorithm for a certain amount of bits worth of entropy.
   *
   * When setting inclusive = false that means:
   *  The prefered algorithm that is used to it's optimum with the given entropy.
   *  For instance: given 230 bits of entropy the best 224 bits algorithm is picked.
   *
   * When setting inclusive = true that means:
   *  The prefered algorithm that is able to contain the full entropy available.
   *  For instance: given 230 bits of entropy the best 256 bits algorithm is picked.
   *
   * @param int $bits Amount of bits of entropy.
   * @param bool $inclusive Whether or not to use the full entropy.
   * @return string Hashing algorithm.
   */
  public function pref_hash_algo($bits=null, $inclusive=false, &$result_bits=null)
  {
    
    //Validate input
    $bits = data_of($bits);
    $inclusive = (bool)$inclusive;
    
    //If bits is not given, return the default hashing algorithm
    if($bits == null){
      return self::$HASH_DEFAULT;
    }
    
    //If the size of the bits is supported directly by the hashing algorithm
    if(array_key_exists((string)$bits, self::$HASH_PREFERENCES)){
      return self::$HASH_PREFERENCES[(string)$bits][0];
    }
    
    //If the size of the bits is not directly supported, find the closest match
    $keys = array_keys(self::$HASH_PREFERENCES);
    $ceil = $keys[count($keys)-1];
    $floor = $keys[0];
    foreach(self::$HASH_PREFERENCES as $key => $prefs)
    {
      
      //If the key is larger then the last known best
      //And the key is smaller then the entropy
      if($key > $floor && $key < $bits){
        $floor = $key;
      }
      
      //If the key is larger then the floor (meaning the floor has been found)
      //Find the first key that is larger then the floor as well as the entropy
      elseif($key > $floor && $key > $bits){
        $ceil = $key;
        break;
      }
      
    }
    
    //Give feedback of the bits used
    $result_bits = $inclusive ? $ceil : $floor;

    //Return best algorithm for the found amount of bits
    return self::$HASH_PREFERENCES[$result_bits][0];
  
  }
  
  /**
   * Generates a hash using php's hash() function.
   * 
   * @param string $input The input string to hash.
   * @param string $algorithm The algorithm to use for hashing.
   * @param int $output_type The output type for the generated bits.
   */
  public function hash($input, $algorithm=null, $output_type=self::OUTPUT_HEX)
  {
    
    raw($input, $algorithm, $output_type);
    
    //If the algorithm isn't set or not a string, use the default.
    if($algorithm == null || !is_string($algorithm)){
      $algorithm = self::$HASH_DEFAULT;
    }
    
    //Check the algorithm is included as a valid hashing algorithm.
    $is_valid = false;
    foreach(self::$HASH_PREFERENCES as $key => $prefs)
    {
      
      if(in_array($algorithm, $prefs)){
        $is_valid = true;
        break;
      }
      
    }
    
    //If it's not valid we have a problem!
    if(!$is_valid){
      throw new \exception\InvalidArgument(
        'Hashing algorithm \'%s\' is either not supported or disabled for security reasons.', $algorithm);
    }
    
    //Return the converted hash results.
    return $this->_convert_bin(hash($algorithm, $input, true), $output_type);
  
  }
  
  /**
   * Generates a random string.
   *
   * @param int $length Length of the random string to get in characters.
   * @param int $output_type The output type for the generated bits.
   * @param bool $secure Use a cryptographically secure method of getting these random bits.
   * @return string A (pseudo) random string.
   */
  public function random_string($length=40, $output_type=self::OUTPUT_HEX, $secure=true)
  {
    
    $required_bits = ceil($length * 8.0 / $this->_conv_rate($output_type));
    
    //Get at least one byte of random data.
    if($required_bits <= 8)
      $required_bits = 8;
    
    $random_bits = $this->_random_bits($required_bits, $secure, $output_type);

    return substr($random_bits, 0, $length);
    
  }
  
  /**
   * Generate pseudo random bits using the best available method.
   *
   * @param int $bits Amount of random bits to generate.
   * @param bool $secure Use a cryptographically secure method of getting these random bits.
   * @param int $output_type The output type for the generated bits.
   * @return string A (pseudo) random string.
   */
  private function _random_bits($bits, $secure=true, $output_type=self::OUTPUT_HEX)
  {
    
    $bytes = ceil($bits/8);
    
    //One of the faster and more safe options: urandom.
    //Sometimes open_basedir obstructs the fopen method. Try using Mcrypt first.
    if(function_exists('mcrypt_create_iv') && defined('MCRYPT_DEV_URANDOM'))
    {
      
      $this->last_random_source = 'mcrypt-urandom';
      
      $str = mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
      if($str !== false)
        return $this->_convert_bin($str, $output_type);
      
    }
    
    //If Mcrypt is not available, try an fopen for /dev/urandom.
    if (@is_readable('/dev/urandom')){
      
      $this->last_random_source = 'fopen-urandom';
      
      $f=fopen('/dev/urandom', 'rb');
      
      if(function_exists('stream_set_read_buffer'))
        stream_set_read_buffer($f, 0);
      
      $str=fread($f, $bytes);
      
      fclose($f);
      
      return $this->_convert_bin($str, $output_type);
      
    }
    
    //Another good option is OpenSSL.
    if(function_exists('openssl_random_pseudo_bytes')){
      $this->last_random_source = 'openssl-random-pseudo-bytes';
      return $this->_convert_bin(openssl_random_pseudo_bytes($bytes), $output_type);
    }
    
    //Starting to get desperate.
    //Windows machines may support this.
    if(@class_exists('\\COM', true)){
      // http://msdn.microsoft.com/en-us/library/aa388176(VS.85).aspx
      try {
          $CAPI_Util = new \COM('CAPICOM.Utilities.1');
          $pr_bits = $CAPI_Util->GetRandom($bytes,0);
          
          // PHP doesn't like the binary data. Use hash to make it binary instead.
          if($pr_bits){
            
            $this->last_random_source = 'capicom-utilities';
            
            $hash_algorithm = $this->pref_hash_algo($bits, true);
            $pr_bits = $this->hash($pr_bits, $hash_algorithm, self::OUTPUT_BINARY);
            $output_bin = substr($pr_bits, 0, $bytes);
            
            return $this->_convert_bin($output_bin, $output_type);
            
          }
      }catch(Exception $ex){ /* It's a best effort thing */ }
    }
    
    //Since there are no proper entropy sources available, we'll just have to come up with our own.
    $this->last_random_source = 'mokuji-fallback';
    
    //Fetch the internal state first.
    if(!isset($this->internal_state))
      $this->internal_state = mk('Config')->user('security_io_entropy')->otherwise(microtime().mt_rand());
    
    //Mix in some request information as noise.
    $this->internal_state = $this->hash(
      
      uniqid($this->internal_state, true).
      mt_rand().
      mk('Data')->server->REMOTE_ADDR->get().
      mk('Data')->server->REMOTE_PORT->get().
      mk('Data')->server->HTTP_USER_AGENT->get().
      mk('Url')->url->input->get().
      mk('Data')->post->dump().
      mk('Data')->cookie->dump(),
      
      //Get the preferred hashing algorithm for 128 bits. As it should suffice for an entropy source.
      $this->pref_hash_algo(128, true)
      
    );
    
    $str = '';
    while(strlen($str) < $bytes){
      
      //Using uniqid here makes sure that the input will definitely differ from the internal state.
      //If the hashing function does a proper job, it should be non-trivial to find the internal state.
      $str .= $this->hash(
        
        uniqid($this->internal_state, true).
        mt_rand(),
        
        //Get the preferred hashing algorithm for 128 bits. As it should suffice for an entropy source.
        $this->pref_hash_algo(128, true),
        
        //Go for binary this time.
        self::OUTPUT_BINARY
        
      );
      
    }
    
    //Check the size is ok.
    $str = substr($str, 0, $bytes);
    
    //Do final conversion of binary data.
    return $this->_convert_bin($str, $output_type);
    
  }
  
  /**
   * Converts binary strings to other notations.
   */
  private function _convert_bin($input, $output_type=self::OUTPUT_HEX)
  {
  
    switch($output_type){
      case self::OUTPUT_BINARY:
        return $input;
      case self::OUTPUT_HEX:
        return bin2hex($input);
      case self::OUTPUT_BASE64:
        return base64_encode($input);
      case self::OUTPUT_DECIMAL:
        throw new \exception\InvalidArgument('Not implemented yet.');
      default:
        throw new \exception\InvalidArgument('Output type ID \'%s\' is not supported.', $output_type);
    }
    
  }
  
  /**
   * Get the conversion rate in characters from bytes.
   */
  private function _conv_rate($output_type)
  {
  
    switch($output_type){
      case self::OUTPUT_BINARY:
        return 1; //8bpc / 8bpc = 1 (duh...)
      case self::OUTPUT_HEX:
        return 2; //8bpc / 4bpc = 2
      case self::OUTPUT_BASE64:
        return 8/6; //8bpc / 6bpc = 1,333333333
      case self::OUTPUT_DECIMAL:
        throw new \exception\InvalidArgument('Not implemented yet.');
        //return 2.4; //8bpc / 3,333333333bpc = 2,4
      default:
        throw new \exception\InvalidArgument('Output type ID \'%s\' is not supported.', $output_type);
    }
    
  }
  
}
