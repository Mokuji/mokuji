# components\account\Actions
[API index](../../API-index.md)






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
* [`protected mixed use_password_reset_token($data)`](#method-use_password_reset_token)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed _call($controller, array $args)`](#method-_call)
* [`public mixed call($controller, $data)`](#method-call)
* [`public mixed filters()`](#method-filters)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\account\Actions](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\Actions](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\account\Actions](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\account\Actions](#top)

```
protected mixed $permissions = array('login' => 0, 'register' => 0, 'claim_account' => 0, 'use_password_reset_token' => 0, 'logout' => 1, 'save_avatar' => 1, 'edit_profile' => 1)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `view`
In class: [components\account\Actions](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `cancel_import_users`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::cancel_import_users()
```





* Visibility: **protected**






## Method `claim_account`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::claim_account($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `deactivate_user`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::deactivate_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `delete_user`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::delete_user($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `delete_user_group`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::delete_user_group($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `edit_profile`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::edit_profile($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `insert_user_groups`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::insert_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `login`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::login($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `logout`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::logout($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `register`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::register($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `reset_password`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::reset_password($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `save_avatar`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::save_avatar($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `send_mail`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::send_mail($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `set_user_status`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::set_user_status($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `update_user_groups`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::update_user_groups($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**






## Method `use_password_reset_token`
In class: [components\account\Actions](#top)

```
mixed components\account\Actions::use_password_reset_token($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**





