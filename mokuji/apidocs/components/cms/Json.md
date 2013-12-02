# components\cms\Json
[API index](../../API-index.md)






* Class name: Json
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed delete_page($options, $params)`](#method-delete_page)
* [`protected mixed get_config_app($data, $params)`](#method-get_config_app)
* [`protected mixed get_configbar_items($data, $params)`](#method-get_configbar_items)
* [`protected mixed get_detach_page($data, $params)`](#method-get_detach_page)
* [`protected mixed get_keep_alive($data, $params)`](#method-get_keep_alive)
* [`protected mixed get_link_page($data, $params)`](#method-get_link_page)
* [`protected mixed get_menu_item_info($options, $params)`](#method-get_menu_item_info)
* [`protected mixed get_menus($data)`](#method-get_menus)
* [`protected mixed get_new_page($data, $params)`](#method-get_new_page)
* [`protected mixed get_page_info($options, $params)`](#method-get_page_info)
* [`protected mixed update_active_site($data, $params)`](#method-update_active_site)
* [`protected mixed update_page($data, $params)`](#method-update_page)
* [`protected mixed update_page_findability($data, $params)`](#method-update_page_findability)
* [`protected mixed update_settings($data, $params)`](#method-update_settings)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)

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
In class: [components\cms\Json](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\cms\Json](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\cms\Json](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\cms\Json](#top)

```
protected mixed $permissions = array('get_keep_alive' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\cms\Json](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `delete_page`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::delete_page($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**






## Method `get_config_app`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_config_app($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_configbar_items`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_configbar_items($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_detach_page`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_detach_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_keep_alive`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_keep_alive($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_link_page`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_link_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_menu_item_info`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_menu_item_info($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**






## Method `get_menus`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_menus($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `get_new_page`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_new_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `get_page_info`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::get_page_info($options, $params)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**
* $params **mixed**






## Method `update_active_site`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::update_active_site($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `update_page`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::update_page($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `update_page_findability`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::update_page_findability($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `update_settings`
In class: [components\cms\Json](#top)

```
mixed components\cms\Json::update_settings($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**





