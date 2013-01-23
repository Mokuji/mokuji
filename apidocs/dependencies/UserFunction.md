# dependencies\UserFunction
[API index](../API-index.md)






* Class name: UserFunction
* Namespace: dependencies
* Parent class: [dependencies\Successable](../dependencies/Successable.md)




## Class index

**Properties**
* [`public mixed $action`](#property-action)
* [`public mixed $exception`](#property-exception)
* [`public mixed $return_value`](#property-return_value)

**Methods**
* [`public mixed __construct($action, \Closure $closure)`](#method-__construct)
* [`public mixed failure($callback)`](#method-failure)
* [`public mixed get_user_message($action)`](#method-get_user_message)


## Inheritance index


**Methods**
* [`public mixed _success()`](#method-_success)
* [`public mixed and_is($check, $callback)`](#method-and_is)
* [`public mixed and_not($check)`](#method-and_not)
* [`public mixed is($check, $callback)`](#method-is)
* [`public mixed not($check, $callback)`](#method-not)
* [`public mixed success($callback)`](#method-success)
* [`private mixed _do_check($check)`](#method-_do_check)



# Properties


## Property `$action`
In class: [dependencies\UserFunction](#top)

```
public mixed $action = 'performing an action'
```





* Visibility: **public**


## Property `$exception`
In class: [dependencies\UserFunction](#top)

```
public mixed $exception = null
```





* Visibility: **public**


## Property `$return_value`
In class: [dependencies\UserFunction](#top)

```
public mixed $return_value = null
```





* Visibility: **public**


# Methods


## Method `__construct`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\UserFunction::__construct($action, \Closure $closure)
```





* Visibility: **public**

#### Arguments

* $action **mixed**
* $closure **Closure**



## Method `_success`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)



## Method `and_is`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



## Method `and_not`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**



## Method `failure`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\UserFunction::failure($callback)
```





* Visibility: **public**

#### Arguments

* $callback **mixed**



## Method `get_user_message`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\UserFunction::get_user_message($action)
```





* Visibility: **public**

#### Arguments

* $action **mixed**



## Method `is`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



## Method `not`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



## Method `success`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**



## Method `_do_check`
In class: [dependencies\UserFunction](#top)

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**


