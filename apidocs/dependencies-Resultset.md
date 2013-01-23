# dependencies\Resultset






* Class name: Resultset
* Namespace: dependencies
* Parent class: [dependencies\Data](dependencies-Data)




## Class index

**Properties**
* `private mixed $model`

**Methods**
* `public mixed __construct($result, $model)`
* `public mixed as_hlist()`
* `public mixed as_option_set($key)`
* `public mixed find()`
* `public mixed hdata()`
* `public mixed hwalk($callback)`


## Inheritance index

**Properties**

**Methods**
* `public mixed __clone()`
* `public mixed __destruct()`
* `public mixed __get($key)`
* `public mixed __set($key, $val)`
* `public mixed __toString()`
* `public mixed __unset($key)`
* `public mixed _attempt_unserialize()`
* `public mixed _clear_context()`
* `public mixed _set_context($context, $key)`
* `public mixed _success()`
* `public mixed add_rules()`
* `public mixed all($callback)`
* `public mixed and_is($check, $callback)`
* `public mixed and_not($check)`
* `public mixed any($callback)`
* `public mixed as_array($serialized)`
* `public mixed as_json($flags, $options)`
* `public mixed as_list()`
* `public mixed as_options()`
* `public mixed as_rlist()`
* `public mixed as_table()`
* `public mixed back()`
* `public mixed become(\dependencies\Data $data)`
* `public mixed check($node_name)`
* `public mixed clear()`
* `public mixed convert()`
* `public mixed copy()`
* `public mixed copyto($to)`
* `public mixed dump($format, $l)`
* `public mixed each($callback)`
* `public mixed enforce_rules($recursive)`
* `public mixed eq($value, $callback)`
* `public mixed extract($id)`
* `public mixed failure($callback)`
* `public mixed filter($callback)`
* `public mixed format($format)`
* `public mixed generation()`
* `public mixed get($as)`
* `public mixed getIterator()`
* `public mixed gt($value, $callback)`
* `public mixed having()`
* `public mixed html_escape($flags)`
* `public mixed idx($key)`
* `public mixed is($check, $callback)`
* `public mixed is_childnode()`
* `public mixed is_empty()`
* `public mixed is_false()`
* `public mixed is_godnode()`
* `public mixed is_leafnode()`
* `public mixed is_numeric()`
* `public mixed is_parent()`
* `public mixed is_set()`
* `public mixed is_true()`
* `public mixed join($separator)`
* `public mixed key()`
* `public mixed keyof($node)`
* `public mixed keys()`
* `public \dependencies\Data ksort()`
* `public mixed lowercase()`
* `public mixed lt($value, $callback)`
* `public mixed map($callback)`
* `public mixed md5()`
* `public mixed merge($val, $deep)`
* `public mixed moveto($to)`
* `public mixed not($check, $callback)`
* `public mixed offsetExists($key)`
* `public mixed offsetGet($key)`
* `public mixed offsetSet($key, $val)`
* `public mixed offsetUnset($key)`
* `public mixed otherwise($default)`
* `public mixed parse($regex, $flags)`
* `public mixed push()`
* `public mixed reverse()`
* `public mixed serialize()`
* `public mixed serialized()`
* `public mixed set()`
* `public mixed size()`
* `public mixed slice($offset, $length)`
* `public mixed split($s)`
* `public mixed success($callback)`
* `public mixed trim($charlist)`
* `public mixed type()`
* `public mixed un_set()`
* `public mixed unserialize($d)`
* `public mixed unserialized()`
* `public mixed uppercase()`
* `public mixed validate($name, array $rules)`
* `public mixed validation_errors($names)`
* `public mixed walk($callback)`
* `private mixed _do_check($check)`



Properties
----------


### $model

```
private mixed $model
```





* Visibility: **private**


Methods
-------


### __clone

```
mixed dependencies\Data::__clone()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### __construct

```
mixed dependencies\Resultset::__construct($result, $model)
```





* Visibility: **public**

#### Arguments

* $result **mixed**
* $model **mixed**



### __destruct

```
mixed dependencies\Data::__destruct()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### __get

