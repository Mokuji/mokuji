# components\timeline\Json
[API index](../../API-index.md)






* Class name: Json
* Namespace: components\timeline
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index


**Methods**
* [`public mixed delete_entry($data, $params)`](#method-delete_entry)
* [`protected mixed create_entry($data, $params)`](#method-create_entry)
* [`protected mixed get_entries($data, $params)`](#method-get_entries)
* [`protected mixed get_entry($data, $params)`](#method-get_entry)
* [`protected mixed get_page($data, $params)`](#method-get_page)
* [`protected mixed update_entry($data, $params)`](#method-update_entry)
* [`protected mixed update_page($data, $params)`](#method-update_page)


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
* [`public mixed filters()`](#method-filters)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\timeline\Json](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\timeline\Json](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\timeline\Json](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\timeline\Json](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `delete_entry`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::delete_entry($data, $params)
```

Moves an entry to 'the trash'.

By removing it from all timelines.
This makes sure the entry is still preserved and collected in the unlinked items.

* Visibility: **public**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `filters`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\timeline\Json](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `create_entry`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::create_entry($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_entries`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::get_entries($data, $params)
```

Get the entries for a specified timeline.



* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_entry`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::get_entry($data, $params)
```

Get one entry.



* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_page`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::get_page($data, $params)
```

Get a page's timeline filters, or resort to the defaults.



* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `update_entry`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::update_entry($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `update_page`
In class: [components\timeline\Json](#top)

```
mixed components\timeline\Json::update_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**





