# components\cms\Sections
[API index](../../API-index.md)






* Class name: Sections
* Namespace: components\cms
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index


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
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

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
In class: [components\cms\Sections](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\cms\Sections](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\cms\Sections](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\cms\Sections](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_html`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**






## Method `helper`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\cms\Sections](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `admin_toolbar`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::admin_toolbar()
```





* Visibility: **protected**






## Method `app`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::app($view)
```





* Visibility: **protected**

#### Arguments

* $view **mixed**






## Method `config_app`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::config_app()
```





* Visibility: **protected**






## Method `configbar`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::configbar()
```





* Visibility: **protected**






## Method `context_menus`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::context_menus()
```





* Visibility: **protected**






## Method `edit_menu_item`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::edit_menu_item($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `edit_page`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::edit_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `edit_site`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::edit_site($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `ip_edit`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::ip_edit()
```





* Visibility: **protected**






## Method `ip_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::ip_list()
```





* Visibility: **protected**






## Method `link_menu_item`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::link_menu_item($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `login_form`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::login_form()
```





* Visibility: **protected**






## Method `menu_app`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::menu_app()
```





* Visibility: **protected**






## Method `menu_items`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::menu_items($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `menu_toolbar`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::menu_toolbar($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `menus`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::menus($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `module_app`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::module_app()
```





* Visibility: **protected**






## Method `new_page`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::new_page($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `page_app`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::page_app()
```





* Visibility: **protected**






## Method `page_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::page_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `setting_edit`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::setting_edit($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `setting_edit_simple`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::setting_edit_simple()
```





* Visibility: **protected**






## Method `setting_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::setting_list()
```





* Visibility: **protected**






## Method `site_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::site_list($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `template_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::template_list()
```





* Visibility: **protected**






## Method `theme_list`
In class: [components\cms\Sections](#top)

```
mixed components\cms\Sections::theme_list()
```





* Visibility: **protected**





