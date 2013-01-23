# dependencies\UserFunction






* Class name: UserFunction
* Namespace: dependencies
* Parent class: [dependencies\Successable](dependencies-Successable)




## Class index

**Properties**
* `public mixed $action`
* `public mixed $exception`
* `public mixed $return_value`

**Methods**
* `public mixed __construct($action, \Closure $closure)`
* `public mixed failure($callback)`
* `public mixed get_user_message($action)`


## Inheritance index

**Properties**

**Methods**
* `public mixed _success()`
* `public mixed and_is($check, $callback)`
* `public mixed and_not($check)`
* `public mixed is($check, $callback)`
* `public mixed not($check, $callback)`
* `public mixed success($callback)`
* `private mixed _do_check($check)`



Properties
----------


### $action

```
public mixed $action = 'performing an action'
```





* Visibility: **public**


### $exception

```
public mixed $exception = null
```





* Visibility: **public**


### $return_value

```
public mixed $return_value = null
```





* Visibility: **public**


Methods
-------


### __construct

```
mixed dependencies\UserFunction::__construct($action, \Closure $closure)
```





* Visibility: **public**

#### Arguments

* $action **mixed**
* $closure **Closure**



### _success

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)



### and_is

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### and_not

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**



### failure

```
mixed dependencies\UserFunction::failure($callback)
```





* Visibility: **public**

#### Arguments

* $callback **mixed**



### get_user_message

```
mixed dependencies\UserFunction::get_user_message($action)
```





* Visibility: **public**

#### Arguments

* $action **mixed**



### is

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### not

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### success

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $callback **mixed**



### _do_check

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**


