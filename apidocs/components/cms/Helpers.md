# components\cms\Helpers






* Class name: Helpers
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)




## Class index

**Properties**

**Methods**
* [`public mixed check_page_authorisation($pid)`](#method-check_page_authorisation)
* [`public mixed get_page_info($pid)`](#method-get_page_info)
* [`public mixed get_page_options($pid)`](#method-get_page_options)
* [`public mixed get_page_permissions($pid)`](#method-get_page_permissions)
* [`public mixed get_settings($key)`](#method-get_settings)
* [`public mixed page_authorisation($pid)`](#method-page_authorisation)
* [`public mixed set_page_permissions($pid, $permissions)`](#method-set_page_permissions)


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
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$component`

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$default_permission`

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$permissions`

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


Methods
-------


### Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)



### Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



### Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



### Method `check_page_authorisation`

```
mixed components\cms\Helpers::check_page_authorisation($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**



### Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)



### Method `get_page_info`

```
mixed components\cms\Helpers::get_page_info($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**



### Method `get_page_options`

```
mixed components\cms\Helpers::get_page_options($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**



### Method `get_page_permissions`

```
mixed components\cms\Helpers::get_page_permissions($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**



### Method `get_settings`

```
mixed components\cms\Helpers::get_settings($key)
```

$options[]



* Visibility: **public**

#### Arguments

* $key **mixed**



### Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



### Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



### Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `page_authorisation`

```
mixed components\cms\Helpers::page_authorisation($pid)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**



### Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



### Method `set_page_permissions`

```
mixed components\cms\Helpers::set_page_permissions($pid, $permissions)
```





* Visibility: **public**

#### Arguments

* $pid **mixed**
* $permissions **mixed**



### Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**


