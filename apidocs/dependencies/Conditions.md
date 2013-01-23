# dependencies\Conditions






* Class name: Conditions
* Namespace: dependencies




## Class index

**Properties**
* [`private mixed $conditions`](#property-conditions)
* [`private mixed $invoked`](#property-invoked)
* [`private mixed $utilized`](#property-utilized)

**Methods**
* [`public mixed __invoke()`](#method-__invoke)
* [`public mixed _get()`](#method-_get)
* [`public mixed add($id, array $args)`](#method-add)
* [`public mixed combine($id, array $ids, $connector)`](#method-combine)
* [`public mixed utilize()`](#method-utilize)
* [`private mixed to_array($array)`](#method-to_array)







Properties
----------


### Property `$conditions`

```
private mixed $conditions = array()
```





* Visibility: **private**


### Property `$invoked`

```
private mixed $invoked = array()
```





* Visibility: **private**


### Property `$utilized`

```
private mixed $utilized = array()
```





* Visibility: **private**


Methods
-------


### Method `__invoke`

```
mixed dependencies\Conditions::__invoke()
```





* Visibility: **public**



### Method `_get`

```
mixed dependencies\Conditions::_get()
```





* Visibility: **public**



### Method `add`

```
mixed dependencies\Conditions::add($id, array $args)
```





* Visibility: **public**

#### Arguments

* $id **mixed**
* $args **array**



### Method `combine`

```
mixed dependencies\Conditions::combine($id, array $ids, $connector)
```





* Visibility: **public**

#### Arguments

* $id **mixed**
* $ids **array**
* $connector **mixed**



### Method `utilize`

```
mixed dependencies\Conditions::utilize()
```





* Visibility: **public**



### Method `to_array`

```
mixed dependencies\Conditions::to_array($array)
```





* Visibility: **private**

#### Arguments

* $array **mixed**


