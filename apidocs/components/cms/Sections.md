# components\cms\Sections






* Class name: Sections
* Namespace: components\cms
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index

**Properties**

**Methods**
* [`protected mixed admin_toolbar()`](#method-admin_toolbar)
* [`protected mixed app($view)`](#method-app)
* [`protected mixed config_app()`](#method-config_app)
* [`protected mixed configbar()`](#method-configbar)
* [`protected mixed context_menus()`](#method-context_menus)
* [`protected mixed edit_menu_item($data)`](#method-edit_menu_item)
* [`protected mixed edit_page($options)`](#method-edit_page)
* [`protected mixed edit_site($options)`](#method-edit_site)
* [`protected mixed ip_edit()`](#method-ip_edit)
* [`protected mixed ip_list()`](#method-ip_list)
* [`protected mixed link_menu_item($options)`](#method-link_menu_item)
* [`protected mixed login_form()`](#method-login_form)
* [`protected mixed menu_app()`](#method-menu_app)
* [`protected mixed menu_items($options)`](#method-menu_items)
* [`protected mixed menu_toolbar($options)`](#method-menu_toolbar)
* [`protected mixed menus($options)`](#method-menus)
* [`protected mixed module_app()`](#method-module_app)
* [`protected mixed new_page($options)`](#method-new_page)
* [`protected mixed page_app()`](#method-page_app)
* [`protected mixed page_list($options)`](#method-page_list)
* [`protected mixed setting_edit($data)`](#method-setting_edit)
* [`protected mixed setting_edit_simple()`](#method-setting_edit_simple)
* [`protected mixed setting_list()`](#method-setting_list)
* [`protected mixed site_list($options)`](#method-site_list)
* [`protected mixed template_list()`](#method-template_list)
* [`protected mixed theme_list()`](#method-theme_list)


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


### Property `$reserved`

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


### Property `$component`

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


### Property `$default_permission`

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


### Property `$permissions`

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


Methods
-------


### Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



### Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



### Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



### Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



### Method `get_html`

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**



### Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



### Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



### Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



### Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `admin_toolbar`

```
mixed components\cms\Sections::admin_toolbar()
```





* Visibility: **protected**



### Method `app`

```
mixed components\cms\Sections::app($view)
```





* Visibility: **protected**

#### Arguments

* $view **mixed**



### Method `config_app`

```
mixed components\cms\Sections::config_app()
```





* Visibility: **protected**



### Method `configbar`

```
mixed components\cms\Sections::configbar()
```





* Visibility: **protected**



### Method `context_menus`

```
mixed components\cms\Sections::context_menus()
```





* Visibility: **protected**



### Method `edit_menu_item`

```
mixed components\cms\Sections::edit_menu_item($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `edit_page`

```
mixed components\cms\Sections::edit_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `edit_site`

```
mixed components\cms\Sections::edit_site($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `ip_edit`

```
mixed components\cms\Sections::ip_edit()
```





* Visibility: **protected**



### Method `ip_list`

```
mixed components\cms\Sections::ip_list()
```





* Visibility: **protected**



### Method `link_menu_item`

```
mixed components\cms\Sections::link_menu_item($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `login_form`

```
mixed components\cms\Sections::login_form()
```





* Visibility: **protected**



### Method `menu_app`

```
mixed components\cms\Sections::menu_app()
```





* Visibility: **protected**



### Method `menu_items`

```
mixed components\cms\Sections::menu_items($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `menu_toolbar`

```
mixed components\cms\Sections::menu_toolbar($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `menus`

```
mixed components\cms\Sections::menus($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `module_app`

```
mixed components\cms\Sections::module_app()
```





* Visibility: **protected**



### Method `new_page`

```
mixed components\cms\Sections::new_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `page_app`

```
mixed components\cms\Sections::page_app()
```





* Visibility: **protected**



### Method `page_list`

```
mixed components\cms\Sections::page_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `setting_edit`

```
mixed components\cms\Sections::setting_edit($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `setting_edit_simple`

```
mixed components\cms\Sections::setting_edit_simple()
```





* Visibility: **protected**



### Method `setting_list`

```
mixed components\cms\Sections::setting_list()
```





* Visibility: **protected**



### Method `site_list`

```
mixed components\cms\Sections::site_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### Method `template_list`

```
mixed components\cms\Sections::template_list()
```





* Visibility: **protected**



### Method `theme_list`

```
mixed components\cms\Sections::theme_list()
```





* Visibility: **protected**


