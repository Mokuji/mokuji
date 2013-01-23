# dependencies\Conditions






* Class name: Conditions
* Namespace: dependencies




## Class index

**Properties**
* `private mixed $conditions`
* `private mixed $invoked`
* `private mixed $utilized`

**Methods**
* `public mixed __invoke()`
* `public mixed _get()`
* `public mixed add($id, array $args)`
* `public mixed combine($id, array $ids, $connector)`
* `public mixed utilize()`
* `private mixed to_array($array)`







Properties
----------


### $conditions

```
private mixed $conditions = array()
```





* Visibility: **private**


### $invoked

```
private mixed $invoked = array()
```





* Visibility: **private**


### $utilized

```
private mixed $utilized = array()
```





* Visibility: **private**


Methods
-------


### __invoke

```
mixed dependencies\Conditions::__invoke()
```





* Visibility: **public**



### _get

```
mixed dependencies\Conditions::_get()
```





* Visibility: **public**



### add

```
mixed dependencies\Conditions::add($id, array $args)
```





* Visibility: **public**

#### Arguments

* $id **mixed**
* $args **array**



### combine

```
mixed dependencies\Conditions::combine($id, array $ids, $connector)
```





* Visibility: **public**

#### Arguments

* $id **mixed**
* $ids **array**
* $connector **mixed**



### utilize

```
mixed dependencies\Conditions::utilize()
```





* Visibility: **public**



### to_array

```
mixed dependencies\Conditions::to_array($array)
```





* Visibility: **private**

#### Arguments

* $array **mixed**


