# components\menu\Json
[API index](../../API-index.md)






* Class name: Json
* Namespace: components\menu
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index


**Methods**
* [`public mixed delete_menu_item($data, $arguments)`](#method-delete_menu_item)
* [`protected mixed create_menu_item($data, $params)`](#method-create_menu_item)
* [`protected mixed delete_menu_item_image($data, $params)`](#method-delete_menu_item_image)
* [`protected mixed update_menu_item($data, $params)`](#method-update_menu_item)
* [`protected mixed update_menu_items($data, $arguments)`](#method-update_menu_items)


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
In class: [components\menu\Json](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\menu\Json](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\menu\Json](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\menu\Json](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `_call`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



## Method `call`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



## Method `delete_menu_item`
In class: [components\menu\Json](#top)

```
mixed components\menu\Json::delete_menu_item($data, $arguments)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $arguments **mixed**



## Method `filters`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `helper`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



## Method `model`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



## Method `module`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `section`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



## Method `table`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



## Method `view`
In class: [components\menu\Json](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `create_menu_item`
In class: [components\menu\Json](#top)

```
mixed components\menu\Json::create_menu_item($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `delete_menu_item_image`
In class: [components\menu\Json](#top)

```
mixed components\menu\Json::delete_menu_item_image($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `update_menu_item`
In class: [components\menu\Json](#top)

```
mixed components\menu\Json::update_menu_item($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `update_menu_items`
In class: [components\menu\Json](#top)

```
mixed components\menu\Json::update_menu_items($data, $arguments)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $arguments **mixed**


