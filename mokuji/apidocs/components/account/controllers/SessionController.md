# components\account\controllers\SessionController
[API index](../../../API-index.md)






* Class name: SessionController
* Namespace: components\account\controllers
* Parent class: [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)




## Class index

**Properties**
* [`private \dependencies\Data $userObject`](#property-userobject)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public self becomeUser(integer $userId)`](#method-becomeUser)
* [`public integer getLoginStatus()`](#method-getLoginStatus)
* [`public \dependencies\Data getUserObject()`](#method-getUserObject)
* [`public self loginUser(string $name, string $pass, boolean $persistent)`](#method-loginUser)
* [`public self logoutUser()`](#method-logoutUser)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected \dependencies\Data $data`](#property-data)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed _call($controller, array $args)`](#method-_call)
* [`public mixed call($controller, $data)`](#method-call)
* [`public self create_filter(string $key, mixed $value)`](#method-create_filter)
* [`public mixed filters()`](#method-filters)
* [`public \dependencies\Data getData()`](#method-getData)
* [`public boolean hasView()`](#method-hasView)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public string renderView()`](#method-renderView)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed validate(mixed $data, string $title, array $rules, boolean $translate)`](#method-validate)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\account\controllers\SessionController](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\controllers\SessionController](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)


## Property `$data`
In class: [components\account\controllers\SessionController](#top)

```
protected \dependencies\Data $data
```

Contains data gathered by the controller.



* Visibility: **protected**
* This property is defined by [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)


## Property `$default_permission`
In class: [components\account\controllers\SessionController](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\account\controllers\SessionController](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)


## Property `$userObject`
In class: [components\account\controllers\SessionController](#top)

```
private \dependencies\Data $userObject
```

Contains a reference to the user object in the core.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [components\account\controllers\SessionController](#top)

```
mixed components\account\controllers\SessionController::__construct()
```

Set the userObject.



* Visibility: **public**






## Method `_call`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `becomeUser`
In class: [components\account\controllers\SessionController](#top)

```
self components\account\controllers\SessionController::becomeUser(integer $userId)
```

Change the session to the new given user ID.



* Visibility: **public**

#### Arguments

* $userId **integer** - The ID of the user to log in as.


#### Return value

**self** - Chaining enabled.







## Method `call`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\account\controllers\SessionController](#top)

```
self dependencies\BaseComponent::create_filter(string $key, mixed $value)
```

Creates a component specific filter in the session.



* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $key **string** - The key under which the value will be available.
* $value **mixed** - The value for the filter.


#### Return value

**self** - Chaining enabled.







## Method `filters`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)






## Method `getData`
In class: [components\account\controllers\SessionController](#top)

```
\dependencies\Data components\account\controllers\base\Controller::getData()
```

Return the data.



* Visibility: **public**
* This method is defined by [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)






## Method `getLoginStatus`
In class: [components\account\controllers\SessionController](#top)

```
integer components\account\controllers\SessionController::getLoginStatus()
```

Return the level of access the user has on the server.

&lt;code&gt;0&lt;/code&gt; For not logged in.
&lt;code&gt;1&lt;/code&gt; For logged in.
&lt;code&gt;2&lt;/code&gt; For super-user.

* Visibility: **public**






## Method `getUserObject`
In class: [components\account\controllers\SessionController](#top)

```
\dependencies\Data components\account\controllers\SessionController::getUserObject()
```

Return the user object.



* Visibility: **public**






## Method `hasView`
In class: [components\account\controllers\SessionController](#top)

```
boolean components\account\controllers\base\Controller::hasView()
```

Return true if a viewObject and viewName have been set on this controller.



* Visibility: **public**
* This method is defined by [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)






## Method `helper`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `loginUser`
In class: [components\account\controllers\SessionController](#top)

```
self components\account\controllers\SessionController::loginUser(string $name, string $pass, boolean $persistent)
```

Create a user session.



* Visibility: **public**

#### Arguments

* $name **string** - The name of the user.
* $pass **string** - The email address of the user.
* $persistent **boolean** - Whether a persistence cookie should be created.


#### Return value

**self** - Chaining enabled.







## Method `logoutUser`
In class: [components\account\controllers\SessionController](#top)

```
self components\account\controllers\SessionController::logoutUser()
```

Destroy the user session.



* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `model`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `renderView`
In class: [components\account\controllers\SessionController](#top)

```
string components\account\controllers\base\Controller::renderView()
```

Renders the view, passing along the data.



* Visibility: **public**
* This method is defined by [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)


#### Return value

**string** - The resulting HTML.







## Method `section`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `validate`
In class: [components\account\controllers\SessionController](#top)

```
mixed components\account\controllers\base\Controller::validate(mixed $data, string $title, array $rules, boolean $translate)
```

Validate data.



* Visibility: **public**
* This method is defined by [components\account\controllers\base\Controller](../../../components/account/controllers/base/Controller.md)

#### Arguments

* $data **mixed** - The data to validate.
* $title **string** - A friendly name for the data.
* $rules **array** - The validation rules.
* $translate **boolean** - Whether to translate. Defaults to true.


#### Return value

**mixed** - The given data, sanitized by the validator.




#### Throws exceptions

* **[exception\Validation](../../../exception/Validation.md)** - If validation fails.




## Method `view`
In class: [components\account\controllers\SessionController](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**





