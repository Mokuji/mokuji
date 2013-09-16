# components\account\DBUpdates
[API index](../../API-index.md)






* Class name: DBUpdates
* Namespace: components\account
* Parent class: [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)




## Class index

**Properties**
* [`protected mixed $component`](#property-component)
* [`protected mixed $updates`](#property-updates)

**Methods**
* [`public mixed install_1_2($dummydata, $forced)`](#method-install_1_2)
* [`public mixed install_1_3($dummydata, $forced)`](#method-install_1_3)
* [`public mixed update_to_1_3($current_version, $forced)`](#method-update_to_1_3)
* [`public mixed update_to_1_4($current_version, $forced)`](#method-update_to_1_4)


## Inheritance index

**Properties**
* [`protected mixed $is_core`](#property-is_core)
* [`protected mixed $name`](#property-name)
* [`protected mixed $template`](#property-template)
* [`protected mixed $theme`](#property-theme)
* [`protected mixed $type`](#property-type)

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


## Property `$component`
In class: [components\account\DBUpdates](#top)

```
protected mixed $component = 'account'
```





* Visibility: **protected**


## Property `$is_core`
In class: [components\account\DBUpdates](#top)

```
protected mixed $is_core
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)


## Property `$name`
In class: [components\account\DBUpdates](#top)

```
protected mixed $name
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)


## Property `$template`
In class: [components\account\DBUpdates](#top)

```
protected mixed $template
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)


## Property `$theme`
In class: [components\account\DBUpdates](#top)

```
protected mixed $theme
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)


## Property `$type`
In class: [components\account\DBUpdates](#top)

```
protected mixed $type
```





* Visibility: **protected**
* This property is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)


## Property `$updates`
In class: [components\account\DBUpdates](#top)

```
protected mixed $updates = array('1.2' => '1.3', '1.3' => '1.4', '1.4' => '0.2.0-beta', '0.2.0-beta' => '0.3.0-beta', '0.2.1-beta' => '0.3.0-beta')
```





* Visibility: **protected**


# Methods


## Method `base_dir`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::base_dir($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `clear_global_cache`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::clear_global_cache()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `init_statics`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::init_statics()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `package_data`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::package_data($type, $name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $type **mixed**
* $name **mixed**






## Method `process_queue`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::process_queue()
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `__construct`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::__construct()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `clear_cache`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::clear_cache()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `current_version`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::current_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `install`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::install($dummydata, $forced, $update_to_latest)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $dummydata **mixed**
* $forced **mixed**
* $update_to_latest **mixed**






## Method `install_1_2`
In class: [components\account\DBUpdates](#top)

```
mixed components\account\DBUpdates::install_1_2($dummydata, $forced)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**






## Method `install_1_3`
In class: [components\account\DBUpdates](#top)

```
mixed components\account\DBUpdates::install_1_3($dummydata, $forced)
```





* Visibility: **public**

#### Arguments

* $dummydata **mixed**
* $forced **mixed**






## Method `latest_version`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::latest_version()
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `next_version`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::next_version($version)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $version **mixed**






## Method `uninstall`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::uninstall($forced)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $forced **mixed**






## Method `update`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::update($forced, $maybe_install)
```





* Visibility: **public**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $forced **mixed**
* $maybe_install **mixed**






## Method `update_to_1_3`
In class: [components\account\DBUpdates](#top)

```
mixed components\account\DBUpdates::update_to_1_3($current_version, $forced)
```





* Visibility: **public**

#### Arguments

* $current_version **mixed**
* $forced **mixed**






## Method `update_to_1_4`
In class: [components\account\DBUpdates](#top)

```
mixed components\account\DBUpdates::update_to_1_4($current_version, $forced)
```





* Visibility: **public**

#### Arguments

* $current_version **mixed**
* $forced **mixed**






## Method `get_base_dir`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::get_base_dir()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `get_package_data`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::get_package_data()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `package`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::package()
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)






## Method `queue`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::queue($data, \Closure $operation)
```





* Visibility: **protected**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $data **mixed**
* $operation **Closure**






## Method `version_bump`
In class: [components\account\DBUpdates](#top)

```
mixed components\update\classes\BaseDBUpdates::version_bump($version, $is_install)
```





* Visibility: **private**
* This method is defined by [components\update\classes\BaseDBUpdates](../../components/update/classes/BaseDBUpdates.md)

#### Arguments

* $version **mixed**
* $is_install **mixed**





