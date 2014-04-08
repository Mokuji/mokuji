<?php namespace dependencies\account; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \dependencies\BaseModel;

/**
 * Provides static methods to perform email token tasks.
 * 
 * Note about purpose strings:
 *   The names are arbitrary and you can invent as many as you like.
 *   Use them to make sure different processes do not conflict with each other.
 *   Be sure to keep a note of the ones you came up with in a public location to prevent
 *   conflicts with other components that are out there.
 */
abstract class EmailTokenTasks
{
  
  /**
   * How long a token should at least remain valid.
   * 
   * Because we assume e-mail as the medium, it should account for slow mail servers and
   * users that were going for a coffee first.
   * @var integer
   */
  const MIN_TOKEN_LIFETIME = 3600; //1 hour.
  
  /**
   * How long a token should remain valid at most.
   * 
   * Because we assume e-mail as the medium, the longer a token remains in the inbox,
   * the higher the risk that this token is compromised. After this maximum
   * lifetime value, we consider any token to be useless for verification purposes.
   * @var integer
   */
  const MAX_TOKEN_LIFETIME = 1209600; //2 weeks.
  
  /**
   * The maximum amount of attempts to generate a unique token.
   * @var integer
   */
  private static $MAX_ATTEMPTS = 20;
  
  /**
   * The default values for the generate method.
   * @var array
   */
  private static $GENERATE_DEFAULTS = array(
    'bump_email_verification' => true,
    'consume_token' => true
  );
  
  /**
   * Check for support of the core user email tokens database table.
   * @return boolean
   */
  public static function isEmailTokensSupported()
  {
    
    return !mk('Sql')
      ->execute_single("SHOW TABLES LIKE '#__core_user_logins'")
      ->is_empty();
    
  }
  
  /**
   * Generates a token for the given user and purpose.
   * @param  int $userId The user to generate the token for.
   * @param  string $purpose The internal purpose name that identifies the use case for the token.
   * @param  integer $lifetime The length in seconds the token should remain valid.
   * @return string The token that you may use for verification.
   */
  public static function generate($userId, $purpose, $lifetime)
  {
    
    //Is the database updated?
    if(!EmailTokenTasks::isEmailTokensSupported()){
      throw new \exception\Programmer(
        'To use this function you need to upgrade the Mokuji core tables. '.
        'Use EmailTokenTasks::isEmailTokensSupported() if you want to create backward compatibility.'
      );
    }
    
    raw($userId, $purpose, $lifetime);
    
    //Check the lifetime is in the valid range.
    if(EmailTokenTasks::MIN_TOKEN_LIFETIME > $lifetime || $lifetime > EmailTokenTasks::MAX_TOKEN_LIFETIME){
      throw new \exception\InvalidArument(
        'The token lifetime is out of range. It should be between %u and %u.',
        EmailTokenTasks::MIN_TOKEN_LIFETIME, EmailTokenTasks::MAX_TOKEN_LIFETIME
      );
    }
    
    //Set basic info.
    $tokenEntry = Data(array(
      
      //For who and what?
      'user_id' => $userId,
      'purpose' => $purpose,
      
      //Till when?
      'date' => date('Y-m-d H:i:s'),
      'dt_expiry' => date('Y-m-d H:i:s', time() + $lifetime),
      
      //By who?
      'ip' => mk('Data')->server->REMOTE_ADDR,
      'user_agent' => mk('Data')->server->HTTP_USER_AGENT
      
    ));
    
    #TODO: Use SQL transactions.
    //Find a unique token.
    $attempts = 0;
    do{
      
      if($attempts >= self::$MAX_ATTEMPTS){
        throw new \exception\Programmer(
          'Maximum of %u attempts failed to generate a unique token, has the table filled up?', self::$MAX_ATTEMPTS
        );
      }
      
      //Generate a token.
      $token = mk('Security')->random_string();
      $attempts++;
      
      //Query for uniqueness.
      $notUnique = mk('Sql')->execute_scalar(mk('Sql')->make_query(
        "SELECT COUNT(*)
        FROM `#__core_user_email_tokens`
        WHERE user_id = ? AND token = ?",
        $userId, $token
      ))->get('int') > 0;
      
    }while($notUnique);
    
    //Store the token.
    $tokenEntry->token->set($token);
    
    //Log the attempts we needed.
    mk('Logging')->log('Account', 'EmailTokenTasks', sprintf('Found unique token after %u attempts.', $attempts));
    
    #TODO: Use core models.
    $values = $tokenEntry->as_array();
    foreach($values as $key => $value)
      $values[$key] = mk('Sql')->escape($value);
    $keys = array_keys($values);
    mk('Sql')->execute_non_query(
      "INSERT INTO `#__core_user_email_tokens` (`".implode('`, `', $keys)."`)
      VALUES (".implode(', ', $values).")"
    );
    
    return $token;
    
  }
  
