# dependencies\Validator
[API index](../API-index.md)






* Class name: Validator
* Namespace: dependencies
* Parent class: [dependencies\Successable](../dependencies/Successable.md)




## Class index

**Properties**
* [`private mixed $data`](#property-data)
* [`private mixed $errors`](#property-errors)
* [`private mixed $rules`](#property-rules)
* [`private mixed $translate`](#property-translate)

**Methods**
* [`public mixed __call($rule, $options)`](#method-__call)
* [`public mixed __construct($data, $rules, $translate)`](#method-__construct)
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
* [`private mixed _component_name()`](#method-_component_name)
* [`private mixed _email()`](#method-_email)
* [`private mixed _eq($value)`](#method-_eq)
* [`private mixed _gt($number)`](#method-_gt)
* [`private mixed _javascript_variable_name()`](#method-_javascript_variable_name)
* [`private mixed _jid($type, $externalOnly)`](#method-_jid)
* [`private mixed _length($length)`](#method-_length)
* [`private mixed _lt($number)`](#method-_lt)
* [`private mixed _no_html()`](#method-_no_html)
* [`private mixed _not_empty()`](#method-_not_empty)
* [`private mixed _number($type)`](#method-_number)
* [`private mixed _password()`](#method-_password)
* [`private mixed _phonenumber($countrycode)`](#method-_phonenumber)
* [`private mixed _required()`](#method-_required)
* [`private mixed _string()`](#method-_string)
* [`private mixed _url($type)`](#method-_url)
* [`private mixed ctransf()`](#method-ctransf)


## Inheritance index


**Methods**
* [`public mixed _success()`](#method-_success)
* [`public mixed and_is($check, $callback)`](#method-and_is)
* [`public mixed and_not($check)`](#method-and_not)
* [`public mixed failure($callback)`](#method-failure)
* [`public mixed is($check, $callback)`](#method-is)
* [`public mixed not($check, $callback)`](#method-not)
* [`public mixed success($callback)`](#method-success)
* [`private mixed _do_check($check)`](#method-_do_check)



# Properties


## Property `$data`
In class: [dependencies\Validator](#top)

```
private mixed $data = null
```





* Visibility: **private**


## Property `$errors`
In class: [dependencies\Validator](#top)

```
private mixed $errors = array()
```





* Visibility: **private**


## Property `$rules`
In class: [dependencies\Validator](#top)

```
private mixed $rules = array()
```





* Visibility: **private**


## Property `$translate`
In class: [dependencies\Validator](#top)

```
private mixed $translate
```





* Visibility: **private**


# Methods


## Method `__call`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::__call($rule, $options)
```





* Visibility: **public**

#### Arguments

* $rule **mixed**
* $options **mixed**






## Method `__construct`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::__construct($data, $rules, $translate)
```





* Visibility: **public**

#### Arguments

* $data **mixed**
* $rules **mixed**
* $translate **mixed**






## Method `_datetime`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_datetime($target_format)
```





* Visibility: **public**

#### Arguments

* $target_format **mixed**






## Method `_gte`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_gte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**






## Method `_in`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_in()
```





* Visibility: **public**






## Method `_lte`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_lte($number)
```





* Visibility: **public**

#### Arguments

* $number **mixed**






## Method `_not_in`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_not_in()
```





* Visibility: **public**






## Method `_success`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)






## Method `and_is`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `and_not`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `check_rule`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::check_rule($certain_rule)
```





* Visibility: **public**

#### Arguments

* $certain_rule **mixed**






## Method `errors`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::errors()
```





* Visibility: **public**






## Method `failure`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `get_data`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::get_data()
```





* Visibility: **public**






## Method `is`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `not`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `success`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `validate`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::validate($rules)
```





* Visibility: **public**

#### Arguments

* $rules **mixed**






## Method `_array`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_array()
```





* Visibility: **private**






## Method `_between`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_between($min, $max)
```





* Visibility: **private**

#### Arguments

* $min **mixed**
* $max **mixed**






## Method `_boolean`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_boolean()
```





* Visibility: **private**






## Method `_component_name`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_component_name()
```





* Visibility: **private**






## Method `_do_check`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `_email`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_email()
```





* Visibility: **private**






## Method `_eq`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_eq($value)
```





* Visibility: **private**

#### Arguments

* $value **mixed**






## Method `_gt`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_gt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**






## Method `_javascript_variable_name`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_javascript_variable_name()
```





* Visibility: **private**






## Method `_jid`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_jid($type, $externalOnly)
```





* Visibility: **private**

#### Arguments

* $type **mixed**
* $externalOnly **mixed**






## Method `_length`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_length($length)
```





* Visibility: **private**

#### Arguments

* $length **mixed**






## Method `_lt`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_lt($number)
```





* Visibility: **private**

#### Arguments

* $number **mixed**






## Method `_no_html`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_no_html()
```





* Visibility: **private**






## Method `_not_empty`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_not_empty()
```





* Visibility: **private**






## Method `_number`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_number($type)
```





* Visibility: **private**

#### Arguments

* $type **mixed**






## Method `_password`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_password()
```





* Visibility: **private**






## Method `_phonenumber`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_phonenumber($countrycode)
```





* Visibility: **private**

#### Arguments

* $countrycode **mixed**






## Method `_required`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_required()
```





* Visibility: **private**






## Method `_string`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_string()
```





* Visibility: **private**






## Method `_url`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::_url($type)
```





* Visibility: **private**

#### Arguments

* $type **mixed**






## Method `ctransf`
In class: [dependencies\Validator](#top)

```
mixed dependencies\Validator::ctransf()
```





* Visibility: **private**





