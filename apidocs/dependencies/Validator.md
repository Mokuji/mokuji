# dependencies\Validator






* Class name: Validator
* Namespace: dependencies
* Parent class: [dependencies\Successable](/apidocs/dependencies/Successable.md)




## Class index

**Properties**
* [`private mixed $data`](#property-$data)
* [`private mixed $errors`](#property-$errors)
* [`private mixed $rules`](#property-$rules)

**Methods**
* [`public mixed __call($rule, $options)`](#method-__call)
* [`public mixed __construct($data, $rules)`](#method-__construct)
* [`public mixed _datetime($target_format)`](#method-_datetime)
* [`public mixed _gte($number)`](#method-_gte)
* [`public mixed _in()`](#method-_in)
* [`public mixed _lte($number)`](#method-_lte)
* [`public mixed _not_in()`](#method-_not_in)
* [`public mixed check_rule($certain_rule)`](#method-check_rule)
* [`public mixed errors()`](#method-errors)
* [`public mixed get_data()`](#method-get_data)
* [`public mixed validate($rules)`](#method-validate)
* [`private mixed _array()`](#method-_array)
* [`private mixed _between($min, $max)`](#method-_between)
* [`private mixed _boolean()`](#method-_boolean)
* [`private mixed _email()`](#method-_email)
* [`private mixed _eq($value)`](#method-_eq)
* [`private mixed _gt($number)`](#method-_gt)
* [`private mixed _javascript_variable_name()`](#method-_javascript_variable_name)
* [`private mixed _length($length)`](#method-_length)
* [`private mixed _lt($number)`](#method-_lt)
* [`private mixed _no_html()`](#method-_no_html)
* [`private mixed _not_empty()`](#method-_not_empty)
* [`private mixed _number($type)`](#method-_number)
* [`private mixed _password()`](#method-_password)
* [`private mixed _required()`](#method-_required)
* [`private mixed _string()`](#method-_string)
* [`private mixed _url()`](#method-_url)


## Inheritance index

**Properties**

**Methods**
* `public mixed _success()`
* `public mixed and_is($check, $callback)`
* `public mixed and_not($check)`
* `public mixed failure($callback)`
* `public mixed is($check, $callback)`
* `public mixed not($check, $callback)`
* `public mixed success($callback)`
* `private mixed _do_check($check)`



Properties
----------


### Property `$data`

```
private mixed $data = null
```





* Visibility: **private**


### Property `$errors`

```
private mixed $errors = array()
```





* Visibility: **private**


### Property `$rules`

```
private mixed $rules = array()
```





* Visibility: **private**


Methods
-------


### Method `__call`

```
mixed dependencies\Validator::__call($rule, $options)
```





* Visibility: **public**

#### Arguments

* $rule **mixed**
* $options **mixed**



### Method `__construct`

```
mixed dependencies\Validator::__construct($data, $rules)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $rules **mixed**



### Method `_datetime`

```
mixed dependencies\Validator::_datetime($target_format)
```





* Visibility: **public**

#### Arguments

* $target_format **mixed**



### Method `_gte`

```
mixed dependencies\Validator::_gte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**



### Method `_in`

```
mixed dependencies\Validator::_in()
```





* Visibility: **public**



### Method `_lte`

```
mixed dependencies\Validator::_lte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**



### Method `_not_in`

```
mixed dependencies\Validator::_not_in()
```





* Visibility: **public**



### Method `_success`

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)



### Method `and_is`

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



### Method `and_not`

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**



### Method `check_rule`

```
mixed dependencies\Validator::check_rule($certain_rule)
```





* Visibility: **public**

#### Arguments

* $certain_rule **mixed**



### Method `errors`

```
mixed dependencies\Validator::errors()
```





* Visibility: **public**



### Method `failure`

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $callback **mixed**



### Method `get_data`

```
mixed dependencies\Validator::get_data()
```





* Visibility: **public**



### Method `is`

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



### Method `not`

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



### Method `success`

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $callback **mixed**



### Method `validate`

```
mixed dependencies\Validator::validate($rules)
```





* Visibility: **public**

#### Arguments

* $rules **mixed**



### Method `_array`

```
mixed dependencies\Validator::_array()
```





* Visibility: **private**



### Method `_between`

```
mixed dependencies\Validator::_between($min, $max)
```





* Visibility: **private**

#### Arguments

* $min **mixed**
* $max **mixed**



### Method `_boolean`

```
mixed dependencies\Validator::_boolean()
```





* Visibility: **private**



### Method `_do_check`

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**



### Method `_email`

```
mixed dependencies\Validator::_email()
```





* Visibility: **private**



### Method `_eq`

```
mixed dependencies\Validator::_eq($value)
```





* Visibility: **private**

#### Arguments

* $value **mixed**



### Method `_gt`

```
mixed dependencies\Validator::_gt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**



### Method `_javascript_variable_name`

```
mixed dependencies\Validator::_javascript_variable_name()
```





* Visibility: **private**



### Method `_length`

```
mixed dependencies\Validator::_length($length)
```





* Visibility: **private**

#### Arguments

* $length **mixed**



### Method `_lt`

```
mixed dependencies\Validator::_lt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**



### Method `_no_html`

```
mixed dependencies\Validator::_no_html()
```





* Visibility: **private**



### Method `_not_empty`

```
mixed dependencies\Validator::_not_empty()
```





* Visibility: **private**



### Method `_number`

```
mixed dependencies\Validator::_number($type)
```





* Visibility: **private**

#### Arguments

* $type **mixed**



### Method `_password`

```
mixed dependencies\Validator::_password()
```





* Visibility: **private**



### Method `_required`

```
mixed dependencies\Validator::_required()
```





* Visibility: **private**



### Method `_string`

```
mixed dependencies\Validator::_string()
```





* Visibility: **private**



### Method `_url`

```
mixed dependencies\Validator::_url()
```





* Visibility: **private**


