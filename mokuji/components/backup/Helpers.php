<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected function get_backup_folder(){
    return PATH_FRAMEWORK.DS.'files'.DS.'backups';
  }
  
  protected function backup_database($profile)
  {
    
    //File information and handler.
    $path = $this->get_backup_folder().DS.
      'db_'.DB_NAME.'__'.$profile->name.'_profile__'.date('Y-m-d_H-i-s').'.sql';
    $file = new classes\FileHandler($path);
    
    //Table matching pattern.
    switch($profile->table_selection->get('string'))
    {
      
      case 'ALL':
        $like = '';
        break;
      
      case 'PREFIXED':
        $like = ' LIKE "'.DB_PREFIX.'%"';
        break;
      
      default:
        throw new \exception\Programmer('Unexpected Table selection value '.$profile->table_selection);
      
    }
    
    //Fetch table list.
    $tables = mk('Sql')->execute_query("SHOW TABLES$like");
    
    //Opening comments.
    if($profile->output_include_comments->get('boolean'))
    {
      
      $file->writeLine("# ");
      $file->writeLine("#   Mokuji database backup.");
      $file->writeLine("#   Generated: ".date('Y-m-d H:i:s'));
      $file->writeLine("#   Profile: ".$profile->name);
      $file->writeLine("#   Database: `".DB_NAME."`");
      $file->writeLine("#   Hostname: ".DB_HOST);
      $file->writeLine("# ");
      $file->writeLine("# =========================================================");
      $file->writeLine();
      
    }
    
    //Loop the tables and output them.
    foreach($tables as $table)
    {
      
      $tableBackup = new classes\TableBackup($table->idx(0), $file, $profile->output_include_comments);
      
      if($profile->table_drop->get('boolean'))
        $tableBackup->write_drop_statement();
      
      if($profile->table_structure->get('boolean'))
        $tableBackup->write_structure();
      
      if($profile->table_data->get('boolean'))
        $tableBackup->write_data($profile->table_rows_per_insert);
      
    }
    
    return $path;
    
  }
  
}
