<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class CsvImporter
{
  
  /**
   * The component name this import is for.
   */
  protected $component;
  
  /**
   * The title of this particular import.
   */
  protected $title;
  
  /**
   * Whether or not this is a retry.
   */
  protected $retrying;
  
  /**
   * The location of the CSV file we're importing from.
   */
  protected $file;
  
  /**
   * The CSV delimiter that will be used internally.
   */
  private $delimiter;
  
  /**
   * The various log messages.
   */
  private $logs;
  
  /**
   * The errors that occurred per row while processing.
   */
  private $errors;
  
  /**
   * The result set we've arrived at from processing.
   */
  private $resultset;
  
  /**
   * Store whether the import was a success.
   */
  private $success;
  
  
  /**
   * Getter for the logs.
   * @return array
   */
  public function logs()
  {
    
    isset($this->logs) ? $this->logs : array();
    
  }
  
  public function errors()
  {
    
    return isset($this->errors) ? $this->errors : array();
    
  }
  
  /**
   * Getter for the result set.
   */
  public function resultset()
  {
    
    return isset($this->resultset) ? $this->resultset : Data();
    
  }
  
  public function is_success()
  {
    
    return $this->success === true;
    
  }
  
  /**
   * Creates a new CsvImporter object.
   * @param string $component The name of the component to scope this import for.
   * @param string $title The (unique) title for the import being executed.
   * @param boolean $retry Whether or not we are retrying.
   */
  public function __construct($component, $title, $retry=false)
  {
    
    //Store the passed parameters.
    $this->component = (string)$component;
    $this->title = (string)$title;
    $this->retrying = (boolean)$retry;
    
    //Initialize some vars.
    $this->logs = array();
    $this->errors = array();
    $this->success = false;
    
    //Start the log.
    $this->log("Started an import".($this->retrying ? ' RETRY' : '')." for {$this->component}::{$this->title}.", true);
    
  }
  
  /**
   * Prepares the uploaded source CSV file to read data from.
   * @param string $delimiter The CSV delimiter to use. Default is the previous setting or a comma.
   * @return \dependencies\CsvImporter Returns $this for chaining.
   * @throws \exception\Unexpected If the CVS import folder is missing.
   * @throws \exception\Unexpected If we can't find a unique filename.
   * @throws \exception\InputMissing If the upload of the CSV file failed.
   * @throws \exception\Unexpected If the uploaded file can't be copied to the CSV import folder.
   */
  public function initialize_source_file($delimiter=null)
  {
    
    raw($delimiter);
    
    //Make sure the delimiter is set.
    if(empty($delimiter)){
      $delimiter = (string)$this->session()->delimiter->otherwise(',');
    }
    
    $this->log("Initializing source file with delimiter \"{$delimiter}\".", true);
    
    //When not retrying, remove all session data that might confuse things.
    if(!$this->retrying){
      
      //Delete any old files that are still being referred to.
      if(file_exists($this->session()->file->get('string'))){
        @unlink($this->session()->file->get('string'));
        $this->log("Removed old CSV file.", true);
      }
      
      //Clear the session data.
      $this->session()->un_set();
      $this->log("Cleared old session data.", true);
      
    }
    
    //We can skip handling file uploads if this is a retry and the file is available.
    if( !($this->retrying && $this->session()->file->is_set()) ){
      
      $this->log("Handling CSV file upload.", true);
      
      /* ---------- FILE HANDLING ---------- */
      
      //Create target dirs.
      $target_dir = PATH_BASE.DS.'files'.DS.'csv_imports'.DS;
      
      //Make sure the folder exists.
      if (!is_dir($target_dir)){
        $this->log("The CSV import folder (/files/csv_imports) is missing.");
        throw new \exception\Unexpected("The CSV import folder (/files/csv_imports) is missing. Please create this folder and make sure it has strict permissions.");
      }
      
      //Unique filename.
      $unique_attempts = 0;
      do{
        
        //Make sure we don't end up doing this forever.
        if($unique_attempts >= 15){
          $this->log("Made 15 attempts at creating a unique temporary CSV file.");
          throw new \exception\Unexpected("Made 15 attempts at creating a unique temporary CSV file. Has some script polluted the folder?");
        }
        
        $filename = tx('Security')->random_string(32).'.csv';
        $unique_attempts++;
        
      } while(file_exists($target_dir.$filename));
      
      //Handle file upload.
      if(!(tx('Data')->files->file->tmp_name->is_set() && is_uploaded_file(tx('Data')->files->file->tmp_name))){
        $this->log('Failed to store uploaded CSV file. Error: '.file_upload_error_message(tx('Data')->files->file->error));
        throw new \exception\InputMissing('Failed to store uploaded CSV file. Error: '.file_upload_error_message(tx('Data')->files->file->error));
      }
      
      //Open temp file.
      $out = fopen($target_dir.$filename, "wb");
      if(!$out){
        $this->log('Failed to open output stream. Does PHP have write permissions?');
        throw new \exception\Unexpected('Failed to open output stream. Does PHP have write permissions?');
      }
      
      //Read binary input stream and append it to temp file.
      $in = fopen(tx('Data')->files->file->tmp_name, "rb");
      if(!$in){
        $this->log('Failed to open input stream. Are the PHP settings correct?');
        throw new \exception\Unexpected('Failed to open input stream. Are the PHP settings correct?');
      }
      
      //Copy the contents.
      while($buff = fread($in, 4096)){
        fwrite($out, $buff);
      }
      
      //Clean up.
      fclose($in);
      fclose($out);
      @unlink(tx('Data')->files->file->tmp_name);
      
      $this->log('Stored the uploaded file.', true);
      
      //Store filename in case we need to stop for user feedback.
      $this->session()->file->set($target_dir.$filename);
      
    }
    
    //Set the file location in the object.
    $this->file = $this->session()->file->get('string');
    
    //Now store it.
    $this->delimiter = (string)$delimiter;
    $this->session()->delimiter->set($this->delimiter);
    
    $this->log('Completed Initializing source file.', true);
    
    //Allow chaining.
    return $this;
    
  }
  
  /**
   * Read, map, sort and validate the import data.
   * Note: A source file must be initialized before this.
   *
   * Options are: 'overrides', 'unique_fields', 'additional_models'.
   *
   * Unique fields are an array of column_keys.
   * These will be checked for uniqueness in both the import and the existing database values.
   *
   * Field titles are used to determine the order and in which models a field should be placed.
   * Field titles key-value pairs are defined like this:
   * 'model_field' => 'Humanly readable field name'
   * 
   * Additional models will be inserted into the correct field through the relations defined in the main model.
   * Additional model field mappings are in this format:
   * 'RelationName' => array('csv_field' => 'target_field' [, ...])
   *
   * @param string $main_model The name of the main model.
   * @param array $field_titles The titles of the fields in humanly readable format.
   * @param array $options An array of options for this processing attempt.
   * @return \dependencies\CsvImporter Returns $this for chaining.
   * @throws \exception\Programmer If no source file has been initialized.
   * @throws \exception\Programmer If no source delimiter has been set.
   * @throws \exception\Programmer If the main model has no validation rules.
   * @throws \exception\InvalidArgument If additional models are defined while it's not supported yet.
   * @throws \exception\NotFound If a defined relation is not found in the main model.
   * @throws \exception\Programmer If a defined relation is mall-formatted in the main model.
   * @throws \exception\Unexpected If the CSV file can't be read.
   * @throws \exception\Validation If one of the required fields could not be mapped.
   */
  public function process_import_data($main_model, $field_titles, $options=array())
  {
    
    //Prepare the input variables.
    raw($main_model, $field_titles);
    $options = Data($options);
    
    //Make option shortcuts.
    $overrides = $options->overrides->as_array();
    $unique_fields = $options->unique_fields->as_array();
    
    //Uncomment when it's supported.
    $additional_models = array(); //$options->additional_models->as_array();
    
    $this->log('Started processing import data with main model "'.$main_model.'".', true);
    
    //Reset some vars.
    $this->success = false;
    $this->errors = array();
    
    //We need to have a source file.
    if(!isset($this->file)){
      $this->log('No source file has been initialized.');
      throw new \exception\Programmer('No source file has been initialized.');
    }
    
    //We need to have a source file and a delimiter.
    if(!isset($this->delimiter)){
      $this->log('No source delimiter has been set.');
      throw new \exception\Programmer('No source delimiter has been set.');
    }
    
    //Map models.
    $main_model = load_model($this->component, $main_model);
    $models = array();
    $additional_fields = array();
    
    //Make sure the model has validation rules. Otherwise no importing.
    $validation_rules = $main_model::model_data('validate');
    if(empty($validation_rules)){
      $this->log('Main model does not have model validation rules.');
      throw new \exception\Programmer('Main model does not have model validation rules. This is required for the import.');
    }
    
    //For all additional models.
    foreach($additional_models as $relation => $mapping)
    {
      
      #TODO: Support this.
      $this->log('Tried to use additional models.');
      throw new \exception\InvalidArgument("Additional models are not supported yet.");
      
      /*
      //Store information about the model.
      $models[$relation] = $main_model::get_related_model($relation);
      
      //Map the fields for this model.
      foreach($mapping as $src => $tgt)
      {
        
        //There may be no duplicates here, or mapping would be confusing.
        if(array_key_exists($src, $additional_fields))
          throw new \exception\Programmer('Duplicate source field "%s" for additional model mapping.', $src);
        
        //Store the meta we need.
        $additional_fields[$src] => array(
          'relation' => $relation,
          'name' => $tgt
        );
        
      }
      */
      
    }
    
    //Open CSV stream.
    if(($handle = fopen($this->file, 'r')) === false){
      $this->log('Unable to read CSV file "'.$this->file.'"');
      throw new \exception\Unexpected('Unable to read CSV file "%s"', $this->file);
    }
    
    //Initialize some counters and mappings.
    $row_number = 0;
    $map = array();
    $resultset = Data();
    $unique_occurances = Data();
    
    $this->log("Start reading CSV file.", true);
    
    //Parse lines.
    while(($row = fgetcsv($handle, 0, $this->delimiter)) !== false)
    {
      
      $this->log("Processing row number $row_number.", true);
      
      //First row is the CSV's field definition.
      if($row_number === 0){
        
        //If this is a retry we should already have a mapping.
        if($this->retrying && $this->session()->map->is_set()){
          $this->log('Using a cached mapping.', true);
          $map = $this->session()->map->as_array();
        }
        
        //Otherwise generate it now.
        else{
          
          $this->log('Creating a new mapping.', true);
          
          //For every column in the CSV row.
          foreach($row as $index => $collumn_name)
          {
            
            $startcount = count($map);
            
            //For every field definition.
            foreach($field_titles as $colname_db => $colname_csv)
            {
              
              //If the sanitized version of the CSV and humanly readable version match.
              if(strtolower(trim($colname_csv)) == strtolower(trim($collumn_name))){
                //Store this match and break the inner loop.
                $map[$colname_db] = $index;
                break;
              }
              
            }
            
            if(count($map) === $startcount){
              $this->log("Did not find \"$colname_db\" titled \"$colname_csv\".");
            }
            
          }
          
          //Check all required fields are mapped.
          foreach ($main_model::model_data('validate') as $field => $rules)
          {
            
            //If the field is not required. Skip this.
            if(!in_array('required', $rules))
              continue;
            
            //Otherwise, check if it is defined.
            if(!(isset($map[$field]) && is_int($map[$field])))
            {
              
              $this->log("Required field \"$field\" was not found.");
              
              throw new \exception\Validation(
                'The required column "%s" has not been mapped in the first row of the CSV file. '.
                'Please check your column names and CSV delimiter.',
                $field
              );
              
            }
            
          }
          
          $this->log('Mapping completed.', true);
          
          //Store this mapping in the session along with the file.
          $this->session()->map->set($map);
          
          #TODO: Check required fields for additional models. (Otherwise the additional model would be useless.)
          #TODO: MAYBE check if all supplied humanly readable fields are matched.
          #TODO: Abort on errors here.
          
        }
        
      }
      
      //Not the first row, so a data row.
      else{
        
        //Find any override options and use the Data helper.
        $override = Data(isset($overrides[$row_number]) ? $overrides[$row_number] : array());
        
        //Since errors might occur on a row and we want to override it later, make a big try-catch block.
        try{
          
          //Prepare the main model object.
          $mapped_row = new $main_model();
          
          //Check if the row should be skipped.
          if(!$override->skip->is_true()){
            
            //Map the raw data of this row.
            foreach($map as $field_key => $index){
              $mapped_row->merge(array($field_key => trim($override->{$field_key}->is_set() ? $override->{$field_key}->get() : $row[$index])));
            }
            
            $this->log("Mapped data row as: ".$mapped_row->dump(), true);
            
            #TODO: Detect which fields are intended for additional models and which for the main model.
            #TODO: Validate the additional models.
            #TODO: Check for duplicates for the additional models (if they are supposed to be unique).
            #TODO: Insert fake ID's in the main model data for valid additional models.
            
            $this->log("Validating model.", true);
            
            //Validate the main model.
            $mapped_row->validate_model(array(
              'nullify'=>true
            ));
            
            //Check for duplicates when they need to be unique.
            foreach($unique_fields as $field){
              
              $this->log("Checking for duplicate value for \"$field\".", true);
              
              //Check in the import so far.
              if(in_array($mapped_row->{$field}->get(), $unique_occurances->{$field}->as_array())){
                $this->log(sprintf('Duplicate "%s" value for field "%s" in the CSV file.', $mapped_row->{$field}->get(), $field));
                $ex = new \exception\Validation('Duplicate "%s" value for field "%s" in the CSV file.', $mapped_row->{$field}->get(), $field);
                $ex->key($field);
                throw $ex;
              }
              
              //Check the database.
              tx('Sql')
                ->table($mapped_row->component(), $mapped_row->model())
                ->where($field, "'{$mapped_row[$field]}'")
                
                //See if we have a hit.
                ->count()->gt(0, function()use($mapped_row, $field){
                  $this->log(sprintf('Duplicate "%s" value for field "%s" in the database.', $mapped_row->{$field}->get(), $field));
                  $ex = new \exception\Validation('Duplicate "%s" value for field "%s" in the database.', $mapped_row->{$field}->get(), $field);
                  $ex->key($field);
                  throw $ex;
                });
              
            }//End - foreach unique field.
            
            $this->log("Row is valid and added to results.", true);
            
            //Since there are no errors, add this item to the results.
            $resultset->merge(array($row_number => $mapped_row));
            
            #TODO: Add additional models to result set.
            
          }//End - if not skipping.
          
          //When skipping, simply log it.
          else{
            $this->log('Skipped this row.', true);
          }
          
        } //End - try block.
        
        //When the row was not valid, store it and keep going.
        catch(\exception\ModelValidation $vex){
          
          $this->log("Row is invalid and added to the errors with message \"{$vex->getMessage()}\".", true);
          
          //Append the error.
          $this->errors[$row_number] = array(
            'message' => $vex->getMessage(),
            'errors' => $vex->errors,
            'input' => $mapped_row,
            'row_number' => $row_number,
            'field' => $vex instanceof \exception\Validation ? $vex->key() : null,
            'overrides' => $override
          );
          
        }
        
        //When the row was not valid, store it and keep going.
        catch(\exception\Validation $vex){
          
          $this->log("Row is invalid and added to the errors with message \"{$vex->getMessage()}\".", true);
          
          //Append the error.
          $this->errors[$row_number] = array(
            'message' => $vex->getMessage(),
            'errors' => $vex->errors(),
            'input' => $mapped_row,
            'row_number' => $row_number,
            'field' => $vex instanceof \exception\Validation ? $vex->key() : null,
            'overrides' => $override
          );
          
        }
        
      } //End - data row 'else'.
      
      $this->log("Completed row number $row_number.", true);
      
      //Increment row numbers.
      $row_number++;
      
    }//End - CSV reading while-loop.
    
    $this->log("Completed reading CSV file.", true);
    
    //Close CSV stream.
    fclose($handle);
    
    $this->resultset = $resultset;
    $this->log("Completed processing.", true);
    
    //Allow chaining.
    return $this;
    
    #TODO: Add commit function.
    #TODO: Add form generator functions for the CSV humanly readable mapping and overriding forms.
    
  }
  
  /**
   * Commits the results from the processing we've done.
   * @param boolean $stop_on_errors Whether errors during the commit should stop the rest of the commit. (Default: false)
   * @return \dependencies\CsvImporter Returns $this for chaining.
   * @throws \exception\Programmer When processing has not been done yet.
   * @throws \exception\Validation When there were rows with unresolved errors.
   */
  public function commit($stop_on_errors=false)
  {
    
    $this->log("Attempting commit.", true);
    
    //Reset success var.
    $this->success = false;
    
    //Check the processing has been done.
    if(!isset($this->resultset)){
      $this->log('The CSV file is not processed yet.');
      throw new \exception\Programmer('The CSV file is not processed yet.');
    }
    
    //Check there are no unresolved errors left.
    if(count($this->errors) > 0){
      $this->log('Some rows are still invalid.');
      $ex = new \exception\Validation('Some rows are still invalid. Please correct them first.');
      $ex->errors($this->errors);
      throw $ex;
    }
    
    //Assume all goes well.
    $success = true;
    
    $this->log("Starting to save.", true);
    
    //Save all items to the database.
    $this->resultset->each(function($result, $row)use($stop_on_errors, &$success){
      
      try{
        $result->save();
        $this->log("Successfully saved row number $row.", true);
      }
      
      catch(\Exception $ex){
        
        $this->log("Failed to save row number $row. Error message: ".$ex->getMessage());
        
        //Exceptions should only be thrown when we should stop on errors.
        if($stop_on_errors === true)
          throw $ex;
        
        //Otherwise simply report failure.
        else
          $success = false;
        
      }
      
    });
    
    //Delete the temp file.
    $this->session()->file->is('set', function($file){
      $this->log("Deleting the CSV file \"$file\".", true);
      @unlink($file->get());
    });
    
    //Clear all other session data, since we're done!
    $this->log("Clearing session variables.", true);
    $this->session()->un_set();
    
    //Store the result.
    $this->success = $success;
    $this->log("The commit was ".($success ? 'successful' : 'unsuccessful').".", true);
    
    //Allow chaining.
    return $this;
    
  }
  
  /**
   * Shortcut to the session variables, scoped for this import.
   * Refers to <component> -> import_<title> in the session object.
   * @return \dependencies\Data
   */
  protected function session()
  {
    
    return tx('Data')->session->{$this->component}->{'import_'.$this->title};
    
  }
  
  /**
   * Logs a message.
   * @param string $message The message to log.
   * @param boolean $verbose Whether the message is a verbose one.
   * @return void
   */
  protected function log($message, $verbose=false)
  {
    
    //Insert the log message into the import logs.
    array_push($this->logs, array(
      'message' => (string)$message,
      'verbose' => (boolean)$verbose
    ));
    
    //Also call the core logging functions.
    tx('Logging')->log('CSV Importer', 'Import '.$this->component.'::'.$this->title, ((boolean)$verbose ? 'VERBOSE ' : '').(string)$message);
    
  }
  
}
