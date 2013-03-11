# components\update\models\PackageVersions
[API index](../../../API-index.md)






* Class name: PackageVersions
* Namespace: components\update\models
* Parent class: [dependencies\BaseModel](../../../dependencies/BaseModel.md)




## Class index

**Properties**
* [`protected static mixed $relations`](#property-relations)
* [`protected static mixed $table_name`](#property-table_name)

**Methods**
* [`public mixed get_changes()`](#method-get_changes)
* [`public mixed get_package()`](#method-get_package)


## Inheritance index

**Properties**
* [`protected static mixed $generatedLabels`](#property-generatedlabels)
* [`protected static mixed $labels`](#property-labels)
* [`protected static mixed $relation_preferences`](#property-relation_preferences)
* [`protected static mixed $relations_by_column`](#property-relations_by_column)
* [`protected static mixed $validate`](#property-validate)

**Methods**
* [`public static mixed get_related_model($name)`](#method-get_related_model)
* [`public static mixed model_data($get)`](#method-model_data)
* [`public static mixed table_data($get, $set)`](#method-table_data)
* [`private static mixed create_table_data()`](#method-create_table_data)
* [`public mixed __clone()`](#method-__clone)
* [`public mixed __construct($data, $context, $key)`](#method-__construct)
* [`public mixed __destruct()`](#method-__destruct)
* [`public mixed __get($key)`](#method-__get)
* [`public mixed __set($key, $val)`](#method-__set)
* [`public mixed __toString()`](#method-__toString)
* [`public mixed __unset($key)`](#method-__unset)
* [`public mixed _attempt_unserialize()`](#method-_attempt_unserialize)
* [`public mixed _clear_context()`](#method-_clear_context)
* [`public mixed _set_context($context, $key)`](#method-_set_context)
* [`public mixed _success()`](#method-_success)
* [`public mixed add_rules()`](#method-add_rules)
* [`public mixed ai($get_key)`](#method-ai)
* [`public mixed all($callback)`](#method-all)
* [`public mixed and_is($check, $callback)`](#method-and_is)
* [`public mixed and_not($check)`](#method-and_not)
* [`public mixed any($callback)`](#method-any)
* [`public mixed as_array($serialized)`](#method-as_array)
* [`public mixed as_form($id)`](#method-as_form)
* [`public mixed as_json($flags, $options)`](#method-as_json)
* [`public mixed as_list()`](#method-as_list)
* [`public mixed as_options()`](#method-as_options)
* [`public mixed as_rlist()`](#method-as_rlist)
* [`public mixed as_table()`](#method-as_table)
* [`public mixed back()`](#method-back)
* [`public mixed become(\dependencies\Data $data)`](#method-become)
* [`public mixed check($node_name)`](#method-check)
* [`public mixed clear()`](#method-clear)
* [`public mixed component()`](#method-component)
* [`public mixed convert()`](#method-convert)
* [`public mixed copy()`](#method-copy)
* [`public mixed copyto($to)`](#method-copyto)
* [`public mixed delete()`](#method-delete)
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
* [`public mixed hdelete()`](#method-hdelete)
* [`public mixed hsave($parent_pks, $index)`](#method-hsave)
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
* [`public mixed labels($originals)`](#method-labels)
* [`public mixed lowercase()`](#method-lowercase)
* [`public mixed lt($value, $callback)`](#method-lt)
* [`public mixed map($callback)`](#method-map)
* [`public mixed md5()`](#method-md5)
* [`public mixed merge($val, $deep)`](#method-merge)
* [`public mixed model()`](#method-model)
* [`public mixed moveto($to)`](#method-moveto)
* [`public mixed not($check, $callback)`](#method-not)
* [`public mixed offsetExists($key)`](#method-offsetExists)
* [`public mixed offsetGet($key)`](#method-offsetGet)
* [`public mixed offsetSet($key, $val)`](#method-offsetSet)
* [`public mixed offsetUnset($key)`](#method-offsetUnset)
* [`public mixed otherwise($default)`](#method-otherwise)
* [`public mixed parse($regex, $flags)`](#method-parse)
* [`public mixed pks($get_keys)`](#method-pks)
* [`public mixed push()`](#method-push)
* [`public mixed relation_preferences()`](#method-relation_preferences)
* [`public array relations_by_column(string $column)`](#method-relations_by_column)
* [`public mixed render_form($id, $action, array $options)`](#method-render_form)
* [`public mixed reverse()`](#method-reverse)
* [`public mixed save()`](#method-save)
* [`public mixed serialize()`](#method-serialize)
* [`public mixed serialized()`](#method-serialized)
* [`public mixed set()`](#method-set)
* [`public mixed size()`](#method-size)
* [`public mixed sks($get_keys)`](#method-sks)
* [`public mixed slice($offset, $length)`](#method-slice)
* [`public mixed split($s)`](#method-split)
* [`public mixed success($callback)`](#method-success)
* [`public mixed table($model_name)`](#method-table)
* [`public mixed trim($charlist)`](#method-trim)
* [`public mixed type()`](#method-type)
* [`public mixed un_set()`](#method-un_set)
* [`public mixed unserialize($d)`](#method-unserialize)
* [`public mixed unserialized()`](#method-unserialized)
* [`public mixed uppercase()`](#method-uppercase)
* [`public mixed validate($name, array $rules)`](#method-validate)
* [`public mixed validate_model($options)`](#method-validate_model)
* [`public mixed validation_errors($names)`](#method-validation_errors)
* [`public mixed walk($callback)`](#method-walk)
* [`protected mixed refresh_labels()`](#method-refresh_labels)
* [`private mixed _do_check($check)`](#method-_do_check)
* [`private mixed get_save_data($insert, $data)`](#method-get_save_data)
* [`private mixed validate_column($column_name, $value)`](#method-validate_column)



# Properties


## Property `$generatedLabels`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $generatedLabels = array()
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)


## Property `$labels`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $labels = array()
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)


## Property `$relation_preferences`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $relation_preferences = array()
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)


## Property `$relations`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $relations = array('Packages' => array('package_id' => 'Packages.id'), 'PackageVersionChanges' => array('id' => 'PackageVersionChanges.package_version_id'))
```





* Visibility: **protected**
* This property is **static**.


## Property `$relations_by_column`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $relations_by_column
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)


## Property `$table_name`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $table_name = 'update_package_versions'
```





* Visibility: **protected**
* This property is **static**.


## Property `$validate`
In class: [components\update\models\PackageVersions](#top)

```
protected mixed $validate = array()
```





* Visibility: **protected**
* This property is **static**.
* This property is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)


# Methods


## Method `get_related_model`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::get_related_model($name)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $name **mixed**






## Method `model_data`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::model_data($get)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $get **mixed**






## Method `table_data`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::table_data($get, $set)
```





* Visibility: **public**
* This method is **static**.
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $get **mixed**
* $set **mixed**






## Method `create_table_data`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::create_table_data()
```





* Visibility: **private**
* This method is **static**.
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `__clone`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__clone()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `__construct`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__construct($data, $context, $key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $data **mixed**
* $context **mixed**
* $key **mixed**






## Method `__destruct`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__destruct()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `__get`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__get($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `__set`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__set($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**






## Method `__toString`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__toString()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `__unset`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::__unset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `_attempt_unserialize`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::_attempt_unserialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `_clear_context`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::_clear_context()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `_set_context`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::_set_context($context, $key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $context **mixed**
* $key **mixed**






## Method `_success`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)






## Method `add_rules`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::add_rules()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `ai`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::ai($get_key)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $get_key **mixed**






## Method `all`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::all($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `and_is`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `and_not`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `any`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::any($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `as_array`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_array($serialized)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $serialized **mixed**






## Method `as_form`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::as_form($id)
```

Create an HTML form for updating this model.

as_form(&amp;$id[, $action][, $columns])

* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $id **mixed**






## Method `as_json`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_json($flags, $options)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $flags **mixed**
* $options **mixed**






## Method `as_list`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_list()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `as_options`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_options()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `as_rlist`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_rlist()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `as_table`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::as_table()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `back`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::back()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `become`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::become(\dependencies\Data $data)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $data **[dependencies\Data](../../../dependencies/Data.md)**






## Method `check`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::check($node_name)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $node_name **mixed**






## Method `clear`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::clear()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `component`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::component()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `convert`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::convert()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `copy`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::copy()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `copyto`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::copyto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $to **mixed**






## Method `delete`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::delete()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `dump`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::dump($format, $l)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $format **mixed**
* $l **mixed**






## Method `each`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::each($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `enforce_rules`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::enforce_rules($recursive)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $recursive **mixed**






## Method `eq`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::eq($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `extract`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::extract($id)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $id **mixed**






## Method `failure`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `filter`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::filter($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `format`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::format($format)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $format **mixed**






## Method `generation`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::generation()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `get`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::get($as)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $as **mixed**






## Method `getIterator`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::getIterator()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `get_changes`
In class: [components\update\models\PackageVersions](#top)

```
mixed components\update\models\PackageVersions::get_changes()
```





* Visibility: **public**






## Method `get_package`
In class: [components\update\models\PackageVersions](#top)

```
mixed components\update\models\PackageVersions::get_package()
```





* Visibility: **public**






## Method `gt`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::gt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `having`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::having()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `hdelete`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::hdelete()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `hsave`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::hsave($parent_pks, $index)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $parent_pks **mixed**
* $index **mixed**






## Method `html_escape`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::html_escape($flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $flags **mixed**






## Method `idx`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::idx($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `is`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `is_childnode`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_childnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_empty`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_empty()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_false`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_false()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_godnode`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_godnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_leafnode`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_leafnode()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_numeric`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_numeric()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_parent`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_parent()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_set`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `is_true`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::is_true()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `join`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::join($separator)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $separator **mixed**






## Method `key`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::key()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `keyof`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::keyof($node)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $node **mixed**






## Method `keys`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::keys()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `ksort`
In class: [components\update\models\PackageVersions](#top)

```
\dependencies\Data dependencies\Data::ksort()
```

Sorts the data object by key.



* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)


#### Return value

**[dependencies\Data](../../../dependencies/Data.md)** - Returns $this







## Method `labels`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::labels($originals)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $originals **mixed**






## Method `lowercase`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::lowercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `lt`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::lt($value, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $value **mixed**
* $callback **mixed**






## Method `map`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::map($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `md5`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::md5()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `merge`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::merge($val, $deep)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $val **mixed**
* $deep **mixed**






## Method `model`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::model()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `moveto`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::moveto($to)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $to **mixed**






## Method `not`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `offsetExists`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::offsetExists($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `offsetGet`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::offsetGet($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `offsetSet`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::offsetSet($key, $val)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**
* $val **mixed**






## Method `offsetUnset`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::offsetUnset($key)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $key **mixed**






## Method `otherwise`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::otherwise($default)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $default **mixed**






## Method `parse`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::parse($regex, $flags)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $regex **mixed**
* $flags **mixed**






## Method `pks`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::pks($get_keys)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $get_keys **mixed**






## Method `push`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::push()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `relation_preferences`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::relation_preferences()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `relations_by_column`
In class: [components\update\models\PackageVersions](#top)

```
array dependencies\BaseModel::relations_by_column(string $column)
```

Gets the relations grouped by column name, rather than target model name.



* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $column **string** - Gets the result for one specific column. Defaults to returning all columns.


#### Return value

**array** - The relations of this model grouped by column name.
   The format for this is:
     [column_name] =&gt; array(   | For every column... (only if $column is not set)
       [0,1,...,n] =&gt; array(   | A 0-indexed array of relations.
         [target] =&gt; (string), | The target field of the relation.
         [model] =&gt; (string)   | The target model of the relation.
       )
     )







## Method `render_form`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::render_form($id, $action, array $options)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $id **mixed**
* $action **mixed**
* $options **array**






## Method `reverse`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::reverse()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `save`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::save()
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `serialize`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::serialize()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `serialized`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::serialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `set`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `size`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::size()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `sks`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::sks($get_keys)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $get_keys **mixed**






## Method `slice`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::slice($offset, $length)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $offset **mixed**
* $length **mixed**






## Method `split`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::split($s)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $s **mixed**






## Method `success`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `table`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::table($model_name)
```





* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $model_name **mixed**






## Method `trim`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::trim($charlist)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $charlist **mixed**






## Method `type`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::type()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `un_set`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::un_set()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `unserialize`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::unserialize($d)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $d **mixed**






## Method `unserialized`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::unserialized()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `uppercase`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::uppercase()
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)






## Method `validate`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::validate($name, array $rules)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $name **mixed**
* $rules **array**






## Method `validate_model`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::validate_model($options)
```

Validates the whole model, based on static validation rules.

Options:
   array $rules - Defines extra rules per field name.
   boolean $force_create - Tries to ignore the PK if it has an auto_increment attribute. Otherwise throws programmer exception.
   boolean $nullify - When set to true, fields that are valid but empty will be set to NULL (default: false).

* Visibility: **public**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $options **mixed**






## Method `validation_errors`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::validation_errors($names)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $names **mixed**






## Method `walk`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Data::walk($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Data](../../../dependencies/Data.md)

#### Arguments

* $callback **mixed**






## Method `refresh_labels`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::refresh_labels()
```





* Visibility: **protected**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)






## Method `_do_check`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](../../../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `get_save_data`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::get_save_data($insert, $data)
```





* Visibility: **private**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $insert **mixed**
* $data **mixed**






## Method `validate_column`
In class: [components\update\models\PackageVersions](#top)

```
mixed dependencies\BaseModel::validate_column($column_name, $value)
```





* Visibility: **private**
* This method is defined by [dependencies\BaseModel](../../../dependencies/BaseModel.md)

#### Arguments

* $column_name **mixed**
* $value **mixed**





