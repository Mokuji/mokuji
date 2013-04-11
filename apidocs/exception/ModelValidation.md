# exception\ModelValidation
[API index](../API-index.md)






* Class name: ModelValidation
* Namespace: exception
* Parent class: [exception\Validation](../exception/Validation.md)




## Class index

**Properties**
* [`protected static mixed $ex_code`](#property-ex_code)
* [`public mixed $errors`](#property-errors)

**Methods**
* [`public mixed add_validation_error(\exception\Validation $error)`](#method-add_validation_error)
* [`public mixed set_validation_errors($errors)`](#method-set_validation_errors)


## Inheritance index

**Properties**
* [`protected mixed $prev`](#property-prev)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed errors(array $set)`](#method-errors)
* [`public mixed getExCode()`](#method-getExCode)
* [`public mixed getPrev()`](#method-getPrev)
* [`public mixed key($set)`](#method-key)
* [`public mixed setPrev(\exception\Exception $previous)`](#method-setPrev)
* [`public mixed title($set)`](#method-title)
* [`public mixed value($set)`](#method-value)



# Properties


## Property `$ex_code`
In class: [exception\ModelValidation](#top)

```
protected mixed $ex_code = EX_MODEL_VALIDATION
```





* Visibility: **protected**
* This property is **static**.


## Property `$errors`
In class: [exception\ModelValidation](#top)

```
public mixed $errors = array()
```





* Visibility: **public**


## Property `$prev`
In class: [exception\ModelValidation](#top)

```
protected mixed $prev
```





* Visibility: **protected**
* This property is defined by [exception\Exception](../exception/Exception.md)


# Methods


## Method `__construct`
In class: [exception\ModelValidation](#top)

```
mixed exception\Exception::__construct()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)






## Method `add_validation_error`
In class: [exception\ModelValidation](#top)

```
mixed exception\ModelValidation::add_validation_error(\exception\Validation $error)
```





* Visibility: **public**

#### Arguments

* $error **[exception\Validation](../exception/Validation.md)**






## Method `errors`
In class: [exception\ModelValidation](#top)

```
mixed exception\Validation::errors(array $set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](../exception/Validation.md)

#### Arguments

* $set **array**






## Method `getExCode`
In class: [exception\ModelValidation](#top)

```
mixed exception\Exception::getExCode()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)






## Method `getPrev`
In class: [exception\ModelValidation](#top)

```
mixed exception\Exception::getPrev()
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)






## Method `key`
In class: [exception\ModelValidation](#top)

```
mixed exception\Validation::key($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](../exception/Validation.md)

#### Arguments

* $set **mixed**






## Method `setPrev`
In class: [exception\ModelValidation](#top)

```
mixed exception\Exception::setPrev(\exception\Exception $previous)
```





* Visibility: **public**
* This method is defined by [exception\Exception](../exception/Exception.md)

#### Arguments

* $previous **[exception\Exception](../exception/Exception.md)**






## Method `set_validation_errors`
In class: [exception\ModelValidation](#top)

```
mixed exception\ModelValidation::set_validation_errors($errors)
```





* Visibility: **public**

#### Arguments

* $errors **mixed**






## Method `title`
In class: [exception\ModelValidation](#top)

```
mixed exception\Validation::title($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](../exception/Validation.md)

#### Arguments

* $set **mixed**






## Method `value`
In class: [exception\ModelValidation](#top)

```
mixed exception\Validation::value($set)
```





* Visibility: **public**
* This method is defined by [exception\Validation](../exception/Validation.md)

#### Arguments

* $set **mixed**





