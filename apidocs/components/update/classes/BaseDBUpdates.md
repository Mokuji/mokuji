# components\update\classes\BaseDBUpdates






* Class name: BaseDBUpdates
* Namespace: components\update\classes
* This is an **abstract** class




## Class index

**Properties**
* [`private static mixed $component_package_data`](#property-$component_package_data)
* [`private static mixed $core_package_data`](#property-$core_package_data)
* [`private static mixed $queued_operations`](#property-$queued_operations)
* [`private static mixed $template_package_data`](#property-$template_package_data)
* [`private static mixed $theme_package_data`](#property-$theme_package_data)
* [`protected mixed $component`](#property-$component)
* [`protected mixed $is_core`](#property-$is_core)
* [`protected mixed $template`](#property-$template)
* [`protected mixed $theme`](#property-$theme)
* [`protected mixed $updates`](#property-$updates)
* [`private mixed $package`](#property-$package)

**Methods**
* [`public static mixed base_dir($type, $name)`](#method-base_dir)
* [`public static mixed clear_global_cache()`](#method-clear_global_cache)
* [`public static mixed init_statics()`](#method-init_statics)
* [`public static mixed package_data($type, $name)`](#method-package_data)
* [`public static mixed process_queue()`](#method-process_queue)
* [`public mixed __construct()`](#method-__construct)
* [`public mixed clear_cache()`](#method-clear_cache)
* [`public mixed current_version()`](#method-current_version)
* [`public mixed install($dummydata, $forced, $update_to_latest)`](#method-install)
* [`public mixed latest_version()`](#method-latest_version)
* [`public mixed uninstall($forced)`](#method-uninstall)
* [`public mixed update($forced, $maybe_install)`](#method-update)
* [`protected mixed get_base_dir()`](#method-get_base_dir)
* [`protected mixed get_package_data()`](#method-get_package_data)
* [`protected mixed next_version($version)`](#method-next_version)
* [`protected mixed package()`](#method-package)
* [`protected mixed queue($data, \Closure $operation)`](#method-queue)
* [`private mixed version_bump($version)`](#method-version_bump)







Properties
----------


### Property `$component_package_data`

```
private mixed $component_package_data
```





* Visibility: **private**
* This property is **static**.


### Property `$core_package_data`

```
private mixed $core_package_data
```





* Visibility: **private**
* This property is **static**.


### Property `$queued_operations`

```
private mixed $queued_operations
```





* Visibility: **private**
* This property is **static**.


### Property `$template_package_data`

```
private mixed $template_package_data
```





* Visibility: **private**
* This property is **static**.


### Property `$theme_package_data`

```
private mixed $theme_package_data
```





* Visibility: **private**
* This property is **static**.


### Property `$component`

```
protected mixed $component
```





* Visibility: **protected**


### Property `$is_core`

```
protected mixed $is_core
```





* Visibility: **protected**


### Property `$template`

```
protected mixed $template
```





* Visibility: **protected**


### Property `$theme`

```
protected mixed $theme
```





* Visibility: **protected**


### Property `$updates`

```
protected mixed $updates
```





* Visibility: **protected**


### Property `$package`

```
private mixed $package
```





* Visibility: **private**


Methods
-------


### Method `base_dir`

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**



### Method `clear_global_cache`

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.



### Method `init_statics`

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.



### Method `package_data`

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**



### Method `process_queue`

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.



### Method `__construct`

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**



### Method `clear_cache`

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**



### Method `current_version`

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**



### Method `install`

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**



### Method `latest_version`

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**



### Method `uninstall`

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**



### Method `update`

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**



### Method `get_base_dir`

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**



### Method `get_package_data`

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**



### Method `next_version`

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **protected**

#### Arguments

* $version **mixed**



### Method `package`

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**



### Method `queue`

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $operation **Closure**



### Method `version_bump`

```
mixed components\update\classes\BaseDBUpdates::version_bump($version)
```





* Visibility: **private**

#### Arguments

* $version **mixed**


