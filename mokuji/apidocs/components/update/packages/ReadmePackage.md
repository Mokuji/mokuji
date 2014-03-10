# components\update\packages\ReadmePackage
[API index](../../../API-index.md)






* Class name: ReadmePackage
* Namespace: components\update\packages
* Parent class: [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)




## Class index
**Constants**
* [`TYPE_ID`](#constant-type_id)

**Properties**
* [`protected static mixed $change_line`](#property-change_line)
* [`protected static mixed $changes_header_line`](#property-changes_header_line)
* [`protected static mixed $description_line`](#property-description_line)
* [`protected static mixed $header_line`](#property-header_line)

**Methods**
* [`public static boolean check($type, $name)`](#method-check)
* [`public static array parse_readme(string $filename)`](#method-parse_readme)
* [`public mixed db_updates()`](#method-db_updates)
* [`public \components\update\models\Packages model()`](#method-model)
* [`public string next_version(string $version)`](#method-next_version)
* [`public \dependencies\Data raw_data()`](#method-raw_data)
* [`public string reference_id()`](#method-reference_id)
* [`public boolean synchronize()`](#method-synchronize)
* [`public boolean update(boolean $forced, boolean $allow_sync)`](#method-update)
* [`public boolean version_bump(string $version, boolean $allow_sync)`](#method-version_bump)


## Inheritance index

**Properties**
* [`protected \components\update\models\Packages $model`](#property-model)
* [`protected string $name`](#property-name)
* [`protected \dependencies\Data $raw_data`](#property-raw_data)
* [`protected string $reference_id`](#property-reference_id)
* [`protected \components\update\enums\PackageType $type`](#property-type)

**Methods**
* [`public static boolean reference_support()`](#method-reference_support)
* [`public mixed __construct(\components\update\enums\PackageType $type, string $name)`](#method-__construct)
* [`public string current_version()`](#method-current_version)
* [`public string directory()`](#method-directory)
* [`public string latest_version()`](#method-latest_version)

# Constants


## Constant `TYPE_ID`
In class: [components\update\packages\ReadmePackage](#top)

```
const int TYPE_ID = 1
```

The type ID used in the packages table.





# Properties


## Property `$change_line`
In class: [components\update\packages\ReadmePackage](#top)

```
protected mixed $change_line = '~^[\*\-][ ]+([^\:]+)\:(.+)?$~'
```





* Visibility: **protected**
* This property is **static**.


## Property `$changes_header_line`
In class: [components\update\packages\ReadmePackage](#top)

```
protected mixed $changes_header_line = '~^#+[ ]*(Changes|Change[ ]log|History|Change history):?$~i'
```





* Visibility: **protected**
* This property is **static**.


## Property `$description_line`
In class: [components\update\packages\ReadmePackage](#top)

```
protected mixed $description_line = '~^[\*_]{2}(.+)[\*_]{2}$~'
```





* Visibility: **protected**
* This property is **static**.


## Property `$header_line`
In class: [components\update\packages\ReadmePackage](#top)

```
protected mixed $header_line = '~^#+[ ]*(.+)$~'
```





* Visibility: **protected**
* This property is **static**.


## Property `$model`
In class: [components\update\packages\ReadmePackage](#top)

```
protected \components\update\models\Packages $model
```

A cached instance of the model that refers to this package.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$name`
In class: [components\update\packages\ReadmePackage](#top)

```
protected string $name
```

The name of the package this instance refers to.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$raw_data`
In class: [components\update\packages\ReadmePackage](#top)

```
protected \dependencies\Data $raw_data
```

A cached instance of the raw package data.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$reference_id`
In class: [components\update\packages\ReadmePackage](#top)

```
protected string $reference_id
```

A cached instance of the reference ID.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$type`
In class: [components\update\packages\ReadmePackage](#top)

```
protected \components\update\enums\PackageType $type
```

The type of package this instance refers to.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


# Methods


## Method `check`
In class: [components\update\packages\ReadmePackage](#top)

```
boolean components\update\packages\ReadmePackage::check($type, $name)
```

Checks whether the requirements are met for this type of Package.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `parse_readme`
In class: [components\update\packages\ReadmePackage](#top)

```
array components\update\packages\ReadmePackage::parse_readme(string $filename)
```

Parses the given README.md file into package information.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $filename **string** - The absolute filename of the README.md file.


#### Return value

**array** - An array with keys and values for the parsed entities.







## Method `reference_support`
In class: [components\update\packages\ReadmePackage](#top)

```
boolean components\update\packages\AbstractPackage::reference_support()
```

Checks to see if package references are supported.



* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)






## Method `__construct`
In class: [components\update\packages\ReadmePackage](#top)

```
mixed components\update\packages\AbstractPackage::__construct(\components\update\enums\PackageType $type, string $name)
```

Create a new instance.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)

#### Arguments

* $type **[components\update\enums\PackageType](../../../components/update/enums/PackageType.md)** - The type of package the instance will refer to.
* $name **string** - The name of the package the instance will refer to.






## Method `current_version`
In class: [components\update\packages\ReadmePackage](#top)

```
string components\update\packages\AbstractPackage::current_version()
```

Retrieves the currently installed version of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The currently installed version of this package.







## Method `db_updates`
In class: [components\update\packages\ReadmePackage](#top)

```
mixed components\update\packages\ReadmePackage::db_updates()
```

Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.



* Visibility: **public**


#### Return value

**mixed** - The DBUpdates instance or null.







## Method `directory`
In class: [components\update\packages\ReadmePackage](#top)

```
string components\update\packages\AbstractPackage::directory()
```

Gets the (absolute) base directory of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The base directory of this package.







## Method `latest_version`
In class: [components\update\packages\ReadmePackage](#top)

```
string components\update\packages\AbstractPackage::latest_version()
```

Retrieves the latest available version of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The latest available version of this package.







## Method `model`
In class: [components\update\packages\ReadmePackage](#top)

```
\components\update\models\Packages components\update\packages\ReadmePackage::model()
```

Gets a model instance, referencing this package.



* Visibility: **public**






## Method `next_version`
In class: [components\update\packages\ReadmePackage](#top)

```
string components\update\packages\ReadmePackage::next_version(string $version)
```

Determines the next version that should be installed in the update order defined.



* Visibility: **public**

#### Arguments

* $version **string** - The version that is currently installed.


#### Return value

**string** - The version that should be installed next.







## Method `raw_data`
In class: [components\update\packages\ReadmePackage](#top)

```
\dependencies\Data components\update\packages\ReadmePackage::raw_data()
```

Retrieves the raw package data from the package files.



* Visibility: **public**


#### Return value

**[dependencies\Data](../../../dependencies/Data.md)** - The raw package data.







## Method `reference_id`
In class: [components\update\packages\ReadmePackage](#top)

```
string components\update\packages\ReadmePackage::reference_id()
```

Retrieves the reference ID of this package.



* Visibility: **public**


#### Return value

**string** - The reference ID of this package.







## Method `synchronize`
In class: [components\update\packages\ReadmePackage](#top)

```
boolean components\update\packages\ReadmePackage::synchronize()
```

Update the update system information to match the package information.



* Visibility: **public**


#### Return value

**boolean** - Whether or not syncing was completed successfully.







## Method `update`
In class: [components\update\packages\ReadmePackage](#top)

```
boolean components\update\packages\ReadmePackage::update(boolean $forced, boolean $allow_sync)
```

Perform an update to the latest version of the package.



* Visibility: **public**

#### Arguments

* $forced **boolean** - Forced update?
* $allow_sync **boolean** - Syncing allowed?


#### Return value

**boolean** - Whether or not new versions were installed.







## Method `version_bump`
In class: [components\update\packages\ReadmePackage](#top)

```
boolean components\update\packages\ReadmePackage::version_bump(string $version, boolean $allow_sync)
```

Tracks a version update of the package.

Note: $allow_sync should only be set to true to allow the update component to install itself.

* Visibility: **public**

#### Arguments

* $version **string** - The version of the package that is now installed.
* $allow_sync **boolean** - Whether or not to allow the package to be synced, to obtain version information.


#### Return value

**boolean** - Whether or not the version update was successful.






