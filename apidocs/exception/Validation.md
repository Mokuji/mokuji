# exception\Validation
[API index](../API-index.md)






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
* [`protected mixed $prev`](#property-prev)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed getExCode()`](#method-getExCode)
* [`public mixed getPrev()`](#method-getPrev)
* [`public mixed setPrev(\exception\Exception $previous)`](#method-setPrev)



# Properties


## Property `$ex_code`
In class: [exception\Validation](#top)

```
protected mixed $ex_code = EX_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


## Property `$prev`
In class: [exception\Validation](#top)

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](../exception/Exception.md)


## Property `$errors`
In class: [exception\Validation](#top)

```
private mixed $errors = array()
```





* Visibility: **private**


## Property `$key`
In class: [exception\Validation](#top)

```
private mixed $key
```





* Visibility: **private**


## Property `$title`
In class: [exception\Validation](#top)

```
private mixed $title
```





* Visibility: **private**


## Property `$value`
In class: [exception\Validation](#top)

```
private mixed $value
```





* Visibility: **private**


# Methods


## Method `__construct`
In class: [exception\Validation](#top)

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



## Method `errors`
In class: [exception\Validation](#top)

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**

#### Arguments

* $set **array**



## Method `getExCode`
In class: [exception\Validation](#top)

```
mixed exception\Exception::getExCode()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



## Method `getPrev`
In class: [exception\Validation](#top)

```
mixed exception\Exception::getPrev()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)



## Method `key`
In class: [exception\Validation](#top)

```
mixed exception\Validation::key($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `setPrev`
In class: [exception\Validation](#top)

```
mixed exception\Exception::setPrev(\exception\Exception $previous)
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)

#### Arguments

* $previous **[exception\Exception](../exception/Exception.md)**



## Method `title`
In class: [exception\Validation](#top)

```
mixed exception\Validation::title($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `value`
In class: [exception\Validation](#top)

```
mixed exception\Validation::value($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**


