<?php namespace components\backup\classes; if(!defined('MK')) die('No direct access.');

class TableBackup
{
  
  protected
    $table,
    $file,
    $comments,
    $started,
    $droped,
    $structured;
  
  /**
   * Creates a new TableBackup instance.
   * @param string $table The table name.
   * @param \components\backup\classes\FileHandler $file A file handler to write output to.
   * @param boolean $comments Whether or not to output comments.
   */
  public function __construct($table, $file, $comments=true)
  {
    
    //Store the parameters.
    $this->table = $table;
    $this->file = $file;
    $this->comments = !!$comments;
    
    //Keep track of a few actions.
    $this->started = false;
    $this->dropped = false;
    $this->structured = false;
    
    //Check the table.
    $this->check_table();
    
  }
  
  /**
   * Writes a DROP statement for the table.
   * @return void
   */
  public function write_drop_statement()
  {
    
    //Make sure we comment the table.
    $this->write_table_start_comment();
    
    //Comment.
    if($this->comments)
      $this->file->writeLine("# ".transf('backup', 'Drop any `{0}` tables.', $this->table));
    
    //Write query.
    $this->file->writeLine("DROP TABLE IF EXISTS `{$this->table}`;");
    $this->file->writeLine();
    
    //Track the drop.
    $this->dropped = true;
    
  }
  
  /**
   * Writes the table structure in a CREATE TABLE statement.
   * @return void
   */
  public function write_structure()
  {
    
    //Make sure we comment the table.
    $this->write_table_start_comment();
    
    //Comment.
    if($this->comments)
      $this->file->writeLine("# ".transf('backup', 'Structure for `{0}` table.', $this->table));
    
    //Get the create table statement.
    $result = mk('Sql')->execute_single("SHOW CREATE TABLE `{$this->table}`");
    $statement = $result->{'Create Table'}->get('string');
    
    //Check if we used a DROP statement. If not, use an IF NOT EXISTS condition.
    if(!$this->dropped){
      $statement = str_replace('CREATE TABLE ', 'CREATE TABLE IF NOT EXISTS ', $statement);
    }
    
    //Write the query.
    $this->file->writeLine($statement.';');
    $this->file->writeLine();
    
    //Track the structure.
    $this->structured = true;
    
  }
  
  /**
   * Writes the table data in one or more INSERT statements.
   * @return void
   */
  public function write_data($rows_per_insert=5)
  {
    
    raw($rows_per_insert);
    
    //Check that the table is not actually supposed to be gone at the moment.
    if($this->dropped && !$this->structured)
      throw new \exception\Programmer('The table is dropped. Write a structure before the data.');
    
    //Make sure we comment the table.
    $this->write_table_start_comment();
    
    //Get structure data.
    $structure = mk('Sql')->execute_query("DESCRIBE `{$this->table}`");
    $columns = $structure->map(function($col){ return array($col->Field->get('string') => $col); })->as_array();
    
    //Use that to create an insert statement.
    $insert_stmt = "INSERT INTO `{$this->table}` (`".implode('`, `', array_keys($columns)).'`) VALUES';
    
    //Know the times we need to loop.
    $total = mk('Sql')->execute_scalar("SELECT COUNT(*) FROM `{$this->table}`")->get('int');
    $rounds = ceil($total / $rows_per_insert);
    $round = 0;
    
    //Comment.
    if($this->comments)
      $this->file->writeLine("# ".transf('backup', 'Data for `{0}` table.', $this->table));
    
    //If there's no data, add a remark.
    if($total == 0)
    {
      
      if($this->comments)
        $this->file->writeLine("# ".transf('backup', '0 rows.'));
      
      $this->file->writeLine();
      return;
      
    }
    
    do
    {
      
      //Find the dataset for this round.
      $start = $round * $rows_per_insert;
      $results = mk('Sql')->execute_query("SELECT * FROM `{$this->table}` LIMIT $start, $rows_per_insert");
      $last = $results->size()-1;
      
      //Start with the insert statement.
      $this->file->writeLine($insert_stmt);
      
      //Then write [rows_per_insert] amount of values.
      foreach($results as $index => $row)
      {
        
        //Collect the formatted values.
        $values = array();
        
        //Insert the formatted values in the right order.
        foreach($columns as $name => $definition)
          $values[] = $this->formatValue($row->{$name}, $definition);
        
        //Write the value statement.
        $this->file->writeLine("(".implode(', ', $values).")".($index < $last ? ',' : ';'));
        
      }
      
      //Do it again.
      $round++;
      
    } while($round < $rounds);
    
    $this->file->writeLine();
    
  }
  
  public function write_table_start_comment()
  {
    
    //Skip if we are repeating ourselves or comments are not desirable.
    if($this->started || !$this->comments) return;
    
    $this->file->writeLine();
    $this->file->writeLine("# ---------------------------------------------------------");
    $this->file->writeLine("# ".transf('backup', 'Backup of table `{0}`.', $this->table));
    $this->file->writeLine("# ---------------------------------------------------------");
    $this->file->writeLine();
    $this->started = true;
    
  }
  
  /**
   * Checks if the table exists and is readable.
   */
  protected function check_table(){
    mk('Sql')->execute_query("DESCRIBE `{$this->table}`");
  }
  
  /**
   * Helper function to see if a string starts with a certain value.
   * @param string $search
   * @param string $subject
   * @param boolean $caseSensitive
   * @return boolean
   */
  protected function startsWith($search, $subject, $caseSensitive=false){
    raw($search, $subject, $caseSensitive);
    if($caseSensitive)
      return 0 === strpos($subject, $search);
    else
      return 0 === strpos(strtolower($subject), strtolower($search));
  }
  
  /**
   * Better addslashes. From phpMyAdmin.
   */
  protected function sqlAddslashes($a_string = '', $is_like = false) {
    raw($a_string, $is_like);
    if ($is_like) $a_string = str_replace('\\', '\\\\\\\\', $a_string);
    else $a_string = str_replace('\\', '\\\\', $a_string);
    return str_replace('\'', '\\\'', $a_string);
  }
  
  /**
   * Helper to clean the insert values.
   */
  protected function formatValue($input, $column)
  {
    
    raw($input);
    
    //Nothing to sanitize here.
    if($input === NULL)
      return 'NULL';
    
    //Special format for bits: b'00100101'
    if($this->startsWith('bit', $column['Type'])){
      $hex = unpack('H*',$input);
      $bin = base_convert($hex[1], 16, 2);
      return "b'{$bin}'";
    }
    
    //Integers don't need quotes.
    elseif(
      $this->startsWith('tinyint', $column['Type']) ||
      $this->startsWith('smallint', $column['Type']) ||
      $this->startsWith('mediumint', $column['Type']) ||
      $this->startsWith('int', $column['Type']) ||
      $this->startsWith('bigint', $column['Type'])
    ){
      return ''.intval($input);
    }
    
    //All other types, we don't trust them.
    else{
      
      //Sanitize wacky control characters, add quotes and slashes.
      return
        "'".
        str_replace(
          array("\x00", "\x0a", "\x0d", "\x1a"),
          array('\0',   '\n',   '\r',   '\Z'),
          $this->sqlAddslashes($input)
        ).
        "'";
      
    }
    
  }
  
}