```
mixed dependencies\Data::__get($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### __set

```
mixed dependencies\Data::__set($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**
* $val **mixed**



### __toString

```
mixed dependencies\Data::__toString()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### __unset

```
mixed dependencies\Data::__unset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### _attempt_unserialize

```
mixed dependencies\Data::_attempt_unserialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### _clear_context

```
mixed dependencies\Data::_clear_context()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### _set_context

```
mixed dependencies\Data::_set_context($context, $key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $context **mixed**
* $key **mixed**



### _success

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)



### add_rules

```
mixed dependencies\Data::add_rules()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### all

```
mixed dependencies\Data::all($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



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



### any

```
mixed dependencies\Data::any($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



### as_array

```
mixed dependencies\Data::as_array($serialized)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $serialized **mixed**



### as_hlist

```
mixed dependencies\Resultset::as_hlist()
```





* Visibility: **public**



### as_json

```
mixed dependencies\Data::as_json($flags, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $flags **mixed**
* $options **mixed**



### as_list

```
mixed dependencies\Data::as_list()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### as_option_set

```
mixed dependencies\Resultset::as_option_set($key)
```





* Visibility: **public**

#### Arguments

* $key **mixed**



### as_options

```
mixed dependencies\Data::as_options()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### as_rlist

```
mixed dependencies\Data::as_rlist()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### as_table

```
mixed dependencies\Data::as_table()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### back

```
mixed dependencies\Data::back()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### become

```
mixed dependencies\Data::become(\dependencies\Data $data)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $data **[dependencies\Data](dependencies-Data)**



### check

```
mixed dependencies\Data::check($node_name)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $node_name **mixed**



### clear

```
mixed dependencies\Data::clear()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### convert

```
mixed dependencies\Data::convert()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### copy

```
mixed dependencies\Data::copy()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### copyto

```
mixed dependencies\Data::copyto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $to **mixed**



### dump

```
mixed dependencies\Data::dump($format, $l)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $format **mixed**
* $l **mixed**



### each

```
mixed dependencies\Data::each($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



### enforce_rules

```
mixed dependencies\Data::enforce_rules($recursive)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $recursive **mixed**



### eq

```
mixed dependencies\Data::eq($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $value **mixed**
* $callback **mixed**



### extract

```
mixed dependencies\Data::extract($id)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $id **mixed**



### failure

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $callback **mixed**



### filter

```
mixed dependencies\Data::filter($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



### find

```
mixed dependencies\Resultset::find()
```





* Visibility: **public**



### format

```
mixed dependencies\Data::format($format)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $format **mixed**



### generation

```
mixed dependencies\Data::generation()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### get

```
mixed dependencies\Data::get($as)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $as **mixed**



### getIterator

```
mixed dependencies\Data::getIterator()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### gt

```
mixed dependencies\Data::gt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $value **mixed**
* $callback **mixed**



### having

```
mixed dependencies\Data::having()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### hdata

```
mixed dependencies\Resultset::hdata()
```





* Visibility: **public**



### html_escape

```
mixed dependencies\Data::html_escape($flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $flags **mixed**



### hwalk

```
mixed dependencies\Resultset::hwalk($callback)
```





* Visibility: **public**

#### Arguments

* $callback **mixed**



### idx

```
mixed dependencies\Data::idx($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### is

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### is_childnode

```
mixed dependencies\Data::is_childnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_empty

```
mixed dependencies\Data::is_empty()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_false

```
mixed dependencies\Data::is_false()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_godnode

```
mixed dependencies\Data::is_godnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_leafnode

```
mixed dependencies\Data::is_leafnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_numeric

```
mixed dependencies\Data::is_numeric()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_parent

```
mixed dependencies\Data::is_parent()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_set

```
mixed dependencies\Data::is_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### is_true

```
mixed dependencies\Data::is_true()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### join

```
mixed dependencies\Data::join($separator)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $separator **mixed**



### key

```
mixed dependencies\Data::key()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### keyof

```
mixed dependencies\Data::keyof($node)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $node **mixed**



### keys

```
mixed dependencies\Data::keys()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### ksort

```
\dependencies\Data dependencies\Data::ksort()
```

Sorts the data object by key.



* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### lowercase

```
mixed dependencies\Data::lowercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### lt

```
mixed dependencies\Data::lt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $value **mixed**
* $callback **mixed**



### map

```
mixed dependencies\Data::map($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



### md5

```
mixed dependencies\Data::md5()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### merge

```
mixed dependencies\Data::merge($val, $deep)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $val **mixed**
* $deep **mixed**



### moveto

```
mixed dependencies\Data::moveto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $to **mixed**



### not

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### offsetExists

```
mixed dependencies\Data::offsetExists($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### offsetGet

```
mixed dependencies\Data::offsetGet($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### offsetSet

```
mixed dependencies\Data::offsetSet($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**
* $val **mixed**



### offsetUnset

```
mixed dependencies\Data::offsetUnset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $key **mixed**



### otherwise

```
mixed dependencies\Data::otherwise($default)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $default **mixed**



### parse

```
mixed dependencies\Data::parse($regex, $flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $regex **mixed**
* $flags **mixed**



### push

```
mixed dependencies\Data::push()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### reverse

```
mixed dependencies\Data::reverse()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### serialize

```
mixed dependencies\Data::serialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### serialized

```
mixed dependencies\Data::serialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### set

```
mixed dependencies\Data::set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### size

```
mixed dependencies\Data::size()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### slice

```
mixed dependencies\Data::slice($offset, $length)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $offset **mixed**
* $length **mixed**



### split

```
mixed dependencies\Data::split($s)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $s **mixed**



### success

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $callback **mixed**



### trim

```
mixed dependencies\Data::trim($charlist)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $charlist **mixed**



### type

```
mixed dependencies\Data::type()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### un_set

```
mixed dependencies\Data::un_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### unserialize

```
mixed dependencies\Data::unserialize($d)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $d **mixed**



### unserialized

```
mixed dependencies\Data::unserialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### uppercase

```
mixed dependencies\Data::uppercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### validate

```
mixed dependencies\Data::validate($name, array $rules)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $name **mixed**
* $rules **array**



### validation_errors

```
mixed dependencies\Data::validation_errors($names)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $names **mixed**



### walk

```
mixed dependencies\Data::walk($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $callback **mixed**



### _do_check

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**


