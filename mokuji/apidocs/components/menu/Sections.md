# components\menu\Sections
[API index](../../API-index.md)






* Class name: Sections
* Namespace: components\menu
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed menu_item_list($options)`](#method-menu_item_list)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed _call($controller, array $args)`](#method-_call)
* [`public mixed call($controller, $data)`](#method-call)
* [`public mixed filters()`](#method-filters)
* [`public mixed get_html($view, $options)`](#method-get_html)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\menu\Sections](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\menu\Sections](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\menu\Sections](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\menu\Sections](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_html`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**






## Method `helper`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\menu\Sections](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `menu_item_list`
In class: [components\menu\Sections](#top)

```
mixed components\menu\Sections::menu_item_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**





