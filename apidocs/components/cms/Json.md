# components\cms\Json
[API index](../../API-index.md)






* Class name: Json
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index


**Methods**
* [`protected mixed delete_page($options, $params)`](#method-delete_page)
* [`protected mixed get_config_app($data, $params)`](#method-get_config_app)
* [`protected mixed get_configbar_items($data, $params)`](#method-get_configbar_items)
* [`protected mixed get_detach_page($data, $params)`](#method-get_detach_page)
* [`protected mixed get_link_page($data, $params)`](#method-get_link_page)
* [`protected mixed get_menu_item_info($options, $params)`](#method-get_menu_item_info)
* [`protected mixed get_new_page($data, $params)`](#method-get_new_page)
* [`protected mixed get_page_info($options, $params)`](#method-get_page_info)
* [`protected mixed update_page($data, $params)`](#method-update_page)
* [`protected mixed update_page_findability($data, $params)`](#method-update_page_findability)
* [`protected mixed update_settings($data, $params)`](#method-update_settings)


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

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



## Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



## Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



## Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



## Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



## Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



## Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `delete_page`

```
mixed components\cms\Json::delete_page($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**



## Method `get_config_app`

```
mixed components\cms\Json::get_config_app($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `get_configbar_items`

```
mixed components\cms\Json::get_configbar_items($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `get_detach_page`

```
mixed components\cms\Json::get_detach_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `get_link_page`

```
mixed components\cms\Json::get_link_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `get_menu_item_info`

```
mixed components\cms\Json::get_menu_item_info($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**



## Method `get_new_page`

```
mixed components\cms\Json::get_new_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `get_page_info`

```
mixed components\cms\Json::get_page_info($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**



## Method `update_page`

```
mixed components\cms\Json::update_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `update_page_findability`

```
mixed components\cms\Json::update_page_findability($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**



## Method `update_settings`

```
mixed components\cms\Json::update_settings($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**


