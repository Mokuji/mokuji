<?php namespace components\cms\classes; if(!defined('MK')) die('No direct access.');

class Notifications
{
  
  const TYPE_NONE     = 0;
  const TYPE_MESSAGE  = 10;
  const TYPE_WARNING  = 20;
  const TYPE_ALERT    = 30;
  
  protected static $is_supported;
  
  /**
   * Gets the notifications for the current user.
   * @param int $level The user level to target. 0 = public notification, 1 = user notification, 2 = administrative notification.
   * @param string $worst_type An OUT parameter giving the worst (highest value in the constants) notification type.
   * @param int $new_count An OUT parameter returning the number of unread notifications.
   * @return \dependencies\Resultset A list of notifications.
   */
  public static function get($level=null, &$worst_type=null, &$new_count=null)
  {
    
    raw($level, $limit);
    
    //Validate level.
    if($level && !mk('Account')->check_level($level))
      throw \exception\InvalidArgument(sprintf('Level of %s is higher than your level.', $level));
    
    //Build our basic query.
    $table = mk('Sql')->table('cms', 'Notifications')
      
      //Add in the levels.
      ->is($level, function($table)use($level){
        $table->where('level', $level);
      })
      
      //Add in the user relevance when logged in.
      ->is(mk('Account')->user->check('login'), function($table){
        $table->where( mk('Sql')->conditions()
          ->add('everyone', array('user_id', null))
          ->add('mine', array('user_id', mk('Account')->user->id))
          ->combine('relevant', array('everyone', 'mine'), 'OR')
          ->utilize('relevant')
        );
      })
      
      //Otherwise, only public messages.
      ->failure(function($table){
        $table->where('user_id', null);
      });
    
    //When did we last check?
    $last_read = mk('Sql')->table('cms', 'NotificationLastReads')
      ->pk(mk('Account')->user->id, $level ? $level : 0)
      ->execute_single()
      
      //Create an entry if we need to.
      ->is('empty', function()use($level){
        return mk('Sql')->model('cms', 'NotificationLastReads')
          ->set(array(
            'user_id' => mk('Account')->user->id,
            'dt_last_read' => '1970-01-01 01:00:00',
            'level' => $level ? $level : 0
          ))->save();
      })
      
      ->dt_last_read->get();
    
    //Find out what's new.
    $new_only_table = clone($table);
    $new_count = $new_only_table
      ->where('dt_created', '>=', $last_read)
      ->count()->get('int');
    
    //Find the sane limit.
    $limited_new_count = min($new_count, 12);
    $sane_limit = max($limited_new_count, 5);
    
    //Get the notifications.
    $notifications = $table
      
      //Got to keep tings sane. Use $new_count if it's between 10 and 100.
      ->limit($sane_limit)
      
      //Most recent first.
      ->order('dt_created', 'DESC')
      
      //Fire away!
      ->execute();
    
    //Find the worst type.
    $worst_type = $new_only_table
      ->select('MAX(`type`)', 'worst_type')
      ->execute_single()
      ->worst_type->get('int');
    
    //Convert type.
    $worst_type = self::type_to_string($worst_type);
    
    //Now share the result.
    return $notifications;
    
  }
  
  /**
   * An alias for Notifications::send, where $level=1 and $type=TYPE_MESSAGE.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function user_message($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 1, self::TYPE_MESSAGE);
  }
  
  /**
   * An alias for Notifications::send, where $level=1 and $type=TYPE_WARNING.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function user_warning($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 1, self::TYPE_WARNING);
  }
  
  /**
   * An alias for Notifications::send, where $level=1 and $type=TYPE_ALERT.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function user_alert($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 1, self::TYPE_ALERT);
  }
  
  /**
   * An alias for Notifications::send, where $level=2 and $type=TYPE_MESSAGE.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function admin_message($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 2, self::TYPE_MESSAGE);
  }
  
  /**
   * An alias for Notifications::send, where $level=2 and $type=TYPE_WARNING.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function admin_warning($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 2, self::TYPE_WARNING);
  }
  
  /**
   * An alias for Notifications::send, where $level=2 and $type=TYPE_ALERT.
   * @param  string $message The message of the notification.
   * @param  string $url     An optional URL to link the notification to.
   * @param  int    $user_id An optional user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @return void
   */
  public function admin_alert($message, $url=null, $user_id=null)
  {
    return self::send($message, $url, $user_id, 2, self::TYPE_ALERT);
  }
  
  /**
   * Sends a new notification.
   * @param  string $message The message of the notification.
   * @param  string $url     A URL to link the notification to.
   * @param  int    $user_id A user ID to send the notification to. Not setting this value means, everyone (of this level).
   * @param  int    $level   The user level to target. 0 = public notification, 1 = user notification, 2 = administrative notification.
   * @param  int    $type    The type of notification. Such as messages, warnings or alerts. See the TYPE_ constants.
   * @return void
   */
  public static function send($message, $url, $user_id, $level, $type)
  {
    
    raw($message, $url);
    
    mk('Sql')->model('cms', 'Notifications')
      ->set(array(
        'message' => strip_tags($message),
        'user_id' => $user_id,
        'level' => $level,
        'type' => $type,
        'url' => $url ? (string)url($url) : null
      ))
      ->validate_model(array(
        'force_create' => true
      ))
      ->save();
    
  }
  
  /**
   * Converts an integer type value to string.
   * @param  integer $type Message type integer value.
   * @return string The string representation of the type.
   */
  public static function type_to_string($type=null)
  {
    
    raw($type);
    
    if($type && !is_numeric($type))
      throw new \exception\InvalidArgument('Message type needs to be an integer or null.');
    
    switch($type){
      case self::TYPE_ALERT:    return 'alert';
      case self::TYPE_WARNING:  return 'warning';
      case self::TYPE_MESSAGE:  return 'message';
      case self::TYPE_NONE:     return 'none';
      default: throw new \exception\InvalidArgument(sprintf('Unknown message type number %s.', $type));
    }
    
  }
  
  /**
   * Checks for notification support.
   * @return boolean
   */
  public static function is_supported()
  {
    
    //Cache this information.
    if(isset(self::$is_supported))
      return self::$is_supported;
    
    //Perform the test.
    try{
      mk('Sql')->table('cms', 'Notifications')
        ->execute_single();
      self::$is_supported = true;
    } catch (\exception\Sql $ex){
      self::$is_supported = false;
    }
    
    //Return the result.
    return self::$is_supported;
    
  }
  
}
