# components\cms\Actions






* Class name: Actions
* Namespace: components\cms
* Parent class: [dependencies\BaseComponent](dependencies-BaseComponent)




## Class index

**Properties**
* `protected mixed $permissions`

**Methods**
* `protected mixed delete_page($data)`
* `protected mixed detach_page($data)`
* `protected mixed edit_page($data)`
* `protected mixed insert_sites($data)`
* `protected mixed language($data)`
* `protected mixed link_page($data)`
* `protected mixed login($data)`
* `protected mixed logout($data)`
* `protected mixed new_page($data)`
* `protected mixed pause_redirects($data)`
* `protected mixed play_redirects($data)`
* `protected mixed register($data)`
* `protected mixed save_menu_item($data)`
* `protected mixed save_menu_link($data)`
* `protected mixed save_settings_simple($data)`
* `protected mixed select_menu($data)`
* `protected mixed send_feedback($data)`
* `protected mixed update_cms_config($data)`
* `protected mixed update_ip_addresses($data)`
* `protected mixed update_sites($data)`


## Inheritance index

**Properties**
* `protected static mixed $reserved`
* `protected mixed $component`
* `protected mixed $default_permission`

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
protected mixed $permissions = array('select_menu' => 2, 'new_page' => 2, 'edit_page' => 2, 'logout' => 1)
```





* Visibility: **protected**


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



### delete_page

```
mixed components\cms\Actions::delete_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### detach_page

```
mixed components\cms\Actions::detach_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### edit_page

```
mixed components\cms\Actions::edit_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### insert_sites

```
mixed components\cms\Actions::insert_sites($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### language

```
mixed components\cms\Actions::language($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### link_page

```
mixed components\cms\Actions::link_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### login

```
mixed components\cms\Actions::login($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### logout

```
mixed components\cms\Actions::logout($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### new_page

```
mixed components\cms\Actions::new_page($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### pause_redirects

```
mixed components\cms\Actions::pause_redirects($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### play_redirects

```
mixed components\cms\Actions::play_redirects($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### register

```
mixed components\cms\Actions::register($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### save_menu_item

```
mixed components\cms\Actions::save_menu_item($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### save_menu_link

```
mixed components\cms\Actions::save_menu_link($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### save_settings_simple

```
mixed components\cms\Actions::save_settings_simple($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### select_menu

```
mixed components\cms\Actions::select_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### send_feedback

```
mixed components\cms\Actions::send_feedback($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### update_cms_config

```
mixed components\cms\Actions::update_cms_config($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### update_ip_addresses

```
mixed components\cms\Actions::update_ip_addresses($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### update_sites

```
mixed components\cms\Actions::update_sites($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**


