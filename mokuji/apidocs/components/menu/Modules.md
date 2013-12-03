# components\menu\Modules
[API index](../../API-index.md)






* Class name: Modules
* Namespace: components\menu
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed breadcrumbs($options)`](#method-breadcrumbs)
* [`protected mixed menu(array $options)`](#method-menu)
* [`protected mixed menu_image($options)`](#method-menu_image)


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
* [`public mixed get_html($view, $options)`](#method-get_html)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\menu\Modules](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\menu\Modules](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\menu\Modules](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\menu\Modules](#top)

```
protected mixed $permissions = array('menu' => 0, 'menu_image' => 0, 'breadcrumbs' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\menu\Modules](#top)

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
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_html`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**






## Method `helper`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\menu\Modules](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `breadcrumbs`
In class: [components\menu\Modules](#top)

```
mixed components\menu\Modules::breadcrumbs($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `menu`
In class: [components\menu\Modules](#top)

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
 @key bool $keep_menu           - If true: keeps the current menu key in the URL. Only the pid renews.
 @key bool $no_active           - If true: suppresses the &quot;active&quot; class on active menu items.
 @key bool $no_selected         - If true: suppresses the &quot;selected&quot; class on selected menu items.
 @key bool $select_from_root    - If true: select items from root.
            tx(&#039;Data&#039;)-&gt;get-&gt;menu will be used to calculate root.
            $parent_pk, $template_key and $site_id will be overwritten.






## Method `menu_image`
In class: [components\menu\Modules](#top)

```
mixed components\menu\Modules::menu_image($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**





