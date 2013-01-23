# components\update\classes\BaseDBUpdates






* Class name: BaseDBUpdates
* Namespace: components\update\classes
* This is an **abstract** class




## Class index

**Properties**
* `private static mixed $component_package_data`
* `private static mixed $core_package_data`
* `private static mixed $queued_operations`
* `private static mixed $template_package_data`
* `private static mixed $theme_package_data`
* `protected mixed $component`
* `protected mixed $is_core`
* `protected mixed $template`
* `protected mixed $theme`
* `protected mixed $updates`
* `private mixed $package`

**Methods**
* `public static mixed base_dir($type, $name)`
* `public static mixed clear_global_cache()`
* `public static mixed init_statics()`
* `public static mixed package_data($type, $name)`
* `public static mixed process_queue()`
* `public mixed __construct()`
* `public mixed clear_cache()`
* `public mixed current_version()`
* `public mixed install($dummydata, $forced, $update_to_latest)`
* `public mixed latest_version()`
* `public mixed uninstall($forced)`
* `public mixed update($forced, $maybe_install)`
* `protected mixed get_base_dir()`
* `protected mixed get_package_data()`
* `protected mixed next_version($version)`
* `protected mixed package()`
* `protected mixed queue($data, \Closure $operation)`
* `private mixed version_bump($version)`







Properties
----------


### $component_package_data

```
private mixed $component_package_data
```





* Visibility: **private**
* This property is **static**.


### $core_package_data

```
private mixed $core_package_data
```





* Visibility: **private**
* This property is **static**.


### $queued_operations

```
private mixed $queued_operations
```





* Visibility: **private**
* This property is **static**.


### $template_package_data

```
private mixed $template_package_data
```





* Visibility: **private**
* This property is **static**.


### $theme_package_data

```
private mixed $theme_package_data
```





* Visibility: **private**
* This property is **static**.


### $component

```
protected mixed $component
```





* Visibility: **protected**


### $is_core

```
protected mixed $is_core
```





* Visibility: **protected**


### $template

```
protected mixed $template
```





* Visibility: **protected**


### $theme

```
protected mixed $theme
```





* Visibility: **protected**


### $updates

```
protected mixed $updates
```





* Visibility: **protected**


### $package

```
private mixed $package
```





* Visibility: **private**


Methods
-------


### base_dir

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**



### clear_global_cache

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.



### init_statics

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.



### package_data

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $type **mixed**
* $name **mixed**



### process_queue

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.



### __construct

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**



### clear_cache

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**



### current_version

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**



### install

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**



### latest_version

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**



### uninstall

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**



### update

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**



### get_base_dir

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**



### get_package_data

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**



### next_version

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **protected**

#### Arguments

* $version **mixed**



### package

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**



### queue

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $operation **Closure**



### version_bump

```
mixed components\update\classes\BaseDBUpdates::version_bump($version)
```





* Visibility: **private**

#### Arguments

* $version **mixed**


