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
      '128' => array('ripemd128', 'snefru'),
      '160' => array('ripemd160', 'sha1'),
      '224' => array('sha224'),
      '256' => array('sha256'),
      '384' => array('sha384'),
      '512' => array('sha512', 'whirlpool')
    ), //END - $hash_preferences
    
    //The default hashing algorithm to use.
    $HASH_DEFAULT = 'sha256';
  
  /**
   * Checks the password supplied is strong enough.
   *
   * @author Beanow
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
   *
   * @copyright: public domain
   * @author Beanow
   * @link http://tuxion.nl
   * @note Don't try to improve this, you will likely just ruin it.
   * @note I did it anyways. Regards ~Beanow
   */
  private function _random_bits($bits, $secure=true, $output_type=self::OUTPUT_HEX)
  {
    
    //Obviously *NIX is for pro's and so we should use it's generator if available.
    //Ok the real reason is that it gives high entropy by gathering noise on an OS level.
    //And falls back on a pseudo random generator that's simply a lot faster and more scrutinized.
    //So using that makes this function a lot faster and more safe.
    if (@is_readable('/dev/urandom')){
      $f=fopen('/dev/urandom', 'rb');
      $str=fread($f, ceil($bits/8));
      fclose($f);
      return $this->_convert_bin($str, $output_type);
    }
    
    //If we don't have it we're going to make the best out of getting microtime() bits of randomness.
    else
    {
      
      //Generate more entropy starting state, to give it that extra bit of spunk. :D
      $state = uniqid('', true);
      $intermediate_bytes = '';
      $random_bytes = '';
      $hash_algorithm = $this->pref_hash_algo($bits, true, $intermediate_bits);
      $intermediate_hashes = 0;
      
      //Increment with 20, because microtime() generates 6 decimals which is almost 20 bits.
      //The fraction of the last bit that isn't available from microtime() comes from mt_rand().
      //However if $secure is set to false we don't care and take the size of the hash output instead.
      //This will make the algorithm faster but will contain much less entropy.
      //Note that the state hash and string appending hash are different and should be!
      //It makes it impossible for the state to leak into the output stream.
      for ($entropy = 0; $entropy <= $bits; $entropy += ($secure === true ? 20 : 52))
      {
        
        //Whenever we have reached the max entropy we can cram into the hashing algorithm that was
        //selected, hash it to the results. Or if we reached the total requested entropy, because
        //this could not be an exact match for the hashing algo's output size. Use bytes here so
        //we don't get pointless data in here, like padding signs for base64.
        if($entropy > 0 && ($entropy >= ($intermediate_bits * ($intermediate_hashes+1)) || $entropy >= $bits)){
          $random_bytes .= $this->hash($intermediate_bytes, $hash_algorithm, self::OUTPUT_BINARY);
          $intermediate_hashes++;
          $intermediate_bytes = '';
          if($entropy >= $bits)
            break;
        }
        
        //Create a new state hash.
        $state = $this->hash(microtime().$state.mt_rand(), self::$HASH_PREFERENCES['128'][0]);
        
        //Add new bits to the collection, using the state and another microtime.
        $intermediate_bytes .=
          $this->hash(microtime().$state, self::$HASH_PREFERENCES['128'][0], self::OUTPUT_BINARY);
        
      }
      
      //Do final conversion of binary data.
      return $this->_convert_bin($random_bytes, $output_type);
      
    }

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
