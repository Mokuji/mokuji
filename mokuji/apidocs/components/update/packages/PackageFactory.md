# components\update\packages\PackageFactory
[API index](../../../API-index.md)






* Class name: PackageFactory
* Namespace: components\update\packages
* This is an **abstract** class




## Class index

**Properties**
* [`protected static array $cached_packages`](#property-cached_packages)

**Methods**
* [`public static string directory(\components\update\enums\PackageType $type, string $name)`](#method-directory)
* [`public static \components\update\packages\AbstractPackage get(\components\update\enums\PackageType $type, string $name)`](#method-get)







# Properties


## Property `$cached_packages`
In class: [components\update\packages\PackageFactory](#top)

```
protected array $cached_packages = array()
```

The packages that have already been requested.



* Visibility: **protected**
* This property is **static**.


# Methods


## Method `directory`
In class: [components\update\packages\PackageFactory](#top)

```
string components\update\packages\PackageFactory::directory(\components\update\enums\PackageType $type, string $name)
```

Gets the (absolute) base directory of this package.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **[components\update\enums\PackageType](../../../components/update/enums/PackageType.md)** - The type of package.
* $name **string** - The name of the package.


#### Return value

**string** - The base directory of this package.







## Method `get`
In class: [components\update\packages\PackageFactory](#top)

```
\components\update\packages\AbstractPackage components\update\packages\PackageFactory::get(\components\update\enums\PackageType $type, string $name)
```

Gets the package class corresponding to provided type and name.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **[components\update\enums\PackageType](../../../components/update/enums/PackageType.md)** - The type of package to retrieve.
* $name **string** - The name of the package to retrieve (optional for the core).


#### Return value

**[components\update\packages\AbstractPackage](../../../components/update/packages/AbstractPackage.md)** - The package class corresponding to this package.






