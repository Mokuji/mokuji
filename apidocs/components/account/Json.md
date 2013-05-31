# components\account\Json
[API index](../../API-index.md)






* Class name: Json
* Namespace: components\account
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed create_user($data, $parameters)`](#method-create_user)
* [`public mixed update_user($data, $parameters)`](#method-update_user)
* [`protected mixed create_mail($data, $parameters)`](#method-create_mail)
* [`protected mixed create_password_reset_finalization($data, $params)`](#method-create_password_reset_finalization)
* [`protected mixed create_password_reset_request($data, $params)`](#method-create_password_reset_request)
* [`protected array create_user_session(\dependencies\Data $data, \dependencies\Data $params)`](#method-create_user_session)
* [`protected mixed get_mail_autocomplete($data, $parameters)`](#method-get_mail_autocomplete)
* [`protected mixed update_password($data, $parameters)`](#method-update_password)


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
In class: [components\account\Json](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\Json](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\account\Json](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**


## Property `$permissions`
In class: [components\account\Json](#top)

```
protected mixed $permissions = array('create_password_reset_request' => 0, 'create_password_reset_finalization' => 0, 'create_user_session' => 0, 'update_password' => 1)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_user`
In class: [components\account\Json](#top)

```
mixed components\account\Json::create_user($data, $parameters)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $parameters **mixed**






## Method `filters`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `helper`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `section`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `update_user`
In class: [components\account\Json](#top)

```
mixed components\account\Json::update_user($data, $parameters)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $parameters **mixed**






## Method `view`
In class: [components\account\Json](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `create_mail`
In class: [components\account\Json](#top)

```
mixed components\account\Json::create_mail($data, $parameters)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $parameters **mixed**






## Method `create_password_reset_finalization`
In class: [components\account\Json](#top)

```
mixed components\account\Json::create_password_reset_finalization($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `create_password_reset_request`
In class: [components\account\Json](#top)

```
mixed components\account\Json::create_password_reset_request($data, $params)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $params **mixed**






## Method `create_user_session`
In class: [components\account\Json](#top)

```
array components\account\Json::create_user_session(\dependencies\Data $data, \dependencies\Data $params)
```

Attempt to log in the user.



* Visibility: **protected**

#### Arguments

* $data **[dependencies\Data](../../dependencies/Data.md)** - Array containing &#039;username&#039; and &#039;password&#039; keys.
* $params **[dependencies\Data](../../dependencies/Data.md)** - Empty array.


#### Return value

**array** - Array with &#039;success&#039; boolean and &#039;target_url&#039; to suggest a redirect.







## Method `get_mail_autocomplete`
In class: [components\account\Json](#top)

```
mixed components\account\Json::get_mail_autocomplete($data, $parameters)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $parameters **mixed**






## Method `update_password`
In class: [components\account\Json](#top)

```
mixed components\account\Json::update_password($data, $parameters)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**
* $parameters **mixed**





