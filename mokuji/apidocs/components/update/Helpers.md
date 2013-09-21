# components\update\Helpers
[API index](../../API-index.md)






* Class name: Helpers
* Namespace: components\update
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`private static mixed $package_cache`](#property-package_cache)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed get_component_package($component)`](#method-get_component_package)
* [`public void rename_component_package(array $data)`](#method-rename_component_package)
* [`protected mixed check_updates($options)`](#method-check_updates)
* [`private mixed check_folder($folder, $namespace, $silent, $force)`](#method-check_folder)
* [`private mixed sync_manual_package($package, $folder, $namespace, $silent, $force)`](#method-sync_manual_package)


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
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\update\Helpers](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$package_cache`
In class: [components\update\Helpers](#top)

```
private mixed $package_cache = array()
```





* Visibility: **private**
* This property is **static**.


## Property `$component`
In class: [components\update\Helpers](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\update\Helpers](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\update\Helpers](#top)

```
protected mixed $permissions = array('get_component_package' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\update\Helpers](#top)

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
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `get_component_package`
In class: [components\update\Helpers](#top)

```
mixed components\update\Helpers::get_component_package($component)
```

Attempts to get the component entry in the database of a given component name.



* Visibility: **public**

#### Arguments

* $component **mixed**






## Method `helper`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `rename_component_package`
In class: [components\update\Helpers](#top)

```
void components\update\Helpers::rename_component_package(array $data)
```

Lets you rename a component package that's already installed.



* Visibility: **public**

#### Arguments

* $data **array** - A string array with keys &#039;component&#039; and &#039;old_title&#039;, guess what they do.






## Method `section`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\update\Helpers](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `check_updates`
In class: [components\update\Helpers](#top)

```
mixed components\update\Helpers::check_updates($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**






## Method `check_folder`
In class: [components\update\Helpers](#top)

```
mixed components\update\Helpers::check_folder($folder, $namespace, $silent, $force)
```





* Visibility: **private**

#### Arguments

* $folder **mixed**
* $namespace **mixed**
* $silent **mixed**
* $force **mixed**






## Method `sync_manual_package`
In class: [components\update\Helpers](#top)

```
mixed components\update\Helpers::sync_manual_package($package, $folder, $namespace, $silent, $force)
```





* Visibility: **private**

#### Arguments

* $package **mixed**
* $folder **mixed**
* $namespace **mixed**
* $silent **mixed**
* $force **mixed**





