# components\cms\Views
[API index](../../API-index.md)






* Class name: Views
* Namespace: components\cms
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed app($view)`](#method-app)
* [`protected mixed instructions()`](#method-instructions)
* [`protected mixed menus($options)`](#method-menus)
* [`protected mixed mod()`](#method-mod)
* [`protected mixed modules()`](#method-modules)
* [`protected mixed page()`](#method-page)
* [`protected mixed pages()`](#method-pages)
* [`protected mixed settings($options)`](#method-settings)
* [`protected mixed settings_cms_configuration()`](#method-settings_cms_configuration)
* [`protected mixed settings_website_information()`](#method-settings_website_information)
* [`protected mixed sites()`](#method-sites)


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
In class: [components\cms\Views](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\cms\Views](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\cms\Views](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\cms\Views](#top)

```
protected mixed $permissions = array('page' => 0, 'modules' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\cms\Views](#top)

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
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_html`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**






## Method `helper`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\cms\Views](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `app`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::app($view)
```





* Visibility: **protected**

#### Arguments

* $view **mixed**






## Method `instructions`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::instructions()
```





* Visibility: **protected**






## Method `menus`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::menus($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `mod`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::mod()
```





* Visibility: **protected**






## Method `modules`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::modules()
```





* Visibility: **protected**






## Method `page`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::page()
```





* Visibility: **protected**






## Method `pages`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::pages()
```





* Visibility: **protected**






## Method `settings`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::settings($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `settings_cms_configuration`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::settings_cms_configuration()
```





* Visibility: **protected**






## Method `settings_website_information`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::settings_website_information()
```





* Visibility: **protected**






## Method `sites`
In class: [components\cms\Views](#top)

```
mixed components\cms\Views::sites()
```





* Visibility: **protected**





