# exception\ModelValidation






* Class name: ModelValidation
* Namespace: exception
* Parent class: [exception\Validation](/apidocs/exception/Validation.md)




## Class index

**Properties**
* [`protected static mixed $ex_code`](#property-$ex_code)
* [`public mixed $errors`](#property-$errors)

**Methods**
* [`public mixed add_validation_error(\exception\Validation $error)`](#method-add_validation_error)
* [`public mixed set_validation_errors($errors)`](#method-set_validation_errors)


## Inheritance index

**Properties**
* `protected mixed $prev`

**Methods**
* `public mixed __construct()`
* `public mixed errors(array $set)`
* `public mixed getExCode()`
* `public mixed getPrev()`
* `public mixed key($set)`
* `public mixed setPrev(\exception\Exception $previous)`
* `public mixed title($set)`
* `public mixed value($set)`



Properties
----------


### Property `$ex_code`

```
protected mixed $ex_code = EX_MODEL_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


### Property `$errors`

```
public mixed $errors = array()
```





* Visibility: **public**


### Property `$prev`

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](/apidocs/exception/Exception.md)


Methods
-------


### Method `__construct`

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](/apidocs/exception/Exception.md)



### Method `add_validation_error`

```
mixed exception\ModelValidation::add_validation_error(\exception\Validation $error)
```





* Visibility: **public**

#### Arguments

* $error **[exception\Validation](/apidocs/exception/Validation.md)**



### Method `errors`

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](/apidocs/exception/Validation.md)

#### Arguments

* $set **array**



### Method `getExCode`

```
mixed exception\Exception::getExCode()
```





* Visibility: **public**
* This method is defined by [exception\Exception](/apidocs/exception/Exception.md)



### Method `getPrev`

```
mixed exception\Exception::getPrev()
```





* Visibility: **public**
* This method is defined by [exception\Exception](/apidocs/exception/Exception.md)



### Method `key`

```
mixed exception\Validation::key($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](/apidocs/exception/Validation.md)

#### Arguments

* $set **mixed**



### Method `setPrev`

```
mixed exception\Exception::setPrev(\exception\Exception $previous)
```





* Visibility: **public**
* This method is defined by [exception\Exception](/apidocs/exception/Exception.md)

#### Arguments

* $previous **[exception\Exception](/apidocs/exception/Exception.md)**



### Method `set_validation_errors`

```
mixed exception\ModelValidation::set_validation_errors($errors)
```





* Visibility: **public**

#### Arguments

* $errors **mixed**



### Method `title`

```
mixed exception\Validation::title($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](/apidocs/exception/Validation.md)

#### Arguments

* $set **mixed**



### Method `value`

```
mixed exception\Validation::value($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](/apidocs/exception/Validation.md)

#### Arguments

* $set **mixed**


