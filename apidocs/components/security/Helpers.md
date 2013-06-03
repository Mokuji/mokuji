# components\security\Helpers
[API index](../../API-index.md)






* Class name: Helpers
* Namespace: components\security
* Parent class: [dependencies\BaseComponent](../../dependencies/BaseComponent.md)




## Class index

**Properties**
* [`protected mixed $permissions`](#property-permissions)

**Methods**
* [`public string generate_captcha($options)`](#method-generate_captcha)
* [`public string reload_captcha_js()`](#method-reload_captcha_js)
* [`public boolean validate_captcha($options)`](#method-validate_captcha)


## Inheritance index

**Properties**
* [`protected static mixed $reserved`](#property-reserved)
* [`protected mixed $component`](#property-component)
* [`protected mixed $default_permission`](#property-default_permission)

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
In class: [components\security\Helpers](#top)

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$component`
In class: [components\security\Helpers](#top)

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$default_permission`
In class: [components\security\Helpers](#top)

```
protected mixed $default_permission = 2
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)


## Property `$permissions`
In class: [components\security\Helpers](#top)

```
protected mixed $permissions = array('generate_captcha' => 0, 'validate_captcha' => 0, 'reload_captcha_js' => 0)
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `_call`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**






## Method `call`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**






## Method `filters`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)






## Method `generate_captcha`
In class: [components\security\Helpers](#top)

```
string components\security\Helpers::generate_captcha($options)
```

Generates a CAPTCHA field based on the security settings.



* Visibility: **public**

#### Arguments

* $options **mixed**


#### Return value

**string** - The generated HTML ready for inclusion into a form.







## Method `helper`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**






## Method `model`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**






## Method `module`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**






## Method `reload_captcha_js`
In class: [components\security\Helpers](#top)

```
string components\security\Helpers::reload_captcha_js()
```

Generates javascript code to dynamically reload the generated captcha.

Useful for restForms.

* Visibility: **public**


#### Return value

**string** - The generated javascript code to reload with.







## Method `section`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**






## Method `table`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**






## Method `validate_captcha`
In class: [components\security\Helpers](#top)

```
boolean components\security\Helpers::validate_captcha($options)
```

Validates a response based on the security settings.



* Visibility: **public**

#### Arguments

* $options **mixed**


#### Return value

**boolean** - Whether the response was valid or not.







## Method `view`
In class: [components\security\Helpers](#top)

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](../../dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**





