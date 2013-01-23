# components\account\Actions






* Class name: Actions
* Namespace: components\account
* Parent class: [dependencies\BaseComponent](dependencies-BaseComponent)




## Class index

**Properties**
* `protected mixed $default_permission`
* `protected mixed $permissions`

**Methods**
* `protected mixed cancel_import_users()`
* `protected mixed claim_account($data)`
* `protected mixed deactivate_user($data)`
* `protected mixed delete_user($data)`
* `protected mixed delete_user_group($data)`
* `protected mixed edit_profile($data)`
* `protected mixed insert_user_groups($data)`
* `protected mixed login($data)`
* `protected mixed logout($data)`
* `protected mixed register($data)`
* `protected mixed reset_password($data)`
* `protected mixed save_avatar($data)`
* `protected mixed send_mail($data)`
* `protected mixed set_user_status($data)`
* `protected mixed update_user_groups($data)`


## Inheritance index

**Properties**
* `protected static mixed $reserved`
* `protected mixed $component`

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
protected mixed $default_permission = 2
```





* Visibility: **protected**


### $permissions

```
protected mixed $permissions = array('login' => 0, 'logout' => 1, 'register' => 0, 'edit_profile' => 1, 'claim_account' => 0, 'save_avatar' => 1)
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



### cancel_import_users

```
mixed components\account\Actions::cancel_import_users()
```





* Visibility: **protected**



### claim_account

```
mixed components\account\Actions::claim_account($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### deactivate_user

```
mixed components\account\Actions::deactivate_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### delete_user

```
mixed components\account\Actions::delete_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### delete_user_group

```
mixed components\account\Actions::delete_user_group($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### edit_profile

```
mixed components\account\Actions::edit_profile($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### insert_user_groups

```
mixed components\account\Actions::insert_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### login

```
mixed components\account\Actions::login($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### logout

```
mixed components\account\Actions::logout($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### register

```
mixed components\account\Actions::register($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### reset_password

```
mixed components\account\Actions::reset_password($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### save_avatar

```
mixed components\account\Actions::save_avatar($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### send_mail

```
mixed components\account\Actions::send_mail($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### set_user_status

```
mixed components\account\Actions::set_user_status($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### update_user_groups

```
mixed components\account\Actions::update_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**


