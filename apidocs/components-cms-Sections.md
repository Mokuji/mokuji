# components\cms\Sections






* Class name: Sections
* Namespace: components\cms
* Parent class: [dependencies\BaseViews](dependencies-BaseViews)




## Class index

**Properties**

**Methods**
* `protected mixed admin_toolbar()`
* `protected mixed app($view)`
* `protected mixed config_app()`
* `protected mixed configbar()`
* `protected mixed context_menus()`
* `protected mixed edit_menu_item($data)`
* `protected mixed edit_page($options)`
* `protected mixed edit_site($options)`
* `protected mixed ip_edit()`
* `protected mixed ip_list()`
* `protected mixed link_menu_item($options)`
* `protected mixed login_form()`
* `protected mixed menu_app()`
* `protected mixed menu_items($options)`
* `protected mixed menu_toolbar($options)`
* `protected mixed menus($options)`
* `protected mixed module_app()`
* `protected mixed new_page($options)`
* `protected mixed page_app()`
* `protected mixed page_list($options)`
* `protected mixed setting_edit($data)`
* `protected mixed setting_edit_simple()`
* `protected mixed setting_list()`
* `protected mixed site_list($options)`
* `protected mixed template_list()`
* `protected mixed theme_list()`


## Inheritance index

**Properties**
* `protected static mixed $reserved`
* `protected mixed $component`
* `protected mixed $default_permission`
* `protected mixed $permissions`

**Methods**
* `public mixed __construct()`
* `public mixed _call($controller, array $args)`
* `public mixed call($controller, $data)`
* `public mixed filters()`
* `public mixed get_html($view, $options)`
* `public mixed helper($controller)`
* `public mixed model($model_name)`
* `public mixed module($module_name, $options)`
* `public mixed section($section, $options)`
* `public mixed table($model_name, $id)`
* `public mixed view($module_name, $options)`



Properties
----------


### $reserved

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $component

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $default_permission

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


### $permissions

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](dependencies-BaseComponent)


Methods
-------


### __construct

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)



### _call

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**
* $args **array**



### call

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**
* $data **mixed**



### filters

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)



### get_html

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](dependencies-BaseViews)

#### Arguments

* $view **mixed**
* $options **mixed**



### helper

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**



### model

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $model_name **mixed**



### module

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### section

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $section **mixed**
* $options **mixed**



### table

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### view

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### admin_toolbar

```
mixed components\cms\Sections::admin_toolbar()
```





* Visibility: **protected**



### app

```
mixed components\cms\Sections::app($view)
```





* Visibility: **protected**

#### Arguments

* $view **mixed**



### config_app

```
mixed components\cms\Sections::config_app()
```





* Visibility: **protected**



### configbar

```
mixed components\cms\Sections::configbar()
```





* Visibility: **protected**



### context_menus

```
mixed components\cms\Sections::context_menus()
```





* Visibility: **protected**



### edit_menu_item

```
mixed components\cms\Sections::edit_menu_item($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### edit_page

```
mixed components\cms\Sections::edit_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### edit_site

```
mixed components\cms\Sections::edit_site($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### ip_edit

```
mixed components\cms\Sections::ip_edit()
```





* Visibility: **protected**



### ip_list

```
mixed components\cms\Sections::ip_list()
```





* Visibility: **protected**



### link_menu_item

```
mixed components\cms\Sections::link_menu_item($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### login_form

```
mixed components\cms\Sections::login_form()
```





* Visibility: **protected**



### menu_app

```
mixed components\cms\Sections::menu_app()
```





* Visibility: **protected**



### menu_items

```
mixed components\cms\Sections::menu_items($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### menu_toolbar

```
mixed components\cms\Sections::menu_toolbar($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### menus

```
mixed components\cms\Sections::menus($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### module_app

```
mixed components\cms\Sections::module_app()
```





* Visibility: **protected**



### new_page

```
mixed components\cms\Sections::new_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### page_app

```
mixed components\cms\Sections::page_app()
```





* Visibility: **protected**



### page_list

```
mixed components\cms\Sections::page_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### setting_edit

```
mixed components\cms\Sections::setting_edit($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### setting_edit_simple

```
mixed components\cms\Sections::setting_edit_simple()
```





* Visibility: **protected**



### setting_list

```
mixed components\cms\Sections::setting_list()
```





* Visibility: **protected**



### site_list

```
mixed components\cms\Sections::site_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### template_list

```
mixed components\cms\Sections::template_list()
```





* Visibility: **protected**



### theme_list

```
mixed components\cms\Sections::theme_list()
```





* Visibility: **protected**


