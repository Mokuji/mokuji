# components\menu\DBUpdates






* Class name: DBUpdates
* Namespace: components\menu
* Parent class: [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)




## Class index

**Properties**
* [`protected mixed $component`](#property-$component)
* [`protected mixed $updates`](#property-$updates)

**Methods**
* [`public mixed install_1_1($dummydata, $forced)`](#method-install_1_1)
* [`public mixed update_to_1_2($current_version, $forced)`](#method-update_to_1_2)
* [`public mixed update_to_1_3($current_version, $forced)`](#method-update_to_1_3)


## Inheritance index

**Properties**
* `protected mixed $is_core`
* `protected mixed $template`
* `protected mixed $theme`

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


### Property `$component`

```
protected mixed $component = 'menu'
```





* Visibility: **protected**


### Property `$is_core`

```
protected mixed $is_core
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)


### Property `$template`

```
protected mixed $template
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)


### Property `$theme`

```
protected mixed $theme
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)


### Property `$updates`

```
protected mixed $updates = array('1.1' => '1.2', '1.2' => '1.3')
```





* Visibility: **protected**


Methods
-------


### Method `base_dir`

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $type **mixed**
* $name **mixed**



### Method `clear_global_cache`

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `init_statics`

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `package_data`

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $type **mixed**
* $name **mixed**



### Method `process_queue`

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `__construct`

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `clear_cache`

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `current_version`

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `install`

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**



### Method `install_1_1`

```
mixed components\menu\DBUpdates::install_1_1($dummydata, $forced)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**



### Method `latest_version`

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `uninstall`

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $forced **mixed**



### Method `update`

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**



### Method `update_to_1_2`

```
mixed components\menu\DBUpdates::update_to_1_2($current_version, $forced)
```





* Visibility: **public**

#### Arguments

* $current_version **mixed**
* $forced **mixed**



### Method `update_to_1_3`

```
mixed components\menu\DBUpdates::update_to_1_3($current_version, $forced)
```





* Visibility: **public**

#### Arguments

* $current_version **mixed**
* $forced **mixed**



### Method `get_base_dir`

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `get_package_data`

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `next_version`

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $version **mixed**



### Method `package`

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)



### Method `queue`

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $data **mixed**
* $operation **Closure**



### Method `version_bump`

```
mixed components\update\classes\BaseDBUpdates::version_bump($version)
```





* Visibility: **private**
* This method is defined by [components\update\classes\BaseDBUpdates](/apidocs/components/update/classes/BaseDBUpdates.md)

#### Arguments

* $version **mixed**


