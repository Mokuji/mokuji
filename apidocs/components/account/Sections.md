# components\account\Sections
[API index](../../API-index.md)






* Class name: Sections
* Namespace: components\account
* Parent class: [dependencies\BaseViews](../../dependencies/BaseViews.md)




## Class index


**Methods**
* [`protected mixed compose_mail()`](#method-compose_mail)
* [`protected mixed edit_user()`](#method-edit_user)
* [`protected mixed edit_user_group($options)`](#method-edit_user_group)
* [`protected mixed execute_import_users()`](#method-execute_import_users)
* [`protected mixed group_list()`](#method-group_list)
* [`protected mixed import_users()`](#method-import_users)
* [`protected mixed login_form()`](#method-login_form)
* [`protected mixed profile()`](#method-profile)
* [`protected mixed user_list()`](#method-user_list)


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
* [`public mixed get_html($view, $options)`](#method-get_html)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\account\Sections](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\Sections](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\account\Sections](#top)

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\account\Sections](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


# Methods


## Method `__construct`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `_call`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



## Method `call`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



## Method `filters`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)



## Method `get_html`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseViews::get_html($view, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseViews](../../dependencies/BaseViews.md)

#### Arguments

* $view **mixed**
* $options **mixed**



## Method `helper`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



## Method `model`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



## Method `module`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `section`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



## Method `table`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



## Method `view`
In class: [components\account\Sections](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



## Method `compose_mail`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::compose_mail()
```





* Visibility: **protected**



## Method `edit_user`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::edit_user()
```





* Visibility: **protected**



## Method `edit_user_group`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::edit_user_group($options)
```





* Visibility: **protected**

#### Arguments

* $options **mixed**



## Method `execute_import_users`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::execute_import_users()
```





* Visibility: **protected**



## Method `group_list`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::group_list()
```





* Visibility: **protected**



## Method `import_users`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::import_users()
```





* Visibility: **protected**



## Method `login_form`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::login_form()
```





* Visibility: **protected**



## Method `profile`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::profile()
```





* Visibility: **protected**



## Method `user_list`
In class: [components\account\Sections](#top)

```
mixed components\account\Sections::user_list()
```





* Visibility: **protected**


