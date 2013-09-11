# components\update\classes\BaseDBUpdates
[API index](../../../API-index.md)






* Class name: BaseDBUpdates
* Namespace: components\update\classes
* This is an **abstract** class




## Class index

**Properties**
* [`private static mixed $component_package_data`](#property-component_package_data)
* [`private static mixed $core_package_data`](#property-core_package_data)
* [`private static mixed $queued_operations`](#property-queued_operations)
* [`private static mixed $template_package_data`](#property-template_package_data)
* [`private static mixed $theme_package_data`](#property-theme_package_data)
* [`protected mixed $component`](#property-component)
* [`protected mixed $is_core`](#property-is_core)
* [`protected mixed $name`](#property-name)
* [`protected mixed $template`](#property-template)
* [`protected mixed $theme`](#property-theme)
* [`protected mixed $type`](#property-type)
* [`protected mixed $updates`](#property-updates)
* [`private mixed $package`](#property-package)

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
* [`public mixed next_version($version)`](#method-next_version)
* [`public mixed uninstall($forced)`](#method-uninstall)
* [`public mixed update($forced, $maybe_install)`](#method-update)
* [`protected mixed get_base_dir()`](#method-get_base_dir)
* [`protected mixed get_package_data()`](#method-get_package_data)
* [`protected mixed package()`](#method-package)
* [`protected mixed queue($data, \Closure $operation)`](#method-queue)
* [`private mixed version_bump($version, $is_install)`](#method-version_bump)







# Properties


## Property `$component_package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $component_package_data
```





* Visibility: **private**
* This property is **static**.


## Property `$core_package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $core_package_data
```





* Visibility: **private**
* This property is **static**.


## Property `$queued_operations`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $queued_operations
```





* Visibility: **private**
* This property is **static**.


## Property `$template_package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $template_package_data
```





* Visibility: **private**
* This property is **static**.


## Property `$theme_package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $theme_package_data
```





* Visibility: **private**
* This property is **static**.


## Property `$component`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $component
```





* Visibility: **protected**


## Property `$is_core`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $is_core
```





* Visibility: **protected**


## Property `$name`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $name
```





* Visibility: **protected**


## Property `$template`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $template
```





* Visibility: **protected**


## Property `$theme`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $theme
```





* Visibility: **protected**


## Property `$type`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $type
```





* Visibility: **protected**


## Property `$updates`
In class: [components\update\classes\BaseDBUpdates](#top)

```
protected mixed $updates
```





* Visibility: **protected**


## Property `$package`
In class: [components\update\classes\BaseDBUpdates](#top)

```
private mixed $package
```





* Visibility: **private**


# Methods


## Method `base_dir`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `clear_global_cache`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.






## Method `init_statics`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.






## Method `package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `process_queue`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.






## Method `__construct`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**






## Method `clear_cache`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**






## Method `current_version`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**






## Method `install`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**






## Method `latest_version`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**






## Method `next_version`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **public**

#### Arguments

* $version **mixed**






## Method `uninstall`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**






## Method `update`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**






## Method `get_base_dir`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**






## Method `get_package_data`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**






## Method `package`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**






## Method `queue`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $operation **Closure**






## Method `version_bump`
In class: [components\update\classes\BaseDBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::version_bump($version, $is_install)
```





* Visibility: **private**

#### Arguments

* $version **mixed**
* $is_install **mixed**