  /**
   * Validates an e-mail token can be considered as a good verification.
   * 
   * The options you can use are:
   *   * bump_email_verification = default true, whether this validation will be used to update the last time the user e-mail was verified.
   *   * consume_token = default true, whether the token should be consumed immediately to prevent reusing it.
   * 
   * @param  integer $userId The user the token is intended for.
   * @param  string $token   The token that was provided as a verification.
   * @param  string $purpose The internal purpose name that identifies the use case for the token.
   * @param  array? $options A set of options to alter the verification logic.
   * @return boolean Whether or not the token was valid.
   */
  public static function validate($userId, $token, $purpose, array $options=array())
  {
    
    //Do we support the functionality?
    if(!EmailTokenTasks::isEmailTokensSupported()){
      throw new \exception\Programmer(
        'To use this function you need to upgrade the Mokuji core tables. '.
        'Use EmailTokenTasks::isEmailTokensSupported() if you want to create backward compatibility.'
      );
    }
    
    #TODO: Perhaps add exceptions or status codes to allow implementations to customize error messages.
    
    raw($userId, $token, $purpose);
    $options = Data(array_merge(self::$GENERATE_DEFAULTS, $options));
    
    #TODO: Use SQL transactions when bump or consume is needed.
    #TODO: Use core models.
    //Look for a token match at all.
    $entry = EmailTokenTasks::findToken($userId, $token);
    
    //No token was found.
    if($entry->is_empty()){
      mk('Logging')->log(
        'Account', 'EmailTokenTasks',
        sprintf('Could not find token %s for user_id %u.', $token, $userId)
      );
      return false;
    }
    
    //Token was created for another purpose.
    if($entry->purpose->get('string') !== $purpose){
      mk('Logging')->log(
        'Account', 'EmailTokenTasks',
        sprintf(
          'Token ID %u for user ID %u was used for wrong purpose "%s", purpose in database is "%s".',
          $entry->id->get('int'), $userId, $purpose, $entry->purpose->get()
        )
      );
      return false;
    }
    
    //Did the token expire?
    if(strtotime($entry->dt_expiry->get('string')) <= time()){
      mk('Logging')->log(
        'Account', 'EmailTokenTasks',
        sprintf(
          'Token "%s" has expired for user %u.',
          $token, $userId
        )
      );
      return false;
    }
    
    //See if we should update our record of when we last verified our e-mail.
    if($options->check('bump_email_verification')){
      #TODO: Use core models.
      mk('Sql')->execute_non_query(mk('Sql')->make_query(''
        ."UPDATE `#__core_users` "
        ."SET dt_email_verified = ? "
        ."WHERE id = ? "
        ,date('Y-m-d H:i:s')
        ,$userId
      ));
      mk('Logging')->log('Account', 'EmailTokenTasks', 'Email verification date bumped.');
    }
    
    //See if the token should be consumed now.
    if($options->check('consume_token')){
      if(EmailTokenTasks::consumeToken($userId, $token)){
        mk('Logging')->log('Account', 'EmailTokenTasks', 'Token consumed.');
      }
    }
    
    mk('Logging')->log(
      'Account', 'EmailTokenTasks',
      sprintf('Successfully used "%s" token for user %u.', $purpose, $userId)
    );
    
    //Looks like we're all good :]
    return true;
    
  }
  
  /**
   * Tries to find a token.
   * @param  integer $userId The user the token is intended for.
   * @param  string $token   The token that was provided as a verification.
   * @return Data
   */
  public static function findToken($userId, $token)
  {
    
    return mk('Sql')->execute_single(mk('Sql')->make_query(''
      ."SELECT * FROM `#__core_user_email_tokens` "
      ."WHERE user_id = ? and token = ?"
      ,$userId
      ,$token
    ));
    
  }
  
  /**
   * Regardless of the purpose, consume the given token.
   * @param  integer $userId The user the token is intended for.
   * @param  string $token   The token that was provided as a verification.
   * @return boolean Whether a token was deleted or not.
   */
  public static function consumeToken($userId, $token)
  {
    
    #TODO: Use core models.
    $result = mk('Sql')->query(mk('Sql')->make_query(''
      ."DELETE FROM `#__core_user_email_tokens` "
      ."WHERE user_id = ? AND token = ?"
      ,$userId, $token
    ));
    
    return $result->rowCount() > 0;
    
  }
  
}