# components\update\Json






* Class name: Json
* Namespace: components\update
* Parent class: [dependencies\BaseViews](dependencies-BaseViews)




## Class index

**Properties**

**Methods**
* `protected mixed create_admin_installation($data, $params)`
* `protected mixed create_db_installation($data, $params)`
* `protected mixed create_db_test($data, $params)`
* `protected mixed create_site_installation($data, $params)`
* `protected mixed get_update_count($options, $params)`


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
* `public mixed get_html($view, $options)`
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



### get_html

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](dependencies-BaseViews)

#### Arguments

* $view **mixed**
* $options **mixed**



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



### create_admin_installation

```
mixed components\update\Json::create_admin_installation($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



### create_db_installation

```
mixed components\update\Json::create_db_installation($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



### create_db_test

```
mixed components\update\Json::create_db_test($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



### create_site_installation

```
mixed components\update\Json::create_site_installation($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



### get_update_count

```
mixed components\update\Json::get_update_count($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**


