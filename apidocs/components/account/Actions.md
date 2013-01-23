# components\account\Actions






* Class name: Actions
* Namespace: components\account
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`protected mixed cancel_import_users()`](#method-cancel_import_users)
* [`protected mixed claim_account($data)`](#method-claim_account)
* [`protected mixed deactivate_user($data)`](#method-deactivate_user)
* [`protected mixed delete_user($data)`](#method-delete_user)
* [`protected mixed delete_user_group($data)`](#method-delete_user_group)
* [`protected mixed edit_profile($data)`](#method-edit_profile)
* [`protected mixed insert_user_groups($data)`](#method-insert_user_groups)
* [`protected mixed login($data)`](#method-login)
* [`protected mixed logout($data)`](#method-logout)
* [`protected mixed register($data)`](#method-register)
* [`protected mixed reset_password($data)`](#method-reset_password)
* [`protected mixed save_avatar($data)`](#method-save_avatar)
* [`protected mixed send_mail($data)`](#method-send_mail)
* [`protected mixed set_user_status($data)`](#method-set_user_status)
* [`protected mixed update_user_groups($data)`](#method-update_user_groups)


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


### Property `$reserved`

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


### Property `$component`

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


### Property `$default_permission`

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


### Property `$permissions`

```
protected mixed $permissions = array('login' => 0, 'logout' => 1, 'register' => 0, 'edit_profile' => 1, 'claim_account' => 0, 'save_avatar' => 1)
```





* Visibility: **protected**


Methods
-------


### Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



### Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



### Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



### Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



### Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



### Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



### Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



### Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `cancel_import_users`

```
mixed components\account\Actions::cancel_import_users()
```





* Visibility: **protected**



### Method `claim_account`

```
mixed components\account\Actions::claim_account($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `deactivate_user`

```
mixed components\account\Actions::deactivate_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `delete_user`

```
mixed components\account\Actions::delete_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `delete_user_group`

```
mixed components\account\Actions::delete_user_group($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `edit_profile`

```
mixed components\account\Actions::edit_profile($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `insert_user_groups`

```
mixed components\account\Actions::insert_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `login`

```
mixed components\account\Actions::login($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `logout`

```
mixed components\account\Actions::logout($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `register`

```
mixed components\account\Actions::register($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `reset_password`

```
mixed components\account\Actions::reset_password($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `save_avatar`

```
mixed components\account\Actions::save_avatar($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `send_mail`

```
mixed components\account\Actions::send_mail($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `set_user_status`

```
mixed components\account\Actions::set_user_status($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `update_user_groups`

```
mixed components\account\Actions::update_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**


