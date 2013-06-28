# dependencies\init\Initializer
[API index](../../API-index.md)

A singleton class that allows you to initialize a Mokuji runtime.




* Class name: Initializer
* Namespace: dependencies\init




## Class index
**Constants**
* [`ENV_BACKEND`](#constant-env_backend)
* [`ENV_FRONTEND`](#constant-env_frontend)
* [`ENV_INSTALL`](#constant-env_install)
* [`ENV_MINIMAL`](#constant-env_minimal)
* [`ENV_SHELL`](#constant-env_shell)

**Properties**
* [`private static \dependencies\Initializer $instance`](#property-instance)
* [`protected boolean $debugging`](#property-debugging)
* [`protected integer $environment`](#property-environment)
* [`protected boolean $is_installed`](#property-is_installed)
* [`protected string $root`](#property-root)
* [`protected string $url_path`](#property-url_path)
* [`protected boolean $use_database`](#property-use_database)
* [`protected boolean $use_multisite`](#property-use_multisite)

**Methods**
* [`public static \dependencies\Initializer get_instance()`](#method-get_instance)
* [`public \dependencies\Initializer enable_database(boolean $value)`](#method-enable_database)
* [`public \dependencies\Initializer enable_debugging(boolean $value)`](#method-enable_debugging)
* [`public \dependencies\Initializer enable_multisite(boolean $value)`](#method-enable_multisite)
* [`public string get_url_path()`](#method-get_url_path)
* [`public boolean is_installed()`](#method-is_installed)
* [`public void run_environment()`](#method-run_environment)
* [`public \dependencies\Initializer set_environment(integer $environment)`](#method-set_environment)
* [`public \dependencies\Initializer set_root(string $value)`](#method-set_root)
* [`public \dependencies\Initializer set_url_path(string $value)`](#method-set_url_path)
* [`private mixed __construct()`](#method-__construct)





# Constants


## Constant `ENV_BACKEND`
In class: [dependencies\init\Initializer](#top)

```
const ENV_BACKEND = 2
```





## Constant `ENV_FRONTEND`
In class: [dependencies\init\Initializer](#top)

```
const ENV_FRONTEND = 1
```





## Constant `ENV_INSTALL`
In class: [dependencies\init\Initializer](#top)

```
const ENV_INSTALL = 3
```





## Constant `ENV_MINIMAL`
In class: [dependencies\init\Initializer](#top)

```
const ENV_MINIMAL = 4
```





## Constant `ENV_SHELL`
In class: [dependencies\init\Initializer](#top)

```
const ENV_SHELL = 0
```





# Properties


## Property `$instance`
In class: [dependencies\init\Initializer](#top)

```
private \dependencies\Initializer $instance
```

The instance of this class.



* Visibility: **private**
* This property is **static**.


## Property `$debugging`
In class: [dependencies\init\Initializer](#top)

```
protected boolean $debugging
```

Whether or not to use debugging options for this run.



* Visibility: **protected**


## Property `$environment`
In class: [dependencies\init\Initializer](#top)

```
protected integer $environment
```

The environment to be used in this run.



* Visibility: **protected**


## Property `$is_installed`
In class: [dependencies\init\Initializer](#top)

```
protected boolean $is_installed
```

Whether or not the current runtime has completed it's installation.



* Visibility: **protected**


## Property `$root`
In class: [dependencies\init\Initializer](#top)

```
protected string $root = ''
```

Where we can find the root of this installation.



* Visibility: **protected**


## Property `$url_path`
In class: [dependencies\init\Initializer](#top)

```
protected string $url_path
```

Optional url_path override.

Allows you to run the environment from different files than the index.php in the root.

* Visibility: **protected**


## Property `$use_database`
In class: [dependencies\init\Initializer](#top)

```
protected boolean $use_database
```

Whether or not the database should be used in this run.



* Visibility: **protected**


## Property `$use_multisite`
In class: [dependencies\init\Initializer](#top)

```
protected boolean $use_multisite
```

Whether multi-site detection should be used in this run.



* Visibility: **protected**


# Methods


## Method `get_instance`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::get_instance()
```

Gets the instance of this class.



* Visibility: **public**
* This method is **static**.


#### Return value

**dependencies\Initializer** - The instance of this class.







## Method `enable_database`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::enable_database(boolean $value)
```

Allows you to set whether the database should be enabled or not.



* Visibility: **public**

#### Arguments

* $value **boolean** - Whether or not to enable the database. Default: true


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `enable_debugging`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::enable_debugging(boolean $value)
```

Allows you to set whether debugging should be enabled or not.



* Visibility: **public**

#### Arguments

* $value **boolean** - Whether or not to enable debugging. Default: true


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `enable_multisite`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::enable_multisite(boolean $value)
```

Allows you to set whether multi-site support should be enabled or not.



* Visibility: **public**

#### Arguments

* $value **boolean** - Whether or not to enable multi-site support. Default: true


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `get_url_path`
In class: [dependencies\init\Initializer](#top)

```
string dependencies\init\Initializer::get_url_path()
```

A getter for the URL path.

If no override is set this will try to detect it.

* Visibility: **public**


#### Return value

**string** - The currently assumed URL path.







## Method `is_installed`
In class: [dependencies\init\Initializer](#top)

```
boolean dependencies\init\Initializer::is_installed()
```

Detects whether this runtime has been installed.



* Visibility: **public**


#### Return value

**boolean** - Whether this runtime has been installed.







## Method `run_environment`
In class: [dependencies\init\Initializer](#top)

```
void dependencies\init\Initializer::run_environment()
```

Runs the selected environment with the current settings.



* Visibility: **public**






## Method `set_environment`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::set_environment(integer $environment)
```

Allows you to set the desired environment type.



* Visibility: **public**

#### Arguments

* $environment **integer** - The environment to set.


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `set_root`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::set_root(string $value)
```

Allows you to set the root of the environment.



* Visibility: **public**

#### Arguments

* $value **string** - The path to the root of the environment.


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `set_url_path`
In class: [dependencies\init\Initializer](#top)

```
\dependencies\Initializer dependencies\init\Initializer::set_url_path(string $value)
```

Allows you to set the url_path if it is not the default.



* Visibility: **public**

#### Arguments

* $value **string** - The url_path to assume of the environment.


#### Return value

**dependencies\Initializer** - This instance, for chaining.







## Method `__construct`
In class: [dependencies\init\Initializer](#top)

```
mixed dependencies\init\Initializer::__construct()
```

Private constructor to create the instance.



* Visibility: **private**





