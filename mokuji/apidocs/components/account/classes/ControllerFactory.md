# components\account\classes\ControllerFactory
[API index](../../../API-index.md)






* Class name: ControllerFactory
* Namespace: components\account\classes




## Class index

**Properties**
* [`private static self $instance`](#property-instance)
* [`private string $componentName`](#property-componentname)
* [`private \components\account\classes\controllers\base\Controller[] $controllers`](#property-controllers)

**Methods**
* [`public static self getInstance()`](#method-getInstance)
* [`public \components\account\classes\controllers\base\Controller __call(string $key, array $params)`](#method-__call)
* [`public \components\account\classes\controllers\base\Controller __get(string $key)`](#method-__get)
* [`public \components\account\classes\controllers\base\Controller getController(string $name, boolean $forceNew, array $parameters)`](#method-getController)
* [`private mixed __construct()`](#method-__construct)







# Properties


## Property `$instance`
In class: [components\account\classes\ControllerFactory](#top)

```
private self $instance
```

Singleton container.



* Visibility: **private**
* This property is **static**.


## Property `$componentName`
In class: [components\account\classes\ControllerFactory](#top)

```
private string $componentName = 'account'
```

Contains the name of the component.



* Visibility: **private**


## Property `$controllers`
In class: [components\account\classes\ControllerFactory](#top)

```
private \components\account\classes\controllers\base\Controller[] $controllers = array()
```

The instance cache.



* Visibility: **private**


# Methods


## Method `getInstance`
In class: [components\account\classes\ControllerFactory](#top)

```
self components\account\classes\ControllerFactory::getInstance()
```

Singleton getter.



* Visibility: **public**
* This method is **static**.


#### Return value

**self** - The singleton.







## Method `__call`
In class: [components\account\classes\ControllerFactory](#top)

```
\components\account\classes\controllers\base\Controller components\account\classes\ControllerFactory::__call(string $key, array $params)
```

Forward calls to getController.



* Visibility: **public**

#### Arguments

* $key **string** - The name of the controller.
* $params **array** - The parameters for the controllers constructor.


#### Return value

**components\account\classes\controllers\base\Controller** - An instance of a controller.







## Method `__get`
In class: [components\account\classes\ControllerFactory](#top)

```
\components\account\classes\controllers\base\Controller components\account\classes\ControllerFactory::__get(string $key)
```

Redirect property gets to the getController method.



* Visibility: **public**

#### Arguments

* $key **string**


#### Return value

**components\account\classes\controllers\base\Controller** - An instance of a controller.







## Method `getController`
In class: [components\account\classes\ControllerFactory](#top)

```
\components\account\classes\controllers\base\Controller components\account\classes\ControllerFactory::getController(string $name, boolean $forceNew, array $parameters)
```

Get a controller instance from the cache.



* Visibility: **public**

#### Arguments

* $name **string** - The class name of the controller.
* $forceNew **boolean** - Create a new instance regardless of cache.
* $parameters **array** - Parameters to pass to the controller.


#### Return value

**components\account\classes\controllers\base\Controller** - An instance of a controller.







## Method `__construct`
In class: [components\account\classes\ControllerFactory](#top)

```
mixed components\account\classes\ControllerFactory::__construct()
```

Private constructor.



* Visibility: **private**





