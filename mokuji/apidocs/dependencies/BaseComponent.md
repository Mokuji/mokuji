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
* [`public self create_filter(string $key, mixed $value)`](#method-create_filter)
* [`public mixed filters()`](#method-filters)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)







# Properties


## Property `$reserved`
In class: [dependencies\BaseComponent](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.


## Property `$component`
In class: [dependencies\BaseComponent](#top)

```
protected mixed $component
```





* Visibility: **protected**


## Property `$default_permission`
In class: [dependencies\BaseComponent](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [dependencies\BaseComponent](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**






## Method `_call`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [dependencies\BaseComponent](#top)

```
self dependencies\BaseComponent::create_filter(string $key, mixed $value)
```

Creates a component specific filter in the session.



* Visibility: **public**

#### Arguments

* $key **string** - The key under which the value will be available.
* $value **mixed** - The value for the filter.


#### Return value

**self** - Chaining enabled.







## Method `filters`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**






## Method `helper`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**

#### Arguments

* $controller **mixed**






## Method `model`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [dependencies\BaseComponent](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**

#### Arguments

* $module_name **mixed**
* $options **mixed**





