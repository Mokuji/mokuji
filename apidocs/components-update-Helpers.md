# components\update\Helpers






* Class name: Helpers
* Namespace: components\update
* Parent class: [dependencies\BaseComponent](dependencies-BaseComponent)




## Class index

**Properties**

**Methods**
* `protected mixed check_updates($options)`
* `private mixed check_folder($folder, $namespace, $silent, $force)`
* `private mixed sync_manual_package($package, $folder, $namespace, $silent, $force)`


## Inheritance index

**Properties**
* `protected static mixed $reserved`
* `protected mixed $component`
* `protected mixed $default_permission`
* `protected mixed $permissions`

**Methods**
* `public mixed __construct()`
* `public mixed _call($controller, array $args)`
* `public mixed call($controller, $data)`
* `public mixed filters()`
* `public mixed helper($controller)`
* `public mixed model($model_name)`
* `public mixed module($module_name, $options)`
* `public mixed section($section, $options)`
* `public mixed table($model_name, $id)`
* `public mixed view($module_name, $options)`



Properties
----------


### $reserved

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $component

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $default_permission

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $permissions

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


Methods
-------


### __construct

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)



### _call

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**
* $args **array**



### call

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**
* $data **mixed**



### filters

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)



### helper

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**



### model

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $model_name **mixed**



### module

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### section

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $section **mixed**
* $options **mixed**



### table

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### view

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### check_updates

```
mixed components\update\Helpers::check_updates($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### check_folder

```
mixed components\update\Helpers::check_folder($folder, $namespace, $silent, $force)
```





* Visibility: **private**

#### Arguments

* $folder **mixed**
* $namespace **mixed**
* $silent **mixed**
* $force **mixed**



### sync_manual_package

```
mixed components\update\Helpers::sync_manual_package($package, $folder, $namespace, $silent, $force)
```





* Visibility: **private**

#### Arguments

* $package **mixed**
* $folder **mixed**
* $namespace **mixed**
* $silent **mixed**
* $force **mixed**


