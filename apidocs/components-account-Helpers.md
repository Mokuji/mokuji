# components\account\Helpers






* Class name: Helpers
* Namespace: components\account
* Parent class: [dependencies\BaseComponent](dependencies-BaseComponent)




## Class index

**Properties**

**Methods**
* `public \components\account\models\Accounts create_user($data)`
* `public mixed get_new_users($limit)`
* `public mixed import_users($data)`
* `public \dependencies\UserFunction invite_user($data)`
* `public \dependencies\UserFunction reset_password(\components\account\Integer/Array(Integer) $user_id)`
* `public mixed set_group_members($group_id, $members)`
* `public mixed set_user_group_memberships($data)`
* `public Boolean should_claim()`


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



### create_user

```
\components\account\models\Accounts components\account\Helpers::create_user($data)
```

Create a new user.



* Visibility: **public**

#### Arguments

* $data **mixed**



### filters

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)



### get_new_users

```
mixed components\account\Helpers::get_new_users($limit)
```





* Visibility: **public**

#### Arguments

* $limit **mixed**



### helper

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $controller **mixed**



### import_users

```
mixed components\account\Helpers::import_users($data)
```





* Visibility: **public**

#### Arguments

* $data **mixed**



### invite_user

```
\dependencies\UserFunction components\account\Helpers::invite_user($data)
```

Invite a new user to create an account.



* Visibility: **public**

#### Arguments

* $data **mixed**



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



### reset_password

```
\dependencies\UserFunction components\account\Helpers::reset_password(\components\account\Integer/Array(Integer) $user_id)
```

Force a reset of the password of the user.



* Visibility: **public**

#### Arguments

* $user_id **components\account\Integer/Array(Integer)** - The user id&#039;s to reset the password for.



### section

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](dependencies-BaseComponent)

#### Arguments

* $section **mixed**
* $options **mixed**



### set_group_members

```
mixed components\account\Helpers::set_group_members($group_id, $members)
```





* Visibility: **public**

#### Arguments

* $group_id **mixed**
* $members **mixed**



### set_user_group_memberships

```
mixed components\account\Helpers::set_user_group_memberships($data)
```

Sets the user group memberships for an account.



* Visibility: **public**

#### Arguments

* $data **mixed**



### should_claim

```
Boolean components\account\Helpers::should_claim()
```

Whether the logged in user should claim their account or not.



* Visibility: **public**



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


