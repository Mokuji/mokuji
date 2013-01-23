# components\cms\Modules






* Class name: Modules
* Namespace: components\cms
* Parent class: [dependencies\BaseViews](dependencies-BaseViews)




## Class index

**Properties**

**Methods**
* `protected mixed feedback_form()`
* `protected mixed menu($options)`
* `protected mixed menus($options)`
* `protected mixed register($options)`
* `protected mixed simple_login()`


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



### feedback_form

```
mixed components\cms\Modules::feedback_form()
```





* Visibility: **protected**



### menu

```
mixed components\cms\Modules::menu($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### menus

```
mixed components\cms\Modules::menus($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### register

```
mixed components\cms\Modules::register($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



### simple_login

```
mixed components\cms\Modules::simple_login()
```





* Visibility: **protected**


