# dependencies\Table
[API index](../API-index.md)






* Class name: Table
* Namespace: dependencies
* Parent class: [dependencies\Successable](../dependencies/Successable.md)




## Class index

**Properties**
* [`private mixed $applied_sks`](#property-applied_sks)
* [`private mixed $component`](#property-component)
* [`private mixed $distinct`](#property-distinct)
* [`private mixed $from`](#property-from)
* [`private mixed $group`](#property-group)
* [`private mixed $having`](#property-having)
* [`private mixed $hierarchy`](#property-hierarchy)
* [`private mixed $joins`](#property-joins)
* [`private mixed $limit`](#property-limit)
* [`private mixed $model`](#property-model)
* [`private mixed $models`](#property-models)
* [`private mixed $order`](#property-order)
* [`private mixed $select`](#property-select)
* [`private mixed $where`](#property-where)
* [`private mixed $working_model`](#property-working_model)

**Methods**
* [`public mixed __construct($component, $model, $id, $models)`](#method-__construct)
* [`public mixed __invoke($id)`](#method-__invoke)
* [`public mixed _get_model_subquery()`](#method-_get_model_subquery)
* [`public mixed add($model, $id)`](#method-add)
* [`public mixed add_absolute_depth($as)`](#method-add_absolute_depth)
* [`public mixed add_hierarchy()`](#method-add_hierarchy)
* [`public mixed add_relative_depth($as)`](#method-add_relative_depth)
* [`public mixed count()`](#method-count)
* [`public mixed delete($model_name)`](#method-delete)
* [`public mixed distinct($value)`](#method-distinct)
* [`public mixed execute($as)`](#method-execute)
* [`public mixed execute_single($as)`](#method-execute_single)
* [`public mixed filter()`](#method-filter)
* [`public mixed from($model, $id)`](#method-from)
* [`public mixed group($column, $direction)`](#method-group)
* [`public mixed having()`](#method-having)
* [`public mixed helper($component, $name)`](#method-helper)
* [`public mixed inner()`](#method-inner)
* [`public mixed join($model_name, $id, $join_conditions)`](#method-join)
* [`public mixed left()`](#method-left)
* [`public mixed limit($rowcount, $offset)`](#method-limit)
* [`public mixed max_depth($gt)`](#method-max_depth)
* [`public mixed order($column, $direction)`](#method-order)
* [`public mixed parent_pk()`](#method-parent_pk)
* [`public mixed pk()`](#method-pk)
* [`public mixed query($all)`](#method-query)
* [`public mixed right()`](#method-right)
* [`public mixed select($content, $as)`](#method-select)
* [`public mixed set_jointype($type)`](#method-set_jointype)
* [`public mixed sk()`](#method-sk)
* [`public mixed subquery($q)`](#method-subquery)
* [`public mixed where()`](#method-where)
* [`public mixed workwith($id)`](#method-workwith)
* [`public mixed write($as)`](#method-write)
* [`private mixed _get_subquery()`](#method-_get_subquery)
* [`private mixed arguments_to_comparisons()`](#method-arguments_to_comparisons)
* [`private mixed compose_condition(array $condition)`](#method-compose_condition)
* [`private mixed conditions_to_comparisons(\dependencies\Conditions $conditions)`](#method-conditions_to_comparisons)
* [`private mixed get_column_info($input)`](#method-get_column_info)
* [`private mixed get_model_info($input)`](#method-get_model_info)
* [`private mixed grourder($c, $d)`](#method-grourder)
* [`private mixed prepare($input)`](#method-prepare)
* [`private mixed prepare_column($column)`](#method-prepare_column)
* [`private mixed prepare_text($text)`](#method-prepare_text)
* [`private mixed whaving()`](#method-whaving)


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


## Property `$applied_sks`
In class: [dependencies\Table](#top)

```
private mixed $applied_sks = array()
```





* Visibility: **private**


## Property `$component`
In class: [dependencies\Table](#top)

```
private mixed $component = false
```





* Visibility: **private**


## Property `$distinct`
In class: [dependencies\Table](#top)

```
private mixed $distinct = false
```





* Visibility: **private**


## Property `$from`
In class: [dependencies\Table](#top)

```
private mixed $from = array()
```





* Visibility: **private**


## Property `$group`
In class: [dependencies\Table](#top)

```
private mixed $group = array()
```





* Visibility: **private**


## Property `$having`
In class: [dependencies\Table](#top)

```
private mixed $having = ''
```





* Visibility: **private**


## Property `$hierarchy`
In class: [dependencies\Table](#top)

```
private mixed $hierarchy = array()
```





* Visibility: **private**


## Property `$joins`
In class: [dependencies\Table](#top)

```
private mixed $joins = array()
```





* Visibility: **private**


## Property `$limit`
In class: [dependencies\Table](#top)

```
private mixed $limit
```





* Visibility: **private**


## Property `$model`
In class: [dependencies\Table](#top)

```
private mixed $model = false
```





* Visibility: **private**


## Property `$models`
In class: [dependencies\Table](#top)

```
private mixed $models = array()
```





* Visibility: **private**


## Property `$order`
In class: [dependencies\Table](#top)

```
private mixed $order = array()
```





* Visibility: **private**


## Property `$select`
In class: [dependencies\Table](#top)

```
private mixed $select = array()
```





* Visibility: **private**


## Property `$where`
In class: [dependencies\Table](#top)

```
private mixed $where = ''
```





* Visibility: **private**


## Property `$working_model`
In class: [dependencies\Table](#top)

```
private mixed $working_model
```





* Visibility: **private**


# Methods


## Method `__construct`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::__construct($component, $model, $id, $models)
```





* Visibility: **public**

#### Arguments

* $component **mixed**
* $model **mixed**
* $id **mixed**
* $models **mixed**






## Method `__invoke`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::__invoke($id)
```





* Visibility: **public**

#### Arguments

* $id **mixed**






## Method `_get_model_subquery`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::_get_model_subquery()
```





* Visibility: **public**






## Method `_success`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)






## Method `add`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::add($model, $id)
```





* Visibility: **public**

#### Arguments

* $model **mixed**
* $id **mixed**






## Method `add_absolute_depth`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::add_absolute_depth($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**






## Method `add_hierarchy`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::add_hierarchy()
```





* Visibility: **public**






## Method `add_relative_depth`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::add_relative_depth($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**






## Method `and_is`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::and_is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `and_not`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::and_not($check)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `count`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::count()
```





* Visibility: **public**






## Method `delete`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::delete($model_name)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**






## Method `distinct`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::distinct($value)
```





* Visibility: **public**

#### Arguments

* $value **mixed**






## Method `execute`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::execute($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**






## Method `execute_single`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::execute_single($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**






## Method `failure`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::failure($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `filter`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::filter()
```





* Visibility: **public**






## Method `from`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::from($model, $id)
```





* Visibility: **public**

#### Arguments

* $model **mixed**
* $id **mixed**






## Method `group`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::group($column, $direction)
```





* Visibility: **public**

#### Arguments

* $column **mixed**
* $direction **mixed**






## Method `having`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::having()
```





* Visibility: **public**






## Method `helper`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::helper($component, $name)
```





* Visibility: **public**

#### Arguments

* $component **mixed**
* $name **mixed**






## Method `inner`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::inner()
```





* Visibility: **public**






## Method `is`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::is($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `join`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::join($model_name, $id, $join_conditions)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**
* $id **mixed**
* $join_conditions **mixed**






## Method `left`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::left()
```





* Visibility: **public**






## Method `limit`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::limit($rowcount, $offset)
```





* Visibility: **public**

#### Arguments

* $rowcount **mixed**
* $offset **mixed**






## Method `max_depth`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::max_depth($gt)
```





* Visibility: **public**

#### Arguments

* $gt **mixed**






## Method `not`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**
* $callback **mixed**






## Method `order`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::order($column, $direction)
```





* Visibility: **public**

#### Arguments

* $column **mixed**
* $direction **mixed**






## Method `parent_pk`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::parent_pk()
```





* Visibility: **public**






## Method `pk`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::pk()
```





* Visibility: **public**






## Method `query`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::query($all)
```





* Visibility: **public**

#### Arguments

* $all **mixed**






## Method `right`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::right()
```





* Visibility: **public**






## Method `select`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::select($content, $as)
```





* Visibility: **public**

#### Arguments

* $content **mixed**
* $as **mixed**






## Method `set_jointype`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::set_jointype($type)
```





* Visibility: **public**

#### Arguments

* $type **mixed**






## Method `sk`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::sk()
```





* Visibility: **public**






## Method `subquery`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::subquery($q)
```





* Visibility: **public**

#### Arguments

* $q **mixed**






## Method `success`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $callback **mixed**






## Method `where`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::where()
```





* Visibility: **public**






## Method `workwith`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::workwith($id)
```





* Visibility: **public**

#### Arguments

* $id **mixed**






## Method `write`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::write($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**






## Method `_do_check`
In class: [dependencies\Table](#top)

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](../dependencies/Successable.md)

#### Arguments

* $check **mixed**






## Method `_get_subquery`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::_get_subquery()
```





* Visibility: **private**






## Method `arguments_to_comparisons`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::arguments_to_comparisons()
```





* Visibility: **private**






## Method `compose_condition`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::compose_condition(array $condition)
```





* Visibility: **private**

#### Arguments

* $condition **array**






## Method `conditions_to_comparisons`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::conditions_to_comparisons(\dependencies\Conditions $conditions)
```





* Visibility: **private**

#### Arguments

* $conditions **[dependencies\Conditions](../dependencies/Conditions.md)**






## Method `get_column_info`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::get_column_info($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**






## Method `get_model_info`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::get_model_info($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**






## Method `grourder`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::grourder($c, $d)
```





* Visibility: **private**

#### Arguments

* $c **mixed**
* $d **mixed**






## Method `prepare`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::prepare($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**






## Method `prepare_column`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::prepare_column($column)
```





* Visibility: **private**

#### Arguments

* $column **mixed**






## Method `prepare_text`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::prepare_text($text)
```





* Visibility: **private**

#### Arguments

* $text **mixed**






## Method `whaving`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::whaving()
```





* Visibility: **private**





