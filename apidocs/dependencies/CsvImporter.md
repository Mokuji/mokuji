# dependencies\CsvImporter
[API index](../API-index.md)






* Class name: CsvImporter
* Namespace: dependencies




## Class index

**Properties**
* [`protected mixed $component`](#property-component)
* [`protected mixed $file`](#property-file)
* [`protected mixed $retrying`](#property-retrying)
* [`protected mixed $title`](#property-title)
* [`private mixed $delimiter`](#property-delimiter)
* [`private mixed $errors`](#property-errors)
* [`private mixed $logs`](#property-logs)
* [`private mixed $resultset`](#property-resultset)
* [`private mixed $success`](#property-success)

**Methods**
* [`public mixed __construct(string $component, string $title, boolean $retry)`](#method-__construct)
* [`public \dependencies\CsvImporter commit(boolean $stop_on_errors)`](#method-commit)
* [`public array errors()`](#method-errors)
* [`public \dependencies\CsvImporter initialize_source_file(string $delimiter)`](#method-initialize_source_file)
* [`public boolean is_success()`](#method-is_success)
* [`public array logs()`](#method-logs)
* [`public \dependencies\CsvImporter process_import_data(string $main_model, array $field_titles, array $options)`](#method-process_import_data)
* [`public \dependencies\Data resultset()`](#method-resultset)
* [`protected void log(string $message, boolean $verbose)`](#method-log)
* [`protected \dependencies\Data session()`](#method-session)







# Properties


## Property `$component`
In class: [dependencies\CsvImporter](#top)

```
protected mixed $component
```

The component name this import is for.



* Visibility: **protected**


## Property `$file`
In class: [dependencies\CsvImporter](#top)

```
protected mixed $file
```

The location of the CSV file we're importing from.



* Visibility: **protected**


## Property `$retrying`
In class: [dependencies\CsvImporter](#top)

```
protected mixed $retrying
```

Whether or not this is a retry.



* Visibility: **protected**


## Property `$title`
In class: [dependencies\CsvImporter](#top)

```
protected mixed $title
```

The title of this particular import.



* Visibility: **protected**


## Property `$delimiter`
In class: [dependencies\CsvImporter](#top)

```
private mixed $delimiter
```

The CSV delimiter that will be used internally.



* Visibility: **private**


## Property `$errors`
In class: [dependencies\CsvImporter](#top)

```
private mixed $errors
```

The errors that occurred per row while processing.



* Visibility: **private**


## Property `$logs`
In class: [dependencies\CsvImporter](#top)

```
private mixed $logs
```

The various log messages.



* Visibility: **private**


## Property `$resultset`
In class: [dependencies\CsvImporter](#top)

```
private mixed $resultset
```

The result set we've arrived at from processing.



* Visibility: **private**


## Property `$success`
In class: [dependencies\CsvImporter](#top)

```
private mixed $success
```

Store whether the import was a success.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [dependencies\CsvImporter](#top)

```
mixed dependencies\CsvImporter::__construct(string $component, string $title, boolean $retry)
```

Creates a new CsvImporter object.



* Visibility: **public**

#### Arguments

* $component **string** - The name of the component to scope this import for.
* $title **string** - The (unique) title for the import being executed.
* $retry **boolean** - Whether or not we are retrying.






## Method `commit`
In class: [dependencies\CsvImporter](#top)

```
\dependencies\CsvImporter dependencies\CsvImporter::commit(boolean $stop_on_errors)
```

Commits the results from the processing we've done.



* Visibility: **public**

#### Arguments

* $stop_on_errors **boolean** - Whether errors during the commit should stop the rest of the commit. (Default: false)


#### Return value

**[dependencies\CsvImporter](../dependencies/CsvImporter.md)** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Programmer](../exception/Programmer.md)** - When processing has not been done yet.
* **[exception\Validation](../exception/Validation.md)** - When there were rows with unresolved errors.




## Method `errors`
In class: [dependencies\CsvImporter](#top)

```
array dependencies\CsvImporter::errors()
```

Getter for errors.



* Visibility: **public**






## Method `initialize_source_file`
In class: [dependencies\CsvImporter](#top)

```
\dependencies\CsvImporter dependencies\CsvImporter::initialize_source_file(string $delimiter)
```

Prepares the uploaded source CSV file to read data from.



* Visibility: **public**

#### Arguments

* $delimiter **string** - The CSV delimiter to use. Default is the previous setting or a comma.


#### Return value

**[dependencies\CsvImporter](../dependencies/CsvImporter.md)** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Unexpected](../exception/Unexpected.md)** - If the CVS import folder is missing.
* **[exception\Unexpected](../exception/Unexpected.md)** - If we can&#039;t find a unique filename.
* **[exception\InputMissing](../exception/InputMissing.md)** - If the upload of the CSV file failed.
* **[exception\Unexpected](../exception/Unexpected.md)** - If the uploaded file can&#039;t be copied to the CSV import folder.




## Method `is_success`
In class: [dependencies\CsvImporter](#top)

```
boolean dependencies\CsvImporter::is_success()
```

Whether the processing was successful or not.



* Visibility: **public**






## Method `logs`
In class: [dependencies\CsvImporter](#top)

```
array dependencies\CsvImporter::logs()
```

Getter for the logs.



* Visibility: **public**






## Method `process_import_data`
In class: [dependencies\CsvImporter](#top)

```
\dependencies\CsvImporter dependencies\CsvImporter::process_import_data(string $main_model, array $field_titles, array $options)
```

Read, map, sort and validate the import data.

Note: A source file must be initialized before this.

Options are: 'overrides', 'unique_fields', 'additional_models'.

Unique fields are an array of column_keys.
These will be checked for uniqueness in both the import and the existing database values.

Field titles are used to determine the order and in which models a field should be placed.
Field titles key-value pairs are defined like this:
'model_field' =&gt; 'Humanly readable field name'

Additional models will be inserted into the correct field through the relations defined in the main model.
Additional model field mappings are in this format:
'RelationName' =&gt; array('csv_field' =&gt; 'target_field' [, ...])

* Visibility: **public**

#### Arguments

* $main_model **string** - The name of the main model.
* $field_titles **array** - The titles of the fields in humanly readable format.
* $options **array** - An array of options for this processing attempt.


#### Return value

**[dependencies\CsvImporter](../dependencies/CsvImporter.md)** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Programmer](../exception/Programmer.md)** - If no source file has been initialized.
* **[exception\Programmer](../exception/Programmer.md)** - If no source delimiter has been set.
* **[exception\Programmer](../exception/Programmer.md)** - If the main model has no validation rules.
* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If additional models are defined while it&#039;s not supported yet.
* **[exception\NotFound](../exception/NotFound.md)** - If a defined relation is not found in the main model.
* **[exception\Programmer](../exception/Programmer.md)** - If a defined relation is mall-formatted in the main model.
* **[exception\Unexpected](../exception/Unexpected.md)** - If the CSV file can&#039;t be read.
* **[exception\Validation](../exception/Validation.md)** - If one of the required fields could not be mapped.




## Method `resultset`
In class: [dependencies\CsvImporter](#top)

```
\dependencies\Data dependencies\CsvImporter::resultset()
```

Getter for the result set.



* Visibility: **public**






## Method `log`
In class: [dependencies\CsvImporter](#top)

```
void dependencies\CsvImporter::log(string $message, boolean $verbose)
```

Logs a message.



* Visibility: **protected**

#### Arguments

* $message **string** - The message to log.
* $verbose **boolean** - Whether the message is a verbose one.






## Method `session`
In class: [dependencies\CsvImporter](#top)

```
\dependencies\Data dependencies\CsvImporter::session()
```

Shortcut to the session variables, scoped for this import.

Refers to &lt;component&gt; -&gt; import_&lt;title&gt; in the session object.

* Visibility: **protected**





