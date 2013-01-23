# components\account\DBUpdates






* Class name: DBUpdates
* Namespace: components\account
* Parent class: [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)




## Class index

**Properties**
* `protected mixed $component`
* `protected mixed $updates`

**Methods**
* `public mixed install_1_2($dummydata, $forced)`
* `public mixed update_to_1_3($current_version, $forced)`


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


### $component

```
protected mixed $component = 'account'
```





* Visibility: **protected**


### $is_core

```
protected mixed $is_core
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)


### $template

```
protected mixed $template
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)


### $theme

```
protected mixed $theme
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)


### $updates

```
protected mixed $updates = array('1.2' => '1.3')
```





* Visibility: **protected**


Methods
-------


### base_dir

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $type **mixed**
* $name **mixed**



### clear_global_cache

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### init_statics

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### package_data

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $type **mixed**
* $name **mixed**



### process_queue

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### __construct

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### clear_cache

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### current_version

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### install

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**



### install_1_2

```
mixed components\account\DBUpdates::install_1_2($dummydata, $forced)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**



### latest_version

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### uninstall

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $forced **mixed**



### update

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**



### update_to_1_3

```
mixed components\account\DBUpdates::update_to_1_3($current_version, $forced)
```





* Visibility: **public**

#### Arguments

* $current_version **mixed**
* $forced **mixed**



### get_base_dir

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### get_package_data

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### next_version

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $version **mixed**



### package

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)



### queue

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $data **mixed**
* $operation **Closure**



### version_bump

```
mixed components\update\classes\BaseDBUpdates::version_bump($version)
```





* Visibility: **private**
* This method is defined by [components\update\classes\BaseDBUpdates](components-update-classes-BaseDBUpdates)

#### Arguments

* $version **mixed**


