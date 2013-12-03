# components\account\controllers\base\Controller
[API index](../../../../API-index.md)






* Class name: Controller
* Namespace: components\account\controllers\base
* Parent class: [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected \dependencies\Data $data`](#property-data)
* [`private string $viewName`](#property-viewname)
* [`private \dependencies\BaseViews $viewObject`](#property-viewobject)

**Methods**
* [`public mixed __construct(\dependencies\BaseViews $viewObject, string $viewName)`](#method-__construct)
* [`public \dependencies\Data getData()`](#method-getData)
* [`public boolean hasView()`](#method-hasView)
* [`public string renderView()`](#method-renderView)
* [`public mixed validate(mixed $data, string $title, array $rules, boolean $translate)`](#method-validate)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public mixed _call($controller, array $args)`](#method-_call)
* [`public mixed call($controller, $data)`](#method-call)
* [`public self create_filter(string $key, mixed $value)`](#method-create_filter)
* [`public mixed filters()`](#method-filters)
* [`public mixed helper($controller)`](#method-helper)
* [`public mixed model($model_name)`](#method-model)
* [`public mixed module($module_name, $options)`](#method-module)
* [`public mixed section($section, $options)`](#method-section)
* [`public mixed table($model_name, $id)`](#method-table)
* [`public mixed view($module_name, $options)`](#method-view)



# Properties


## Property `$reserved`
In class: [components\account\controllers\base\Controller](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\account\controllers\base\Controller](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)


## Property `$data`
In class: [components\account\controllers\base\Controller](#top)

```
protected \dependencies\Data $data
```

Contains data gathered by the controller.



* Visibility: **protected**


## Property `$default_permission`
In class: [components\account\controllers\base\Controller](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\account\controllers\base\Controller](#top)

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)


## Property `$viewName`
In class: [components\account\controllers\base\Controller](#top)

```
private string $viewName
```

Contains the name of the view.



* Visibility: **private**


## Property `$viewObject`
In class: [components\account\controllers\base\Controller](#top)

```
private \dependencies\BaseViews $viewObject
```

Contains the object that we're loading a view from.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [components\account\controllers\base\Controller](#top)

```
mixed components\account\controllers\base\Controller::__construct(\dependencies\BaseViews $viewObject, string $viewName)
```

Initialize with an optional viewObject and viewName.



* Visibility: **public**

#### Arguments

* $viewObject **[dependencies\BaseViews](../../../../dependencies/BaseViews.md)**
* $viewName **string**






## Method `_call`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `create_filter`
In class: [components\account\controllers\base\Controller](#top)

```
self dependencies\BaseComponent::create_filter(string $key, mixed $value)
```

Creates a component specific filter in the session.



* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $key **string** - The key under which the value will be available.
* $value **mixed** - The value for the filter.


#### Return value

**self** - Chaining enabled.







## Method `filters`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)






## Method `getData`
In class: [components\account\controllers\base\Controller](#top)

```
\dependencies\Data components\account\controllers\base\Controller::getData()
```

Return the data.



* Visibility: **public**






## Method `hasView`
In class: [components\account\controllers\base\Controller](#top)

```
boolean components\account\controllers\base\Controller::hasView()
```

Return true if a viewObject and viewName have been set on this controller.



* Visibility: **public**






## Method `helper`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `renderView`
In class: [components\account\controllers\base\Controller](#top)

```
string components\account\controllers\base\Controller::renderView()
```

Renders the view, passing along the data.



* Visibility: **public**


#### Return value

**string** - The resulting HTML.







## Method `section`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `validate`
In class: [components\account\controllers\base\Controller](#top)

```
mixed components\account\controllers\base\Controller::validate(mixed $data, string $title, array $rules, boolean $translate)
```

Validate data.



* Visibility: **public**

#### Arguments

* $data **mixed** - The data to validate.
* $title **string** - A friendly name for the data.
* $rules **array** - The validation rules.
* $translate **boolean** - Whether to translate. Defaults to true.


#### Return value

**mixed** - The given data, sanitized by the validator.




#### Throws exceptions

* **exceptions\Validation** - If validation fails.




## Method `view`
In class: [components\account\controllers\base\Controller](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**





