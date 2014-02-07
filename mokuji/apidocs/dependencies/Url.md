# dependencies\Url
[API index](../API-index.md)






* Class name: Url
* Namespace: dependencies
* Parent class: [dependencies\Data](../dependencies/Data.md)




## Class index


**Methods**
* [`public mixed __construct($url, array $options)`](#method-__construct)
* [`public mixed __toString()`](#method-__toString)
* [`public mixed compare(\dependencies\Url $url)`](#method-compare)
* [`public mixed rebuild_output()`](#method-rebuild_output)
* [`private mixed _build_url($string, array $options)`](#method-_build_url)


## Inheritance index


**Methods**
* [`public mixed __clone()`](#method-__clone)
* [`public mixed __destruct()`](#method-__destruct)
* [`public mixed __get($key)`](#method-__get)
* [`public mixed __set($key, $val)`](#method-__set)
* [`public mixed __unset($key)`](#method-__unset)
* [`public mixed _attempt_unserialize()`](#method-_attempt_unserialize)
* [`public mixed _clear_context()`](#method-_clear_context)
* [`public mixed _set_context($context, $key)`](#method-_set_context)
* [`public mixed _success()`](#method-_success)
* [`public mixed add_rules()`](#method-add_rules)
* [`public mixed all($callback)`](#method-all)
* [`public mixed and_is($check, $callback)`](#method-and_is)
* [`public mixed and_not($check)`](#method-and_not)
* [`public mixed any($callback)`](#method-any)
* [`public mixed as_array($serialized, $unset_as_null)`](#method-as_array)
* [`public mixed as_json($flags, $options)`](#method-as_json)
* [`public mixed as_list()`](#method-as_list)
* [`public mixed as_options()`](#method-as_options)
* [`public mixed as_rlist()`](#method-as_rlist)
* [`public mixed as_table()`](#method-as_table)
* [`public mixed back()`](#method-back)
* [`public mixed become(\dependencies\Data $data)`](#method-become)
* [`public mixed check($node_name)`](#method-check)
* [`public mixed clear()`](#method-clear)
* [`public mixed convert()`](#method-convert)
* [`public mixed copy()`](#method-copy)
* [`public mixed copyto($to)`](#method-copyto)
* [`public mixed dump($format, $l)`](#method-dump)
* [`public mixed each($callback)`](#method-each)
* [`public mixed enforce_rules($recursive)`](#method-enforce_rules)
* [`public mixed eq($value, $callback)`](#method-eq)
* [`public mixed extract($id)`](#method-extract)
* [`public mixed failure($callback)`](#method-failure)
* [`public mixed filter($callback)`](#method-filter)
* [`public mixed format($format)`](#method-format)
* [`public mixed generation()`](#method-generation)
* [`public mixed get($as)`](#method-get)
* [`public mixed getIterator()`](#method-getIterator)
* [`public mixed gt($value, $callback)`](#method-gt)
* [`public mixed having()`](#method-having)
* [`public mixed html_escape($flags)`](#method-html_escape)
* [`public mixed idx($key)`](#method-idx)
* [`public mixed is($check, $callback)`](#method-is)
* [`public mixed is_childnode()`](#method-is_childnode)
* [`public mixed is_empty()`](#method-is_empty)
* [`public mixed is_false()`](#method-is_false)
* [`public mixed is_godnode()`](#method-is_godnode)
* [`public mixed is_leafnode()`](#method-is_leafnode)
* [`public mixed is_numeric()`](#method-is_numeric)
* [`public mixed is_parent()`](#method-is_parent)
* [`public mixed is_set()`](#method-is_set)
* [`public mixed is_true()`](#method-is_true)
* [`public mixed join($separator)`](#method-join)
* [`public mixed key()`](#method-key)
* [`public mixed keyof($node)`](#method-keyof)
* [`public mixed keys()`](#method-keys)
* [`public \dependencies\Data ksort()`](#method-ksort)
* [`public mixed lowercase()`](#method-lowercase)
* [`public mixed lt($value, $callback)`](#method-lt)
* [`public mixed map($callback)`](#method-map)
* [`public mixed md5()`](#method-md5)
* [`public mixed merge($val, $deep)`](#method-merge)
* [`public mixed moveto($to)`](#method-moveto)
* [`public mixed not($check, $callback)`](#method-not)
* [`public mixed offsetExists($key)`](#method-offsetExists)
* [`public mixed offsetGet($key)`](#method-offsetGet)
* [`public mixed offsetSet($key, $val)`](#method-offsetSet)
* [`public mixed offsetUnset($key)`](#method-offsetUnset)
* [`public mixed otherwise($default)`](#method-otherwise)
* [`public mixed parse($regex, $flags)`](#method-parse)
* [`public mixed push()`](#method-push)
* [`public mixed reverse()`](#method-reverse)
* [`public mixed serialize()`](#method-serialize)
* [`public mixed serialized()`](#method-serialized)
* [`public mixed set()`](#method-set)
* [`public mixed size()`](#method-size)
* [`public mixed slice($offset, $length)`](#method-slice)
* [`public mixed split($s)`](#method-split)
* [`public mixed success($callback)`](#method-success)
* [`public mixed trim($charlist)`](#method-trim)
* [`public mixed type()`](#method-type)
* [`public mixed un_set()`](#method-un_set)
* [`public mixed unserialize($d)`](#method-unserialize)
* [`public mixed unserialized()`](#method-unserialized)
* [`public mixed uppercase()`](#method-uppercase)
* [`public mixed validate($name, array $rules, $translate)`](#method-validate)
* [`public mixed validation_errors($names)`](#method-validation_errors)
* [`public mixed walk($callback)`](#method-walk)
* [`public mixed without()`](#method-without)
* [`private mixed _do_check($check)`](#method-_do_check)





# Methods


## Method `__clone`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::__clone()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `__construct`
In class: [dependencies\Url](#top)

```
mixed dependencies\Url::__construct($url, array $options)
```





* Visibility: **public**

#### Arguments

* $url **mixed**
* $options **array**






## Method `__destruct`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::__destruct()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `__get`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::__get($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `__set`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::__set($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**






## Method `__toString`
In class: [dependencies\Url](#top)

```
mixed dependencies\Url::__toString()
```





* Visibility: **public**






## Method `__unset`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::__unset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `_attempt_unserialize`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::_attempt_unserialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `_clear_context`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::_clear_context()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `_set_context`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::_set_context($context, $key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $context **mixed**
* $key **mixed**






## Method `_success`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)






## Method `add_rules`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::add_rules()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `all`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::all($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `and_is`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `and_not`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `any`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::any($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `as_array`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_array($serialized, $unset_as_null)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $serialized **mixed**
* $unset_as_null **mixed**






## Method `as_json`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_json($flags, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $flags **mixed**
* $options **mixed**






## Method `as_list`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_list()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `as_options`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_options()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `as_rlist`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_rlist()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `as_table`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::as_table()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `back`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::back()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `become`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::become(\dependencies\Data $data)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $data **[dependencies\Data](../dependencies/Data.md)**






## Method `check`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::check($node_name)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $node_name **mixed**






## Method `clear`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::clear()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `compare`
In class: [dependencies\Url](#top)

```
mixed dependencies\Url::compare(\dependencies\Url $url)
```





* Visibility: **public**

#### Arguments

* $url **[dependencies\Url](../dependencies/Url.md)**






## Method `convert`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::convert()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `copy`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::copy()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `copyto`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::copyto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $to **mixed**






## Method `dump`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::dump($format, $l)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $format **mixed**
* $l **mixed**






## Method `each`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::each($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `enforce_rules`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::enforce_rules($recursive)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $recursive **mixed**






## Method `eq`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::eq($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `extract`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::extract($id)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $id **mixed**






## Method `failure`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `filter`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::filter($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `format`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::format($format)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $format **mixed**






## Method `generation`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::generation()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `get`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::get($as)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $as **mixed**






## Method `getIterator`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::getIterator()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `gt`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::gt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `having`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::having()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `html_escape`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::html_escape($flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $flags **mixed**






## Method `idx`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::idx($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `is`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `is_childnode`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_childnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_empty`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_empty()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_false`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_false()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_godnode`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_godnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_leafnode`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_leafnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_numeric`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_numeric()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_parent`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_parent()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_set`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `is_true`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::is_true()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `join`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::join($separator)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $separator **mixed**






## Method `key`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::key()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `keyof`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::keyof($node)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $node **mixed**






## Method `keys`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::keys()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `ksort`
In class: [dependencies\Url](#top)

```
\dependencies\Data dependencies\Data::ksort()
```

Sorts the data object by key.



* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)


#### Return value

**[dependencies\Data](../dependencies/Data.md)** - Returns $this







## Method `lowercase`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::lowercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `lt`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::lt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `map`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::map($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `md5`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::md5()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `merge`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::merge($val, $deep)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $val **mixed**
* $deep **mixed**






## Method `moveto`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::moveto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $to **mixed**






## Method `not`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `offsetExists`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::offsetExists($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `offsetGet`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::offsetGet($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `offsetSet`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::offsetSet($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**






## Method `offsetUnset`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::offsetUnset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `otherwise`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::otherwise($default)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $default **mixed**






## Method `parse`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::parse($regex, $flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $regex **mixed**
* $flags **mixed**






## Method `push`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::push()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `rebuild_output`
In class: [dependencies\Url](#top)

```
mixed dependencies\Url::rebuild_output()
```





* Visibility: **public**






## Method `reverse`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::reverse()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `serialize`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::serialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `serialized`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::serialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `set`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `size`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::size()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `slice`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::slice($offset, $length)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $offset **mixed**
* $length **mixed**






## Method `split`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::split($s)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $s **mixed**






## Method `success`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `trim`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::trim($charlist)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $charlist **mixed**






## Method `type`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::type()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `un_set`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::un_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `unserialize`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::unserialize($d)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $d **mixed**






## Method `unserialized`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::unserialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `uppercase`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::uppercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `validate`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::validate($name, array $rules, $translate)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $name **mixed**
* $rules **array**
* $translate **mixed**






## Method `validation_errors`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::validation_errors($names)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $names **mixed**






## Method `walk`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::walk($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `without`
In class: [dependencies\Url](#top)

```
mixed dependencies\Data::without()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../dependencies/Data.md)






## Method `_build_url`
In class: [dependencies\Url](#top)

```
mixed dependencies\Url::_build_url($string, array $options)
```





* Visibility: **private**

#### Arguments

* $string **mixed**
* $options **array**






## Method `_do_check`
In class: [dependencies\Url](#top)

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**





