# exception\Validation






* Class name: Validation
* Namespace: exception
* Parent class: [exception\Expected](exception-Expected)




## Class index

**Properties**
* `protected static mixed $ex_code`
* `private mixed $errors`
* `private mixed $key`
* `private mixed $title`
* `private mixed $value`

**Methods**
* `public mixed errors(array $set)`
* `public mixed key($set)`
* `public mixed title($set)`
* `public mixed value($set)`


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


### $ex_code

```
protected mixed $ex_code = EX_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


### $prev

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](exception-Exception)


### $errors

```
private mixed $errors = array()
```





* Visibility: **private**


### $key

```
private mixed $key
```





* Visibility: **private**


### $title

```
private mixed $title
```





* Visibility: **private**


### $value

```
private mixed $value
```





* Visibility: **private**


Methods
-------


### __construct

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](exception-Exception)



### errors

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**

#### Arguments

* $set **array**



### getExCode

```
mixed exception\Exception::getExCode()
```





* Visibility: **public**
* This method is defined by [exception\Exception](exception-Exception)



### getPrev

```
mixed exception\Exception::getPrev()
```





* Visibility: **public**
* This method is defined by [exception\Exception](exception-Exception)



### key

```
mixed exception\Validation::key($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### setPrev

```
mixed exception\Exception::setPrev(\exception\Exception $previous)
```





* Visibility: **public**
* This method is defined by [exception\Exception](exception-Exception)

#### Arguments

* $previous **[exception\Exception](exception-Exception)**



### title

```
mixed exception\Validation::title($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### value

```
mixed exception\Validation::value($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**


