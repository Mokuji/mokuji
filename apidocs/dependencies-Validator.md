# dependencies\Validator






* Class name: Validator
* Namespace: dependencies
* Parent class: [dependencies\Successable](dependencies-Successable)




## Class index

**Properties**
* `private mixed $data`
* `private mixed $errors`
* `private mixed $rules`

**Methods**
* `public mixed __call($rule, $options)`
* `public mixed __construct($data, $rules)`
* `public mixed _datetime($target_format)`
* `public mixed _gte($number)`
* `public mixed _in()`
* `public mixed _lte($number)`
* `public mixed _not_in()`
* `public mixed check_rule($certain_rule)`
* `public mixed errors()`
* `public mixed get_data()`
* `public mixed validate($rules)`
* `private mixed _array()`
* `private mixed _between($min, $max)`
* `private mixed _boolean()`
* `private mixed _email()`
* `private mixed _eq($value)`
* `private mixed _gt($number)`
* `private mixed _javascript_variable_name()`
* `private mixed _length($length)`
* `private mixed _lt($number)`
* `private mixed _no_html()`
* `private mixed _not_empty()`
* `private mixed _number($type)`
* `private mixed _password()`
* `private mixed _required()`
* `private mixed _string()`
* `private mixed _url()`


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


### $data

```
private mixed $data = null
```





* Visibility: **private**


### $errors

```
private mixed $errors = array()
```





* Visibility: **private**


### $rules

```
private mixed $rules = array()
```





* Visibility: **private**


Methods
-------


### __call

```
mixed dependencies\Validator::__call($rule, $options)
```





* Visibility: **public**

#### Arguments

* $rule **mixed**
* $options **mixed**



### __construct

```
mixed dependencies\Validator::__construct($data, $rules)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $rules **mixed**



### _datetime

```
mixed dependencies\Validator::_datetime($target_format)
```





* Visibility: **public**

#### Arguments

* $target_format **mixed**



### _gte

```
mixed dependencies\Validator::_gte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**



### _in

```
mixed dependencies\Validator::_in()
```





* Visibility: **public**



### _lte

```
mixed dependencies\Validator::_lte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**



### _not_in

```
mixed dependencies\Validator::_not_in()
```





* Visibility: **public**



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



### check_rule

```
mixed dependencies\Validator::check_rule($certain_rule)
```





* Visibility: **public**

#### Arguments

* $certain_rule **mixed**



### errors

```
mixed dependencies\Validator::errors()
```





* Visibility: **public**



### failure

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $callback **mixed**



### get_data

```
mixed dependencies\Validator::get_data()
```





* Visibility: **public**



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



### validate

```
mixed dependencies\Validator::validate($rules)
```





* Visibility: **public**

#### Arguments

* $rules **mixed**



### _array

```
mixed dependencies\Validator::_array()
```





* Visibility: **private**



### _between

```
mixed dependencies\Validator::_between($min, $max)
```





* Visibility: **private**

#### Arguments

* $min **mixed**
* $max **mixed**



### _boolean

```
mixed dependencies\Validator::_boolean()
```





* Visibility: **private**



### _do_check

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**



### _email

```
mixed dependencies\Validator::_email()
```





* Visibility: **private**



### _eq

```
mixed dependencies\Validator::_eq($value)
```





* Visibility: **private**

#### Arguments

* $value **mixed**



### _gt

```
mixed dependencies\Validator::_gt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**



### _javascript_variable_name

```
mixed dependencies\Validator::_javascript_variable_name()
```





* Visibility: **private**



### _length

```
mixed dependencies\Validator::_length($length)
```





* Visibility: **private**

#### Arguments

* $length **mixed**



### _lt

```
mixed dependencies\Validator::_lt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**



### _no_html

```
mixed dependencies\Validator::_no_html()
```





* Visibility: **private**



### _not_empty

```
mixed dependencies\Validator::_not_empty()
```





* Visibility: **private**



### _number

```
mixed dependencies\Validator::_number($type)
```





* Visibility: **private**

#### Arguments

* $type **mixed**



### _password

```
mixed dependencies\Validator::_password()
```





* Visibility: **private**



### _required

```
mixed dependencies\Validator::_required()
```





* Visibility: **private**



### _string

```
mixed dependencies\Validator::_string()
```





* Visibility: **private**



### _url

```
mixed dependencies\Validator::_url()
```





* Visibility: **private**


