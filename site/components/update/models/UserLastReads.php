<?php namespace components\update\models; if(!defined('TX')) die('No direct access.');

class UserLastReads extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'update_user_last_reads',
    
    $relations = array(
      'Accounts' => array('user_id' => 'Account.Accounts.id')
    );
  
  public function get_account()
  {
    
    return tx('Sql')
      ->table('account', 'Accounts')
      ->pk($this->user_id)
      ->execute_single();
    
  }
  
}
