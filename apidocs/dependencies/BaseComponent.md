# dependencies\BaseComponent
[API index](../API-index.md)






* Class name: BaseComponent
* Namespace: dependencies
* This is an **abstract** class




## Class index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed _call($controller, array $args)`](#method-_call)
* [`public mixed call($controller, $data)`](#method-call)
* [`public mixed filters()`](#method-filters)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)







# Properties


## Property `$reserved`

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.


## Property `$component`

```
protected mixed $component
```





* Visibility: **protected**


## Property `$default_permission`

```
protected mixed $default_permission
```





* Visibility: **protected**


## Property `$permissions`

```
protected mixed $permissions = array()
```





* Visibility: **protected**


# Methods


## Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**



## Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**
* $args **array**



## Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**
* $data **mixed**



## Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**



## Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**



## Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**



## Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**

#### Arguments

* $section **mixed**
* $options **mixed**



## Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**
* $id **mixed**



## Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**

#### Arguments

* $module_name **mixed**
* $options **mixed**


