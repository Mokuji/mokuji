# dependencies\BaseModel






* Class name: BaseModel
* Namespace: dependencies
* This is an **abstract** class
* Parent class: [dependencies\Data](dependencies-Data)




## Class index

**Properties**
* `protected static mixed $generatedLabels`
* `protected static mixed $labels`
* `protected static mixed $relations_by_column`
* `protected static mixed $validate`
* `private static mixed $table_data`
* `private mixed $component`
* `private mixed $deleted`
* `private mixed $model`

**Methods**
* `public static mixed model_data($get)`
* `public static mixed table_data($get, $set)`
* `private static mixed create_table_data()`
* `public mixed __construct($database_row, $resultset, $key)`
* `public mixed __get($var_name)`
* `public mixed __set($var_name, $value)`
* `public mixed ai($get_key)`
* `public mixed as_form($id)`
* `public mixed component()`
* `public mixed delete()`
* `public mixed hdelete()`
* `public mixed hsave($parent_pks, $index)`
* `public mixed labels($originals)`
* `public mixed model()`
* `public mixed pks($get_keys)`
* `public array relations_by_column(string $column)`
* `public mixed render_form($id, $action, array $options)`
* `public mixed save()`
* `public mixed sks($get_keys)`
* `public mixed table($model_name)`
* `public mixed validate_model($options)`
* `protected mixed refresh_labels()`
* `private mixed get_save_data($insert, $data)`
* `private mixed validate_column($column_name, $value)`


## Inheritance index

**Properties**

**Methods**
* `public mixed __clone()`
* `public mixed __destruct()`
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


### $generatedLabels

```
protected mixed $generatedLabels = array()
```





* Visibility: **protected**
* This property is **static**.


### $labels

```
protected mixed $labels = array()
```





* Visibility: **protected**
* This property is **static**.


### $relations_by_column

```
protected mixed $relations_by_column
```





* Visibility: **protected**
* This property is **static**.


### $validate

```
protected mixed $validate = array()
```





* Visibility: **protected**
* This property is **static**.


### $table_data

```
private mixed $table_data = array()
```





* Visibility: **private**
* This property is **static**.


### $component

```
private mixed $component
```





* Visibility: **private**


### $deleted

```
private mixed $deleted = false
```





* Visibility: **private**


### $model

```
private mixed $model
```





* Visibility: **private**


Methods
-------


### model_data

```
mixed dependencies\BaseModel::model_data($get)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $get **mixed**



### table_data

```
mixed dependencies\BaseModel::table_data($get, $set)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $get **mixed**
* $set **mixed**



### create_table_data

```
mixed dependencies\BaseModel::create_table_data()
```





* Visibility: **private**
* This method is **static**.



### __clone

```
mixed dependencies\Data::__clone()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### __construct

```
mixed dependencies\BaseModel::__construct($database_row, $resultset, $key)
```





* Visibility: **public**

#### Arguments

* $database_row **mixed**
* $resultset **mixed**
* $key **mixed**



### __destruct

```
mixed dependencies\Data::__destruct()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### __get

```
mixed dependencies\BaseModel::__get($var_name)
```





* Visibility: **public**

#### Arguments

* $var_name **mixed**



### __set

```
mixed dependencies\BaseModel::__set($var_name, $value)
```





* Visibility: **public**

#### Arguments

* $var_name **mixed**
* $value **mixed**



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



### ai

```
mixed dependencies\BaseModel::ai($get_key)
```





* Visibility: **public**

#### Arguments

* $get_key **mixed**



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



### as_form

```
mixed dependencies\BaseModel::as_form($id)
```

Create an HTML form for updating this model.

<p>as_form(&amp;$id[, $action][, $columns])</p>

* Visibility: **public**

#### Arguments

* $id **mixed**



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



### component

```
mixed dependencies\BaseModel::component()
```





* Visibility: **public**



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



### delete

```
mixed dependencies\BaseModel::delete()
```





* Visibility: **public**



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



### hdelete

```
mixed dependencies\BaseModel::hdelete()
```





* Visibility: **public**



### hsave

```
mixed dependencies\BaseModel::hsave($parent_pks, $index)
```





* Visibility: **public**

#### Arguments

* $parent_pks **mixed**
* $index **mixed**



### html_escape

```
mixed dependencies\Data::html_escape($flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)

#### Arguments

* $flags **mixed**



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



### labels

```
mixed dependencies\BaseModel::labels($originals)
```





* Visibility: **public**

#### Arguments

* $originals **mixed**



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



### model

```
mixed dependencies\BaseModel::model()
```





* Visibility: **public**



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



### pks

```
mixed dependencies\BaseModel::pks($get_keys)
```





* Visibility: **public**

#### Arguments

* $get_keys **mixed**



### push

```
mixed dependencies\Data::push()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### relations_by_column

```
array dependencies\BaseModel::relations_by_column(string $column)
```

Gets the relations grouped by column name, rather than target model name.



* Visibility: **public**

#### Arguments

* $column **string** - Gets the result for one specific column. Defaults to returning all columns.



### render_form

```
mixed dependencies\BaseModel::render_form($id, $action, array $options)
```





* Visibility: **public**

#### Arguments

* $id **mixed**
* $action **mixed**
* $options **array**



### reverse

```
mixed dependencies\Data::reverse()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](dependencies-Data)



### save

```
mixed dependencies\BaseModel::save()
```





* Visibility: **public**



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



### sks

```
mixed dependencies\BaseModel::sks($get_keys)
```





* Visibility: **public**

#### Arguments

* $get_keys **mixed**



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



### table

```
mixed dependencies\BaseModel::table($model_name)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**



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



### validate_model

```
mixed dependencies\BaseModel::validate_model($options)
```

Validates the whole model, based on static validation rules.

<p>Options:
   array $rules - Defines extra rules per field name.
   bool $force_create - Tries to ignore the PK if it has an auto_increment attribute. Otherwise throws programmer exception.</p>

* Visibility: **public**

#### Arguments

* $options **mixed**



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



### refresh_labels

```
mixed dependencies\BaseModel::refresh_labels()
```





* Visibility: **protected**



### _do_check

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**



### get_save_data

```
mixed dependencies\BaseModel::get_save_data($insert, $data)
```





* Visibility: **private**

#### Arguments

* $insert **mixed**
* $data **mixed**



### validate_column

```
mixed dependencies\BaseModel::validate_column($column_name, $value)
```





* Visibility: **private**

#### Arguments

* $column_name **mixed**
* $value **mixed**


