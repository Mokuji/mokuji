# exception\Validation






* Class name: Validation
* Namespace: exception
* Parent class: [exception\Expected](../exception/Expected.md)




## Class index

**Properties**
* [`protected static mixed $ex_code`](#property-ex_code)
* [`private mixed $errors`](#property-errors)
* [`private mixed $key`](#property-key)
* [`private mixed $title`](#property-title)
* [`private mixed $value`](#property-value)

**Methods**
* [`public mixed errors(array $set)`](#method-errors)
* [`public mixed key($set)`](#method-key)
* [`public mixed title($set)`](#method-title)
* [`public mixed value($set)`](#method-value)


## Inheritance index

**Properties**
* `protected mixed $prev`

**Methods**
* `public mixed __construct()`
* `public mixed getExCode()`
* `public mixed getPrev()`
* `public mixed setPrev(\exception\Exception $previous)`



Properties
----------


### Property `$ex_code`

```
protected mixed $ex_code = EX_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


### Property `$prev`

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](../exception/Exception.md)


### Property `$errors`

```
private mixed $errors = array()
```





* Visibility: **private**


### Property `$key`

```
private mixed $key
```





* Visibility: **private**


### Property `$title`

```
private mixed $title
```





* Visibility: **private**


### Property `$value`

```
private mixed $value
```





* Visibility: **private**


Methods
-------


### Method `__construct`

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



### Method `errors`

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**

#### Arguments

* $set **array**



### Method `getExCode`

```
mixed exception\Exception::getExCode()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



### Method `getPrev`

```
mixed exception\Exception::getPrev()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



### Method `key`

```
mixed exception\Validation::key($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### Method `setPrev`

```
mixed exception\Exception::setPrev(\exception\Exception $previous)
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)

#### Arguments

* $previous **[exception\Exception](../exception/Exception.md)**



### Method `title`

```
mixed exception\Validation::title($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### Method `value`

```
mixed exception\Validation::value($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**


