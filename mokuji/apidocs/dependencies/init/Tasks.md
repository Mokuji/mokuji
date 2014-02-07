# dependencies\init\Tasks
[API index](../../API-index.md)

A static class that performs atomic tasks to initialize Mokuji.




* Class name: Tasks
* Namespace: dependencies\init
* This is an **abstract** class




## Class index


**Methods**
* [`public static void apply_debugging(boolean $debugging)`](#method-apply_debugging)
* [`public static \stdClass get_site_properties(string $url_path, boolean $is_installed, boolean $use_database, boolean $use_multisite)`](#method-get_site_properties)
* [`public static void http_fixes()`](#method-http_fixes)
* [`public static void load_configuration_files(string $root, boolean $is_installed, boolean $use_database)`](#method-load_configuration_files)
* [`public static void load_functions()`](#method-load_functions)
* [`public static void register_error_handlers($environment)`](#method-register_error_handlers)









# Methods


## Method `apply_debugging`
In class: [dependencies\init\Tasks](#top)

```
void dependencies\init\Tasks::apply_debugging(boolean $debugging)
```

Apply the implications of enabling or disabling debugging.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $debugging **boolean** - Whether or not debugging has been enabled.






## Method `get_site_properties`
In class: [dependencies\init\Tasks](#top)

```
\stdClass dependencies\init\Tasks::get_site_properties(string $url_path, boolean $is_installed, boolean $use_database, boolean $use_multisite)
```

Performs a lookup for the site properties based on the Initializer configuration.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $url_path **string** - The url_path override given to Initializer.
* $is_installed **boolean** - Whether or not Mokuji has been marked as installed.
* $use_database **boolean** - Whether or not the database should be used this page load.
* $use_multisite **boolean** - Whether or not multi-site support should be provided.


#### Return value

**stdClass** - A class containing the sites properties.







## Method `http_fixes`
In class: [dependencies\init\Tasks](#top)

```
void dependencies\init\Tasks::http_fixes()
```

Performs any fixes needed for proper HTTP(S) functioning.



* Visibility: **public**
* This method is **static**.






## Method `load_configuration_files`
In class: [dependencies\init\Tasks](#top)

```
void dependencies\init\Tasks::load_configuration_files(string $root, boolean $is_installed, boolean $use_database)
```

Loads the configuration files that apply to the current initialization settings.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $root **string** - The path to the base of the installation.
* $is_installed **boolean** - Whether or not the installation has been flagged as completely installed.
* $use_database **boolean** - Whether or not to use the database this page load.






## Method `load_functions`
In class: [dependencies\init\Tasks](#top)

```
void dependencies\init\Tasks::load_functions()
```

Loads all the system functions.



* Visibility: **public**
* This method is **static**.






## Method `register_error_handlers`
In class: [dependencies\init\Tasks](#top)

```
void dependencies\init\Tasks::register_error_handlers($environment)
```

Register error handlers for errors and exceptions.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $environment **mixed**





