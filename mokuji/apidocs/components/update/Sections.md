# components\update\Sections
[API index](../../API-index.md)






* Class name: Sections
* Namespace: components\update
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed install_admin($data)`](#method-install_admin)
* [`protected mixed install_db($data)`](#method-install_db)
* [`protected mixed install_intro($data)`](#method-install_intro)
* [`protected mixed install_site($data)`](#method-install_site)
* [`protected mixed upgrade_config($data)`](#method-upgrade_config)
* [`protected mixed upgrade_file_references($data)`](#method-upgrade_file_references)
* [`protected mixed upgrade_files($data)`](#method-upgrade_files)
* [`protected mixed upgrade_intro($data)`](#method-upgrade_intro)
* [`protected mixed upgrade_packages($data)`](#method-upgrade_packages)


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
In class: [components\update\Sections](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\update\Sections](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\update\Sections](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\update\Sections](#top)

```
protected mixed $permissions = array('upgrade_intro' => 0, 'upgrade_config' => 0, 'upgrade_files' => 0, 'upgrade_packages' => 0, 'install_db' => 0, 'install_site' => 0, 'install_intro' => 0, 'install_admin' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\update\Sections](#top)

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
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_html`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**






## Method `helper`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\update\Sections](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `install_admin`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::install_admin($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `install_db`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::install_db($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `install_intro`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::install_intro($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `install_site`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::install_site($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `upgrade_config`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::upgrade_config($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `upgrade_file_references`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::upgrade_file_references($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `upgrade_files`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::upgrade_files($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `upgrade_intro`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::upgrade_intro($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `upgrade_packages`
In class: [components\update\Sections](#top)

```
mixed components\update\Sections::upgrade_packages($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**





