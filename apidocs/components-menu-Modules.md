# components\menu\Modules






* Class name: Modules
* Namespace: components\menu
* Parent class: [dependencies\BaseViews](dependencies-BaseViews)




## Class index

**Properties**

**Methods**
* `protected mixed breadcrumbs($options)`
* `protected mixed menu(array $options)`
* `protected mixed menu_image($options)`
* `protected mixed sitemap($options)`


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



### breadcrumbs

```
mixed components\menu\Modules::breadcrumbs($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### menu

```
mixed components\menu\Modules::menu(array $options)
```

Returns a result set with the menu items you asked for.



* Visibility: **protected**

#### Arguments

* $options **array** - Array with options.
 @key int $site_id              - The site ID to load the menu from from.
 @key int $template_key         - The menu&#039;s template_key to select items from.
 @key int $parent_pk            - The menu item id to select submenu items from.
 @key int $min_depth            - Minimum depth to show items from.
 @key int $max_depth            - Number that indicates how far in submenus it should go.
 @key bool $display_select_menu - If true: a select menu will be returned.
 @key bool $no_active           - If false: suppresses the &quot;active&quot; class on active menu items.
 @key bool $no_selected         - If false: suppresses the &quot;selected&quot; class on selected menu items.



### menu_image

```
mixed components\menu\Modules::menu_image($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### sitemap

```
mixed components\menu\Modules::sitemap($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**


