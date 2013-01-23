# exception\ModelValidation






* Class name: ModelValidation
* Namespace: exception
* Parent class: [exception\Validation](exception-Validation)




## Class index

**Properties**
* `protected static mixed $ex_code`
* `public mixed $errors`

**Methods**
* `public mixed add_validation_error(\exception\Validation $error)`
* `public mixed set_validation_errors($errors)`


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


### $ex_code

```
protected mixed $ex_code = EX_MODEL_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


### $errors

```
public mixed $errors = array()
```





* Visibility: **public**


### $prev

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](exception-Exception)


Methods
-------


### __construct

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](exception-Exception)



### add_validation_error

```
mixed exception\ModelValidation::add_validation_error(\exception\Validation $error)
```





* Visibility: **public**

#### Arguments

* $error **[exception\Validation](exception-Validation)**



### errors

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](exception-Validation)

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
* This method is defined by [exception\Validation](exception-Validation)

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



### set_validation_errors

```
mixed exception\ModelValidation::set_validation_errors($errors)
```





* Visibility: **public**

#### Arguments

* $errors **mixed**



### title

```
mixed exception\Validation::title($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](exception-Validation)

#### Arguments

* $set **mixed**



### value

```
mixed exception\Validation::value($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](exception-Validation)

#### Arguments

* $set **mixed**


