# components\menu\Actions
[API index](../../API-index.md)






* Class name: Actions
* Namespace: components\menu
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed delete_menu($data)`](#method-delete_menu)
* [`protected mixed menu_item_delete($data)`](#method-menu_item_delete)
* [`protected mixed new_menu($data)`](#method-new_menu)


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
In class: [components\menu\Actions](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\menu\Actions](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\menu\Actions](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\menu\Actions](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\menu\Actions](#top)

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







## Method `filters`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\menu\Actions](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `delete_menu`
In class: [components\menu\Actions](#top)

```
mixed components\menu\Actions::delete_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `menu_item_delete`
In class: [components\menu\Actions](#top)

```
mixed components\menu\Actions::menu_item_delete($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `new_menu`
In class: [components\menu\Actions](#top)

```
mixed components\menu\Actions::new_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**





