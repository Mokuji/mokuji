# components\account\Helpers
[API index](../../API-index.md)






* Class name: Helpers
* Namespace: components\account
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index


**Methods**
* [`public \components\account\models\Accounts create_user($data)`](#method-create_user)
* [`public mixed get_new_users($limit)`](#method-get_new_users)
* [`public mixed import_users($data)`](#method-import_users)
* [`public \dependencies\UserFunction invite_user($data)`](#method-invite_user)
* [`public \dependencies\UserFunction reset_password(\components\account\Integer/Array(Integer) $user_id)`](#method-reset_password)
* [`public mixed set_group_members($group_id, $members)`](#method-set_group_members)
* [`public mixed set_user_group_memberships($data)`](#method-set_user_group_memberships)
* [`public Boolean should_claim()`](#method-should_claim)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

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
In class: [components\account\Helpers](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\Helpers](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\account\Helpers](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\account\Helpers](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `_call`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



## Method `call`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



## Method `create_user`
In class: [components\account\Helpers](#top)

```
\components\account\models\Accounts components\account\Helpers::create_user($data)
```

Create a new user.



* Visibility: **public**

#### Arguments

* $data **mixed**



## Method `filters`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `get_new_users`
In class: [components\account\Helpers](#top)

```
mixed components\account\Helpers::get_new_users($limit)
```





* Visibility: **public**

#### Arguments

* $limit **mixed**



## Method `helper`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



## Method `import_users`
In class: [components\account\Helpers](#top)

```
mixed components\account\Helpers::import_users($data)
```





* Visibility: **public**

#### Arguments

* $data **mixed**



## Method `invite_user`
In class: [components\account\Helpers](#top)

```
\dependencies\UserFunction components\account\Helpers::invite_user($data)
```

Invite a new user to create an account.



* Visibility: **public**

#### Arguments

* $data **mixed**



## Method `model`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



## Method `module`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `reset_password`
In class: [components\account\Helpers](#top)

```
\dependencies\UserFunction components\account\Helpers::reset_password(\components\account\Integer/Array(Integer) $user_id)
```

Force a reset of the password of the user.



* Visibility: **public**

#### Arguments

* $user_id **components\account\Integer/Array(Integer)** - The user id&#039;s to reset the password for.



## Method `section`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



## Method `set_group_members`
In class: [components\account\Helpers](#top)

```
mixed components\account\Helpers::set_group_members($group_id, $members)
```





* Visibility: **public**

#### Arguments

* $group_id **mixed**
* $members **mixed**



## Method `set_user_group_memberships`
In class: [components\account\Helpers](#top)

```
mixed components\account\Helpers::set_user_group_memberships($data)
```

Sets the user group memberships for an account.



* Visibility: **public**

#### Arguments

* $data **mixed**



## Method `should_claim`
In class: [components\account\Helpers](#top)

```
Boolean components\account\Helpers::should_claim()
```

Whether the logged in user should claim their account or not.



* Visibility: **public**



## Method `table`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



## Method `view`
In class: [components\account\Helpers](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**


