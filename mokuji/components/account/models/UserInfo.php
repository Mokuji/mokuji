<?php namespace components\account\models; if(!defined('TX')) die('No direct access.');

class UserInfo extends \dependencies\BaseModel
{
  
  const
    STATUS_ACTIVATED = 1,
    STATUS_BANNED = 2,
    STATUS_CLAIMABLE = 4;
  
  protected static
    
    $table_name = 'account_user_info',
    
    $relations = array(
      'Accounts' => array('user_id' => 'Accounts.id')
    );
  
  public function get_avatar()
  {
    
    if(tx('Component')->available('media'))
      return tx('Sql')
        ->table('media', 'Images')
        ->pk($this->avatar_image_id)
        ->execute_single();
    
  }
  
  //Should it be empty,
  public function get_name(){
    return $this->account->first_name;
  }
  
  //Should it be empty,
  public function get_family_name(){
    return $this->account->last_name;
  }
  
  public function get_full_name()
  {
    
    //Try to get it from the main model.
    $full = $this->account->full_name;
    if(!$full->is_empty())
      return $full;
    
    $parts = Data();
    
    if($this->check('name') && !$this->name->is_empty())
      $parts->{null}->set($this->name);
    
    if($this->check('preposition') && !$this->preposition->is_empty())
      $parts->{null}->set($this->preposition);
      
    if($this->check('family_name') && !$this->family_name->is_empty())
      $parts->{null}->set($this->family_name);
    
    return $parts->join(' ');
    
  }
  
  public function set_status($value)
  {
    $value = data_of($value);
    
    switch(strtolower(gettype($value)))
    {
      
      //String values set or unset one binary flag at a time.
      case 'string':
        $c = $this->status->get('int');
        
        switch($value)
        {
          
          case 'activated':
            $n = ($c | self::STATUS_ACTIVATED);
            break;
          
          case 'deactivated':
            $n = ($c & ~self::STATUS_ACTIVATED);
            break;
            
          case 'banned':
            $n = ($c | self::STATUS_BANNED);
            break;
          
          case 'unbanned':
            $n = ($c & ~self::STATUS_BANNED);
            break;
          
          case 'reclaim':
            $n = ($c & ~self::STATUS_ACTIVATED); //Deactivate it
            $c = $n;
          case 'claimable':
            $n = ($c | self::STATUS_CLAIMABLE); //Add claimable
            break;
          
          case 'claimed':
            $n = ($c | self::STATUS_ACTIVATED); //Activate it
            $c = $n;
          case 'not_claimable':
            $n = ($c & ~self::STATUS_CLAIMABLE); //Remove claimable
            break;
          
          default:
            throw new \exception\InvalidArgument('Status %s is not implemented.', $value);
            break;
          
        }
        $this->status->set($n);
        
        break;
      
      //Integers set the whole status at once.
      case 'integer':
        $this->status->set($value);
        break;
      
      default:
        throw new \exception\InvalidArgument('Status cannot be parsed from input type %s. Expected: string|integer.', gettype($value));
      
    }
    
    //Allow chaining.
    return $this;
    
  }
  
  /**
   * Extending Successable with status checks.
   *
   * @author Beanow
   * @param mixed $value The status to check for either EXACT int (discoraged) or string.
   * @return UserInfo $this is returned for chaining.
   */
  public function check_status($value, $callback=null)
  {
    
    $value = data_of($value);
    
    switch(strtolower(gettype($value)))
    {
      
      //String values set or unset one binary flag at a time.
      case 'string':
        
        $c = $this->status->get('int');
        
        switch($value)
        {
          
          case 'activated':
            return $this->is(($c & self::STATUS_ACTIVATED) === self::STATUS_ACTIVATED, $callback);
          
          case 'deactivated':
            return $this->is(($c & self::STATUS_ACTIVATED) === 0, $callback);
            
          case 'banned':
            return $this->is(($c & self::STATUS_BANNED) === self::STATUS_BANNED, $callback);
          
          case 'unbanned':
            return $this->is(($c & self::STATUS_BANNED) === 0, $callback);
          
          case 'claimable':
            return $this->is(($c & self::STATUS_CLAIMABLE) === self::STATUS_CLAIMABLE, $callback);
            
          case 'not_claimable':
            return $this->is(($c & self::STATUS_CLAIMABLE) === 0, $callback);
          
          default:
            throw new \exception\InvalidArgument('Status %s is not implemented.', $value);
          
        }
        
        break;
      
      //Integers check the whole status at once.
      //Note this must be an exact match. No checks are optional.
      case 'int':
        return $this->is($this->status->get('int') === $value, $callback);
      
      default:
        throw new \exception\InvalidArgument('Status cannot be parsed from input type %s. Expected: string|int.', gettype($value));
      
    }
    
  }
  
  protected function get_account()
  {
    
    return $this->table('Accounts')
      ->pk($this->user_id->get('int'))
      ->execute_single();
    
  }
  
}
