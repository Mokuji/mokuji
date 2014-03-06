# components\cms\Helpers
[API index](../../API-index.md)






* Class name: Helpers
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed check_page_authorisation($pid)`](#method-check_page_authorisation)
* [`public mixed ensure_pagetypes($component, $views)`](#method-ensure_pagetypes)
* [`public mixed get_page_info($pid)`](#method-get_page_info)
* [`public mixed get_page_options($pid)`](#method-get_page_options)
* [`public mixed get_page_permissions($pid)`](#method-get_page_permissions)
* [`public mixed get_settings($key)`](#method-get_settings)
* [`public mixed is_website_editable()`](#method-is_website_editable)
* [`public mixed page_authorisation($pid)`](#method-page_authorisation)
* [`public mixed set_page_permissions($pid, $permissions)`](#method-set_page_permissions)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)

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
In class: [components\cms\Helpers](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\cms\Helpers](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\cms\Helpers](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\cms\Helpers](#top)

```
protected mixed $permissions = array('page_authorisation' => 0, 'check_page_authorisation' => 0, 'get_page_info' => 0, 'get_page_options' => 0, 'is_website_editable' => 0, 'get_page_permissions' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `check_page_authorisation`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::check_page_authorisation($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**






## Method `create_filter`
In class: [components\cms\Helpers](#top)

```
self dependencies\BaseComponent::create_filter(string $key, mixed $value)
```

Creates a component specific filter in the session.



* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $key **string** - The key under which the value will be available.
* $value **mixed** - The value for the filter.


#### Return value

**self** - Chaining enabled.







## Method `ensure_pagetypes`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::ensure_pagetypes($component, $views)
```





* Visibility: **public**

#### Arguments

* $component **mixed**
* $views **mixed**






## Method `filters`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_page_info`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::get_page_info($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**






## Method `get_page_options`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::get_page_options($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**






## Method `get_page_permissions`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::get_page_permissions($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**






## Method `get_settings`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::get_settings($key)
```

$options[]



* Visibility: **public**

#### Arguments

* $key **mixed**






## Method `helper`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `is_website_editable`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::is_website_editable()
```





* Visibility: **public**






## Method `model`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `page_authorisation`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::page_authorisation($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**






## Method `section`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `set_page_permissions`
In class: [components\cms\Helpers](#top)

```
mixed components\cms\Helpers::set_page_permissions($pid, $permissions)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**
* $permissions **mixed**






## Method `table`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\cms\Helpers](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**





