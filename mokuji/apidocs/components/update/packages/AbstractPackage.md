# components\update\packages\AbstractPackage
[API index](../../../API-index.md)






* Class name: AbstractPackage
* Namespace: components\update\packages
* This is an **abstract** class




## Class index

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
* [`abstract public mixed db_updates()`](#method-db_updates)
* [`public string directory()`](#method-directory)
* [`public string latest_version()`](#method-latest_version)
* [`abstract public \components\update\models\Packages model()`](#method-model)
* [`abstract public string next_version(string $version)`](#method-next_version)
* [`abstract public \dependencies\Data raw_data()`](#method-raw_data)
* [`abstract public string reference_id()`](#method-reference_id)
* [`public boolean synchronize()`](#method-synchronize)
* [`abstract public boolean update(boolean $forced, boolean $allow_sync)`](#method-update)
* [`abstract public boolean version_bump(string $version, boolean $allow_sync)`](#method-version_bump)







# Properties


## Property `$model`
In class: [components\update\packages\AbstractPackage](#top)

```
protected \components\update\models\Packages $model
```

A cached instance of the model that refers to this package.



* Visibility: **protected**


## Property `$name`
In class: [components\update\packages\AbstractPackage](#top)

```
protected string $name
```

The name of the package this instance refers to.



* Visibility: **protected**


## Property `$raw_data`
In class: [components\update\packages\AbstractPackage](#top)

```
protected \dependencies\Data $raw_data
```

A cached instance of the raw package data.



* Visibility: **protected**


## Property `$reference_id`
In class: [components\update\packages\AbstractPackage](#top)

```
protected string $reference_id
```

A cached instance of the reference ID.



* Visibility: **protected**


## Property `$type`
In class: [components\update\packages\AbstractPackage](#top)

```
protected \components\update\enums\PackageType $type
```

The type of package this instance refers to.



* Visibility: **protected**


# Methods


## Method `reference_support`
In class: [components\update\packages\AbstractPackage](#top)

```
boolean components\update\packages\AbstractPackage::reference_support()
```

Checks to see if package references are supported.



* Visibility: **public**
* This method is **static**.






## Method `__construct`
In class: [components\update\packages\AbstractPackage](#top)

```
mixed components\update\packages\AbstractPackage::__construct(\components\update\enums\PackageType $type, string $name)
```

Create a new instance.



* Visibility: **public**

#### Arguments

* $type **[components\update\enums\PackageType](../../../components/update/enums/PackageType.md)** - The type of package the instance will refer to.
* $name **string** - The name of the package the instance will refer to.






## Method `current_version`
In class: [components\update\packages\AbstractPackage](#top)

```
string components\update\packages\AbstractPackage::current_version()
```

Retrieves the currently installed version of this package.



* Visibility: **public**


#### Return value

**string** - The currently installed version of this package.







## Method `db_updates`
In class: [components\update\packages\AbstractPackage](#top)

```
mixed components\update\packages\AbstractPackage::db_updates()
```

Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.



* Visibility: **public**
* This method is **abstract**.


#### Return value

**mixed** - The DBUpdates instance or null.







## Method `directory`
In class: [components\update\packages\AbstractPackage](#top)

```
string components\update\packages\AbstractPackage::directory()
```

Gets the (absolute) base directory of this package.



* Visibility: **public**


#### Return value

**string** - The base directory of this package.







## Method `latest_version`
In class: [components\update\packages\AbstractPackage](#top)

```
string components\update\packages\AbstractPackage::latest_version()
```

Retrieves the latest available version of this package.



* Visibility: **public**


#### Return value

**string** - The latest available version of this package.







## Method `model`
In class: [components\update\packages\AbstractPackage](#top)

```
\components\update\models\Packages components\update\packages\AbstractPackage::model()
```

Gets a model instance, referencing this package.



* Visibility: **public**
* This method is **abstract**.






## Method `next_version`
In class: [components\update\packages\AbstractPackage](#top)

```
string components\update\packages\AbstractPackage::next_version(string $version)
```

Determines the next version that should be installed in the update order defined.



* Visibility: **public**
* This method is **abstract**.

#### Arguments

* $version **string** - The version that is currently installed.


#### Return value

**string** - The version that should be installed next.







## Method `raw_data`
In class: [components\update\packages\AbstractPackage](#top)

```
\dependencies\Data components\update\packages\AbstractPackage::raw_data()
```

Retrieves the raw package data from the package files.



* Visibility: **public**
* This method is **abstract**.


#### Return value

**[dependencies\Data](../../../dependencies/Data.md)** - The raw package data.







## Method `reference_id`
In class: [components\update\packages\AbstractPackage](#top)

```
string components\update\packages\AbstractPackage::reference_id()
```

Retrieves the reference ID of this package.



* Visibility: **public**
* This method is **abstract**.


#### Return value

**string** - The reference ID of this package.







## Method `synchronize`
In class: [components\update\packages\AbstractPackage](#top)

```
boolean components\update\packages\AbstractPackage::synchronize()
```

Update the update system information to match the package information.



* Visibility: **public**


#### Return value

**boolean** - Whether or not syncing was completed successfully.







## Method `update`
In class: [components\update\packages\AbstractPackage](#top)

```
boolean components\update\packages\AbstractPackage::update(boolean $forced, boolean $allow_sync)
```

Perform an update to the latest version of the package.



* Visibility: **public**
* This method is **abstract**.

#### Arguments

* $forced **boolean** - Forced update?
* $allow_sync **boolean** - Syncing allowed?


#### Return value

**boolean** - Whether or not new versions were installed.







## Method `version_bump`
In class: [components\update\packages\AbstractPackage](#top)

```
boolean components\update\packages\AbstractPackage::version_bump(string $version, boolean $allow_sync)
```

Tracks a version update of the package.

Note: $allow_sync should only be set to true to allow the update component to install itself.

* Visibility: **public**
* This method is **abstract**.

#### Arguments

* $version **string** - The version of the package that is now installed.
* $allow_sync **boolean** - Whether or not to allow the package to be synced, to obtain version information.


#### Return value

**boolean** - Whether or not the version update was successful.






