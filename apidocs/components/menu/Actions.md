# components\menu\Actions






* Class name: Actions
* Namespace: components\menu
* Parent class: [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)




## Class index

**Properties**

**Methods**
* [`protected mixed delete_menu($data)`](#method-delete_menu)
* [`protected mixed menu_item_delete($data)`](#method-menu_item_delete)
* [`protected mixed new_menu($data)`](#method-new_menu)


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


### Property `$reserved`

```
protected mixed $reserved = array('__construct', 'filter', 'module', 'section', 'view', 'table', 'get_html', 'call', 'template')
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$component`

```
protected mixed $component
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$default_permission`

```
protected mixed $default_permission
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


### Property `$permissions`

```
protected mixed $permissions = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)


Methods
-------


### Method `__construct`

```
mixed dependencies\BaseComponent::__construct()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)



### Method `_call`

```
mixed dependencies\BaseComponent::_call($controller, array $args)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $args **array**



### Method `call`

```
mixed dependencies\BaseComponent::call($controller, $data)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**
* $data **mixed**



### Method `filters`

```
mixed dependencies\BaseComponent::filters()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)



### Method `helper`

```
mixed dependencies\BaseComponent::helper($controller)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $controller **mixed**



### Method `model`

```
mixed dependencies\BaseComponent::model($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**



### Method `module`

```
mixed dependencies\BaseComponent::module($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `section`

```
mixed dependencies\BaseComponent::section($section, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $section **mixed**
* $options **mixed**



### Method `table`

```
mixed dependencies\BaseComponent::table($model_name, $id)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $model_name **mixed**
* $id **mixed**



### Method `view`

```
mixed dependencies\BaseComponent::view($module_name, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseComponent](/apidocs/dependencies/BaseComponent.md)

#### Arguments

* $module_name **mixed**
* $options **mixed**



### Method `delete_menu`

```
mixed components\menu\Actions::delete_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `menu_item_delete`

```
mixed components\menu\Actions::menu_item_delete($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### Method `new_menu`

```
mixed components\menu\Actions::new_menu($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**


