# dependencies\Table






* Class name: Table
* Namespace: dependencies
* Parent class: [dependencies\Successable](dependencies-Successable)




## Class index

**Properties**
* `private mixed $applied_sks`
* `private mixed $component`
* `private mixed $from`
* `private mixed $group`
* `private mixed $having`
* `private mixed $hierarchy`
* `private mixed $joins`
* `private mixed $limit`
* `private mixed $model`
* `private mixed $models`
* `private mixed $order`
* `private mixed $select`
* `private mixed $where`
* `private mixed $working_model`

**Methods**
* `public mixed __construct($component, $model, $id, $models)`
* `public mixed __invoke($id)`
* `public mixed _get_model_subquery()`
* `public mixed add($model, $id)`
* `public mixed add_absolute_depth($as)`
* `public mixed add_hierarchy()`
* `public mixed add_relative_depth($as)`
* `public mixed count()`
* `public mixed delete($model_name)`
* `public mixed execute($as)`
* `public mixed execute_single($as)`
* `public mixed filter()`
* `public mixed from($model, $id)`
* `public mixed group($column, $direction)`
* `public mixed having()`
* `public mixed inner()`
* `public mixed join($model_name, $id)`
* `public mixed left()`
* `public mixed limit($rowcount, $offset)`
* `public mixed max_depth($gt)`
* `public mixed order($column, $direction)`
* `public mixed parent_pk()`
* `public mixed pk()`
* `public mixed query($all)`
* `public mixed right()`
* `public mixed select($content, $as)`
* `public mixed set_jointype($type)`
* `public mixed sk()`
* `public mixed subquery($q)`
* `public mixed where()`
* `public mixed workwith($id)`
* `public mixed write($as)`
* `private mixed _get_subquery()`
* `private mixed arguments_to_comparisons()`
* `private mixed compose_condition(array $condition)`
* `private mixed conditions_to_comparisons(\dependencies\Conditions $conditions)`
* `private mixed get_column_info($input)`
* `private mixed get_model_info($input)`
* `private mixed grourder($c, $d)`
* `private mixed prepare($input)`
* `private mixed prepare_column($column)`
* `private mixed prepare_text($text)`
* `private mixed whaving()`


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


### $applied_sks

```
private mixed $applied_sks = array()
```





* Visibility: **private**


### $component

```
private mixed $component = false
```





* Visibility: **private**


### $from

```
private mixed $from = array()
```





* Visibility: **private**


### $group

```
private mixed $group = array()
```





* Visibility: **private**


### $having

```
private mixed $having = ''
```





* Visibility: **private**


### $hierarchy

```
private mixed $hierarchy = array()
```





* Visibility: **private**


### $joins

```
private mixed $joins = array()
```





* Visibility: **private**


### $limit

```
private mixed $limit
```





* Visibility: **private**


### $model

```
private mixed $model = false
```





* Visibility: **private**


### $models

```
private mixed $models = array()
```





* Visibility: **private**


### $order

```
private mixed $order = array()
```





* Visibility: **private**


### $select

```
private mixed $select = array()
```





* Visibility: **private**


### $where

```
private mixed $where = ''
```





* Visibility: **private**


### $working_model

```
private mixed $working_model
```





* Visibility: **private**


Methods
-------


### __construct

```
mixed dependencies\Table::__construct($component, $model, $id, $models)
```





* Visibility: **public**

#### Arguments

* $component **mixed**
* $model **mixed**
* $id **mixed**
* $models **mixed**



### __invoke

```
mixed dependencies\Table::__invoke($id)
```





* Visibility: **public**

#### Arguments

* $id **mixed**



### _get_model_subquery

```
mixed dependencies\Table::_get_model_subquery()
```





* Visibility: **public**



### _success

