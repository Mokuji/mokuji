# dependencies\Resultset






* Class name: Resultset
* Namespace: dependencies
* Parent class: [dependencies\Data](/apidocs/dependencies/Data.md)




## Class index

**Properties**
* [`private mixed $model`](#property-$model)

**Methods**
* [`public mixed __construct($result, $model)`](#method-__construct)
* [`public mixed as_hlist()`](#method-as_hlist)
* [`public mixed as_option_set($key)`](#method-as_option_set)
* [`public mixed find()`](#method-find)
* [`public mixed hdata()`](#method-hdata)
* [`public mixed hwalk($callback)`](#method-hwalk)


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


### Property `$model`

```
private mixed $model
```





* Visibility: **private**


Methods
-------


### Method `__clone`

```
mixed dependencies\Data::__clone()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `__construct`

```
mixed dependencies\Resultset::__construct($result, $model)
```





* Visibility: **public**

#### Arguments

* $result **mixed**
* $model **mixed**



### Method `__destruct`

```
mixed dependencies\Data::__destruct()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `__get`

```
mixed dependencies\Data::__get($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `__set`

```
mixed dependencies\Data::__set($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**



### Method `__toString`

```
mixed dependencies\Data::__toString()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `__unset`

```
mixed dependencies\Data::__unset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `_attempt_unserialize`

```
mixed dependencies\Data::_attempt_unserialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `_clear_context`

```
mixed dependencies\Data::_clear_context()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `_set_context`

```
mixed dependencies\Data::_set_context($context, $key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $context **mixed**
* $key **mixed**



### Method `_success`

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)



### Method `add_rules`

```
mixed dependencies\Data::add_rules()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `all`

```
mixed dependencies\Data::all($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



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



### Method `any`

```
mixed dependencies\Data::any($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



### Method `as_array`

```
mixed dependencies\Data::as_array($serialized)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $serialized **mixed**



### Method `as_hlist`

```
mixed dependencies\Resultset::as_hlist()
```





* Visibility: **public**



### Method `as_json`

```
mixed dependencies\Data::as_json($flags, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $flags **mixed**
* $options **mixed**



### Method `as_list`

```
mixed dependencies\Data::as_list()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `as_option_set`

```
mixed dependencies\Resultset::as_option_set($key)
```





* Visibility: **public**

#### Arguments

* $key **mixed**



### Method `as_options`

```
mixed dependencies\Data::as_options()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `as_rlist`

```
mixed dependencies\Data::as_rlist()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `as_table`

```
mixed dependencies\Data::as_table()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `back`

```
mixed dependencies\Data::back()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `become`

```
mixed dependencies\Data::become(\dependencies\Data $data)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $data **[dependencies\Data](/apidocs/dependencies/Data.md)**



### Method `check`

```
mixed dependencies\Data::check($node_name)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $node_name **mixed**



### Method `clear`

```
mixed dependencies\Data::clear()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `convert`

```
mixed dependencies\Data::convert()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `copy`

```
mixed dependencies\Data::copy()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `copyto`

```
mixed dependencies\Data::copyto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $to **mixed**



### Method `dump`

```
mixed dependencies\Data::dump($format, $l)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $format **mixed**
* $l **mixed**



### Method `each`

```
mixed dependencies\Data::each($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



### Method `enforce_rules`

```
mixed dependencies\Data::enforce_rules($recursive)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $recursive **mixed**



### Method `eq`

```
mixed dependencies\Data::eq($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**



### Method `extract`

```
mixed dependencies\Data::extract($id)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $id **mixed**



### Method `failure`

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $callback **mixed**



### Method `filter`

```
mixed dependencies\Data::filter($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



### Method `find`

```
mixed dependencies\Resultset::find()
```





* Visibility: **public**



### Method `format`

```
mixed dependencies\Data::format($format)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $format **mixed**



### Method `generation`

```
mixed dependencies\Data::generation()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `get`

```
mixed dependencies\Data::get($as)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $as **mixed**



### Method `getIterator`

```
mixed dependencies\Data::getIterator()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `gt`

```
mixed dependencies\Data::gt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**



### Method `having`

```
mixed dependencies\Data::having()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `hdata`

```
mixed dependencies\Resultset::hdata()
```





* Visibility: **public**



### Method `html_escape`

```
mixed dependencies\Data::html_escape($flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $flags **mixed**



### Method `hwalk`

```
mixed dependencies\Resultset::hwalk($callback)
```





* Visibility: **public**

#### Arguments

* $callback **mixed**



### Method `idx`

```
mixed dependencies\Data::idx($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `is`

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



### Method `is_childnode`

```
mixed dependencies\Data::is_childnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_empty`

```
mixed dependencies\Data::is_empty()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_false`

```
mixed dependencies\Data::is_false()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_godnode`

```
mixed dependencies\Data::is_godnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_leafnode`

```
mixed dependencies\Data::is_leafnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_numeric`

```
mixed dependencies\Data::is_numeric()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_parent`

```
mixed dependencies\Data::is_parent()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_set`

```
mixed dependencies\Data::is_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `is_true`

```
mixed dependencies\Data::is_true()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `join`

```
mixed dependencies\Data::join($separator)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $separator **mixed**



### Method `key`

```
mixed dependencies\Data::key()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `keyof`

```
mixed dependencies\Data::keyof($node)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $node **mixed**



### Method `keys`

```
mixed dependencies\Data::keys()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `ksort`

```
\dependencies\Data dependencies\Data::ksort()
```

Sorts the data object by key.



* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `lowercase`

```
mixed dependencies\Data::lowercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `lt`

```
mixed dependencies\Data::lt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**



### Method `map`

```
mixed dependencies\Data::map($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



### Method `md5`

```
mixed dependencies\Data::md5()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `merge`

```
mixed dependencies\Data::merge($val, $deep)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $val **mixed**
* $deep **mixed**



### Method `moveto`

```
mixed dependencies\Data::moveto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $to **mixed**



### Method `not`

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**



### Method `offsetExists`

```
mixed dependencies\Data::offsetExists($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `offsetGet`

```
mixed dependencies\Data::offsetGet($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `offsetSet`

```
mixed dependencies\Data::offsetSet($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**



### Method `offsetUnset`

```
mixed dependencies\Data::offsetUnset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $key **mixed**



### Method `otherwise`

```
mixed dependencies\Data::otherwise($default)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $default **mixed**



### Method `parse`

```
mixed dependencies\Data::parse($regex, $flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $regex **mixed**
* $flags **mixed**



### Method `push`

```
mixed dependencies\Data::push()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `reverse`

```
mixed dependencies\Data::reverse()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `serialize`

```
mixed dependencies\Data::serialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `serialized`

```
mixed dependencies\Data::serialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `set`

```
mixed dependencies\Data::set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `size`

```
mixed dependencies\Data::size()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `slice`

```
mixed dependencies\Data::slice($offset, $length)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $offset **mixed**
* $length **mixed**



### Method `split`

```
mixed dependencies\Data::split($s)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $s **mixed**



### Method `success`

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $callback **mixed**



### Method `trim`

```
mixed dependencies\Data::trim($charlist)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $charlist **mixed**



### Method `type`

```
mixed dependencies\Data::type()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `un_set`

```
mixed dependencies\Data::un_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `unserialize`

```
mixed dependencies\Data::unserialize($d)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $d **mixed**



### Method `unserialized`

```
mixed dependencies\Data::unserialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `uppercase`

```
mixed dependencies\Data::uppercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)



### Method `validate`

```
mixed dependencies\Data::validate($name, array $rules)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $name **mixed**
* $rules **array**



### Method `validation_errors`

```
mixed dependencies\Data::validation_errors($names)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $names **mixed**



### Method `walk`

```
mixed dependencies\Data::walk($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](/apidocs/dependencies/Data.md)

#### Arguments

* $callback **mixed**



### Method `_do_check`

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](/apidocs/dependencies/Successable.md)

#### Arguments

* $check **mixed**


