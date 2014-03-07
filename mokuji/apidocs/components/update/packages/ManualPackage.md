# components\update\packages\ManualPackage
[API index](../../../API-index.md)






* Class name: ManualPackage
* Namespace: components\update\packages
* Parent class: [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)




## Class index
**Constants**
* [`TYPE_ID`](#constant-type_id)

**Properties**
* [`protected boolean $db_updates`](#property-db_updates)
* [`protected string $latest_version`](#property-latest_version)

**Methods**
* [`public static boolean check($type, $name)`](#method-check)
* [`public mixed __construct(\components\update\enums\PackageType $type, string $name)`](#method-__construct)
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
* [`public string current_version()`](#method-current_version)
* [`public string directory()`](#method-directory)
* [`public string latest_version()`](#method-latest_version)

# Constants


## Constant `TYPE_ID`
In class: [components\update\packages\ManualPackage](#top)

```
const int TYPE_ID = 0
```

The type ID used in the packages table.





# Properties


## Property `$db_updates`
In class: [components\update\packages\ManualPackage](#top)

```
protected boolean $db_updates
```

Whether or not the raw package data indicates to contain database updates.



* Visibility: **protected**


## Property `$latest_version`
In class: [components\update\packages\ManualPackage](#top)

```
protected string $latest_version
```

The latest version as defined by the raw package data.



* Visibility: **protected**


## Property `$model`
In class: [components\update\packages\ManualPackage](#top)

```
protected \components\update\models\Packages $model
```

A cached instance of the model that refers to this package.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$name`
In class: [components\update\packages\ManualPackage](#top)

```
protected string $name
```

The name of the package this instance refers to.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$raw_data`
In class: [components\update\packages\ManualPackage](#top)

```
protected \dependencies\Data $raw_data
```

A cached instance of the raw package data.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$reference_id`
In class: [components\update\packages\ManualPackage](#top)

```
protected string $reference_id
```

A cached instance of the reference ID.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


## Property `$type`
In class: [components\update\packages\ManualPackage](#top)

```
protected \components\update\enums\PackageType $type
```

The type of package this instance refers to.



* Visibility: **protected**
* This property is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


# Methods


## Method `check`
In class: [components\update\packages\ManualPackage](#top)

```
boolean components\update\packages\ManualPackage::check($type, $name)
```

Checks whether the requirements are met for this type of Package.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `reference_support`
In class: [components\update\packages\ManualPackage](#top)

```
boolean components\update\packages\AbstractPackage::reference_support()
```

Checks to see if package references are supported.



* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)






## Method `__construct`
In class: [components\update\packages\ManualPackage](#top)

```
mixed components\update\packages\ManualPackage::__construct(\components\update\enums\PackageType $type, string $name)
```

Create a new instance.



* Visibility: **public**

#### Arguments

* $type **[components\update\enums\PackageType](../../../components/update/enums/PackageType.md)** - The type of package the instance will refer to.
* $name **string** - The name of the package the instance will refer to.






## Method `current_version`
In class: [components\update\packages\ManualPackage](#top)

```
string components\update\packages\AbstractPackage::current_version()
```

Retrieves the currently installed version of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The currently installed version of this package.







## Method `db_updates`
In class: [components\update\packages\ManualPackage](#top)

```
mixed components\update\packages\ManualPackage::db_updates()
```

Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.



* Visibility: **public**


#### Return value

**mixed** - The DBUpdates instance or null.







## Method `directory`
In class: [components\update\packages\ManualPackage](#top)

```
string components\update\packages\AbstractPackage::directory()
```

Gets the (absolute) base directory of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The base directory of this package.







## Method `latest_version`
In class: [components\update\packages\ManualPackage](#top)

```
string components\update\packages\AbstractPackage::latest_version()
```

Retrieves the latest available version of this package.



* Visibility: **public**
* This method is defined by [components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)


#### Return value

**string** - The latest available version of this package.







## Method `model`
In class: [components\update\packages\ManualPackage](#top)

```
\components\update\models\Packages components\update\packages\ManualPackage::model()
```

Gets a model instance, referencing this package.



* Visibility: **public**






## Method `next_version`
In class: [components\update\packages\ManualPackage](#top)

```
string components\update\packages\ManualPackage::next_version(string $version)
```

Determines the next version that should be installed in the update order defined.



* Visibility: **public**

#### Arguments

* $version **string** - The version that is currently installed.


#### Return value

**string** - The version that should be installed next.







## Method `raw_data`
In class: [components\update\packages\ManualPackage](#top)

```
\dependencies\Data components\update\packages\ManualPackage::raw_data()
```

Retrieves the raw package data from the package files.



* Visibility: **public**


#### Return value

**[dependencies\Data](../../../dependencies/Data.md)** - The raw package data.







## Method `reference_id`
In class: [components\update\packages\ManualPackage](#top)

```
string components\update\packages\ManualPackage::reference_id()
```

Retrieves the reference ID of this package.



* Visibility: **public**


#### Return value

**string** - The reference ID of this package.







## Method `synchronize`
In class: [components\update\packages\ManualPackage](#top)

```
boolean components\update\packages\ManualPackage::synchronize()
```

Update the update system information to match the package information.



* Visibility: **public**


#### Return value

**boolean** - Whether or not syncing was completed successfully.







## Method `update`
In class: [components\update\packages\ManualPackage](#top)

```
boolean components\update\packages\ManualPackage::update(boolean $forced, boolean $allow_sync)
```

Perform an update to the latest version of the package.



* Visibility: **public**

#### Arguments

* $forced **boolean** - Forced update?
* $allow_sync **boolean** - Syncing allowed?


#### Return value

**boolean** - Whether or not new versions were installed.







## Method `version_bump`
In class: [components\update\packages\ManualPackage](#top)

```
boolean components\update\packages\ManualPackage::version_bump(string $version, boolean $allow_sync)
```

Tracks a version update of the package.

Note: $allow_sync should only be set to true to allow the update component to install itself.

* Visibility: **public**

#### Arguments

* $version **string** - The version of the package that is now installed.
* $allow_sync **boolean** - Whether or not to allow the package to be synced, to obtain version information.


#### Return value

**boolean** - Whether or not the version update was successful.