```
mixed dependencies\Successable::_success()
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)



### add

```
mixed dependencies\Table::add($model, $id)
```





* Visibility: **public**

#### Arguments

* $model **mixed**
* $id **mixed**



### add_absolute_depth

```
mixed dependencies\Table::add_absolute_depth($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**



### add_hierarchy

```
mixed dependencies\Table::add_hierarchy()
```





* Visibility: **public**



### add_relative_depth

```
mixed dependencies\Table::add_relative_depth($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**



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



### count

```
mixed dependencies\Table::count()
```





* Visibility: **public**



### delete

```
mixed dependencies\Table::delete($model_name)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**



### execute

```
mixed dependencies\Table::execute($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**



### execute_single

```
mixed dependencies\Table::execute_single($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**



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
mixed dependencies\Table::filter()
```





* Visibility: **public**



### from

```
mixed dependencies\Table::from($model, $id)
```





* Visibility: **public**

#### Arguments

* $model **mixed**
* $id **mixed**



### group

```
mixed dependencies\Table::group($column, $direction)
```





* Visibility: **public**

#### Arguments

* $column **mixed**
* $direction **mixed**



### having

```
mixed dependencies\Table::having()
```





* Visibility: **public**



### inner

```
mixed dependencies\Table::inner()
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



### join

```
mixed dependencies\Table::join($model_name, $id)
```





* Visibility: **public**

#### Arguments

* $model_name **mixed**
* $id **mixed**



### left

```
mixed dependencies\Table::left()
```





* Visibility: **public**



### limit

```
mixed dependencies\Table::limit($rowcount, $offset)
```





* Visibility: **public**

#### Arguments

* $rowcount **mixed**
* $offset **mixed**



### max_depth

```
mixed dependencies\Table::max_depth($gt)
```





* Visibility: **public**

#### Arguments

* $gt **mixed**



### not

```
mixed dependencies\Successable::not($check, $callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**
* $callback **mixed**



### order

```
mixed dependencies\Table::order($column, $direction)
```





* Visibility: **public**

#### Arguments

* $column **mixed**
* $direction **mixed**



### parent_pk

```
mixed dependencies\Table::parent_pk()
```





* Visibility: **public**



### pk

```
mixed dependencies\Table::pk()
```





* Visibility: **public**



### query

```
mixed dependencies\Table::query($all)
```





* Visibility: **public**

#### Arguments

* $all **mixed**



### right

```
mixed dependencies\Table::right()
```





* Visibility: **public**



### select

```
mixed dependencies\Table::select($content, $as)
```





* Visibility: **public**

#### Arguments

* $content **mixed**
* $as **mixed**



### set_jointype

```
mixed dependencies\Table::set_jointype($type)
```





* Visibility: **public**

#### Arguments

* $type **mixed**



### sk

```
mixed dependencies\Table::sk()
```





* Visibility: **public**



### subquery

```
mixed dependencies\Table::subquery($q)
```





* Visibility: **public**

#### Arguments

* $q **mixed**



### success

```
mixed dependencies\Successable::success($callback)
```





* Visibility: **public**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $callback **mixed**



### where

```
mixed dependencies\Table::where()
```





* Visibility: **public**



### workwith

```
mixed dependencies\Table::workwith($id)
```





* Visibility: **public**

#### Arguments

* $id **mixed**



### write

```
mixed dependencies\Table::write($as)
```





* Visibility: **public**

#### Arguments

* $as **mixed**



### _do_check

```
mixed dependencies\Successable::_do_check($check)
```





* Visibility: **private**
* This method is defined by [dependencies\Successable](dependencies-Successable)

#### Arguments

* $check **mixed**



### _get_subquery

```
mixed dependencies\Table::_get_subquery()
```





* Visibility: **private**



### arguments_to_comparisons

```
mixed dependencies\Table::arguments_to_comparisons()
```





* Visibility: **private**



### compose_condition

```
mixed dependencies\Table::compose_condition(array $condition)
```





* Visibility: **private**

#### Arguments

* $condition **array**



### conditions_to_comparisons

```
mixed dependencies\Table::conditions_to_comparisons(\dependencies\Conditions $conditions)
```





* Visibility: **private**

#### Arguments

* $conditions **[dependencies\Conditions](dependencies-Conditions)**



### get_column_info

```
mixed dependencies\Table::get_column_info($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**



### get_model_info

```
mixed dependencies\Table::get_model_info($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**



### grourder

```
mixed dependencies\Table::grourder($c, $d)
```





* Visibility: **private**

#### Arguments

* $c **mixed**
* $d **mixed**



### prepare

```
mixed dependencies\Table::prepare($input)
```





* Visibility: **private**

#### Arguments

* $input **mixed**



### prepare_column

```
mixed dependencies\Table::prepare_column($column)
```





* Visibility: **private**

#### Arguments

* $column **mixed**



### prepare_text

```
mixed dependencies\Table::prepare_text($text)
```





* Visibility: **private**

#### Arguments

* $text **mixed**



### whaving

```
mixed dependencies\Table::whaving()
```





* Visibility: **private**


