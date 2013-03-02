# components\cms\Actions
[API index](../../API-index.md)






* Class name: Actions
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed delete_page($data)`](#method-delete_page)
* [`protected mixed detach_page($data)`](#method-detach_page)
* [`protected mixed edit_page($data)`](#method-edit_page)
* [`protected mixed insert_sites($data)`](#method-insert_sites)
* [`protected mixed language($data)`](#method-language)
* [`protected mixed link_page($data)`](#method-link_page)
* [`protected mixed login($data)`](#method-login)
* [`protected mixed logout($data)`](#method-logout)
* [`protected mixed new_page($data)`](#method-new_page)
* [`protected mixed pause_redirects($data)`](#method-pause_redirects)
* [`protected mixed play_redirects($data)`](#method-play_redirects)
* [`protected mixed register($data)`](#method-register)
* [`protected mixed save_menu_item($data)`](#method-save_menu_item)
* [`protected mixed save_menu_link($data)`](#method-save_menu_link)
* [`protected mixed save_settings_simple($data)`](#method-save_settings_simple)
* [`protected mixed select_menu($data)`](#method-select_menu)
* [`protected mixed send_feedback($data)`](#method-send_feedback)
* [`protected mixed update_cms_config($data)`](#method-update_cms_config)
* [`protected mixed update_ip_addresses($data)`](#method-update_ip_addresses)
* [`protected mixed update_sites($data)`](#method-update_sites)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)

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
In class: [components\cms\Actions](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\cms\Actions](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\cms\Actions](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\cms\Actions](#top)

```
protected mixed $permissions = array('select_menu' => 2, 'new_page' => 2, 'edit_page' => 2, 'logout' => 1)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\cms\Actions](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `delete_page`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::delete_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `detach_page`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::detach_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `edit_page`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::edit_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `insert_sites`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::insert_sites($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `language`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::language($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `link_page`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::link_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `login`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::login($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `logout`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::logout($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `new_page`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::new_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `pause_redirects`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::pause_redirects($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `play_redirects`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::play_redirects($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `register`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::register($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `save_menu_item`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::save_menu_item($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `save_menu_link`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::save_menu_link($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `save_settings_simple`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::save_settings_simple($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `select_menu`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::select_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `send_feedback`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::send_feedback($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `update_cms_config`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::update_cms_config($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `update_ip_addresses`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::update_ip_addresses($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `update_sites`
In class: [components\cms\Actions](#top)

```
mixed components\cms\Actions::update_sites($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**





