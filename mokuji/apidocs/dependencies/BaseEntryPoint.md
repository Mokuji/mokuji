# dependencies\BaseEntryPoint
[API index](../API-index.md)






* Class name: BaseEntryPoint
* Namespace: dependencies
* This is an **abstract** class
* Parent class: [dependencies\BaseComponent](../dependencies/BaseComponent.md)




## Class index

**Properties**

**Methods**
* [`public string template()`](#method-template)


## Inheritance index

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
In class: [dependencies\BaseEntryPoint](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)


## Property `$component`
In class: [dependencies\BaseEntryPoint](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [dependencies\BaseEntryPoint](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [dependencies\BaseEntryPoint](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)






## Method `_call`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [dependencies\BaseEntryPoint](#top)

```
self dependencies\BaseComponent::create_filter(string $key, mixed $value)
```

Creates a component specific filter in the session.



* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $key **string** - The key under which the value will be available.
* $value **mixed** - The value for the filter.


#### Return value

**self** - Chaining enabled.







## Method `filters`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)






## Method `helper`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `template`
In class: [dependencies\BaseEntryPoint](#top)

```
string dependencies\BaseEntryPoint::template()
```

Load a template.

Loads a template of the given name, with a theme of the given name with given content
for the &lt;head&gt; tag and given content for the &lt;body&gt; tag. All parameters are optional,
and can be left out.

* Visibility: **public**


#### Return value

**string** - The resulting HTML.







## Method `view`
In class: [dependencies\BaseEntryPoint](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**





