# dependencies\Table
[API index](../API-index.md)

The Table class, Mokuji&#039;s query-builder.




* Class name: Table
* Namespace: dependencies
* Parent class: [dependencies\Successable](../dependencies/Successable.md)




## Class index

**Properties**
* [`private array $applied_sks`](#property-applied_sks)
* [`private string $component`](#property-component)
* [`private boolean $distinct`](#property-distinct)
* [`private array $from`](#property-from)
* [`private array $group`](#property-group)
* [`private string $having`](#property-having)
* [`private array $hierarchy`](#property-hierarchy)
* [`private array $joins`](#property-joins)
* [`private string $limit`](#property-limit)
* [`private string $model`](#property-model)
* [`private array $models`](#property-models)
* [`private array $order`](#property-order)
* [`private array $select`](#property-select)
* [`private string $where`](#property-where)
* [`private string $working_model`](#property-working_model)

**Methods**
* [`public mixed __construct(string $component, string $model, string $id, array $models)`](#method-__construct)
* [`public self __invoke(string $id)`](#method-__invoke)
* [`public array _get_model_subquery()`](#method-_get_model_subquery)
* [`public self add(mixed $model, string $id)`](#method-add)
* [`public self add_absolute_depth(string $as)`](#method-add_absolute_depth)
* [`public self add_hierarchy()`](#method-add_hierarchy)
* [`public self add_relative_depth(string $as)`](#method-add_relative_depth)
* [`public \dependencies\Data count()`](#method-count)
* [`public self distinct(boolean $value)`](#method-distinct)
* [`public \dependencies\Resultset execute(string $as)`](#method-execute)
* [`public \dependencies\BaseModel execute_single(string $as)`](#method-execute_single)
* [`public self filter()`](#method-filter)
* [`public self from(mixed $model, string $id)`](#method-from)
* [`public string getQuery(string $as, array $model)`](#method-getQuery)
* [`public self group(string $column, string|false $direction)`](#method-group)
* [`public self having()`](#method-having)
* [`public self helper(string $component, string $name)`](#method-helper)
* [`public self inner()`](#method-inner)
* [`public self join(string $model_name, string $id, \Closure $join_conditions)`](#method-join)
* [`public self left()`](#method-left)
* [`public self limit(integer $rowcount, integer $offset)`](#method-limit)
* [`public self max_depth(integer $gt)`](#method-max_depth)
* [`public self order(string $column, string|false $direction)`](#method-order)
* [`public self parent_pk()`](#method-parent_pk)
* [`public self pk()`](#method-pk)
* [`public string query(string $all)`](#method-query)
* [`public self right()`](#method-right)
* [`public self select(mixed $content, string $as)`](#method-select)
* [`public self set_jointype(string $type)`](#method-set_jointype)
* [`public self sk()`](#method-sk)
* [`public self subquery(self $q)`](#method-subquery)
* [`public self where()`](#method-where)
* [`public self workwith(string $id)`](#method-workwith)
* [`public self write(string $as)`](#method-write)
* [`private string _get_subquery()`](#method-_get_subquery)
* [`private string arguments_to_comparisons()`](#method-arguments_to_comparisons)
* [`private string compose_condition(array $condition)`](#method-compose_condition)
* [`private string conditions_to_comparisons(\dependencies\Conditions $conditions)`](#method-conditions_to_comparisons)
* [`private array get_column_info(string $input)`](#method-get_column_info)
* [`private array get_model_info(\dependencies\Table|string $input)`](#method-get_model_info)
* [`private string grourder(string $c, string $d)`](#method-grourder)
* [`private string prepare(\dependencies\Table|array|string|integer $input)`](#method-prepare)
* [`private string prepare_column(string|array $column)`](#method-prepare_column)
* [`private string prepare_text(string $text)`](#method-prepare_text)
* [`private string whaving()`](#method-whaving)


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
private array $applied_sks = array()
```

Contains the array of secondary keys on which the query results are filtered.



* Visibility: **private**


## Property `$component`
In class: [dependencies\Table](#top)

```
private string $component
```

Contains the component name after construction.



* Visibility: **private**


## Property `$distinct`
In class: [dependencies\Table](#top)

```
private boolean $distinct = false
```

Contains whether the SELECT clause will be DISTINCT.



* Visibility: **private**


## Property `$from`
In class: [dependencies\Table](#top)

```
private array $from = array()
```

Contains unprocessed information for building the FROM clause.



* Visibility: **private**


## Property `$group`
In class: [dependencies\Table](#top)

```
private array $group = array()
```

Contains unprocessed information for building the GROUP BY clause.



* Visibility: **private**


## Property `$having`
In class: [dependencies\Table](#top)

```
private string $having = ''
```

Contains the preprocessed HAVING clause.



* Visibility: **private**


## Property `$hierarchy`
In class: [dependencies\Table](#top)

```
private array $hierarchy = array()
```

Contains unprocessed information to build the SQL statements that make the results hierarchical.



* Visibility: **private**


## Property `$joins`
In class: [dependencies\Table](#top)

```
private array $joins = array()
```

Contains unprocessed information for building the JOIN clause.



* Visibility: **private**


## Property `$limit`
In class: [dependencies\Table](#top)

```
private string $limit
```

Contains the preprocessed LIMIT clause.



* Visibility: **private**


## Property `$model`
In class: [dependencies\Table](#top)

```
private string $model = false
```

Contains the internal ID of the main model this instance was constructed with.



* Visibility: **private**


## Property `$models`
In class: [dependencies\Table](#top)

```
private array $models = array()
```

Contains an associative array with model information using the models internal ID's as keys.



* Visibility: **private**


## Property `$order`
In class: [dependencies\Table](#top)

```
private array $order = array()
```

Contains unprocessed information for building the ORDER BY clause.



* Visibility: **private**


## Property `$select`
In class: [dependencies\Table](#top)

```
private array $select = array()
```

Contains unprocessed information for building the SELECT clause.



* Visibility: **private**


## Property `$where`
In class: [dependencies\Table](#top)

```
private string $where = ''
```

Contains the preprocessed WHERE clause.



* Visibility: **private**


## Property `$working_model`
In class: [dependencies\Table](#top)

```
private string $working_model
```

Contains the internal ID of the model that operations will be applied to.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [dependencies\Table](#top)

```
mixed dependencies\Table::__construct(string $component, string $model, string $id, array $models)
```

Constructs a Table object.



* Visibility: **public**

#### Arguments

* $component **string** - The name of the component to look for the model in.
* $model **string** - The name of the model to find.
* $id **string** - An out-parameter that will receive the internal ID that was assigned to the model.
* $models **array** - A reference to an array like {@link self::$models} to use instead of own models.






## Method `__invoke`
In class: [dependencies\Table](#top)

```
self dependencies\Table::__invoke(string $id)
```

Invoke this class like a function to attain the internal ID of the main model.

This is useful when the Table was constructed elsewhere and the internal ID can no
longer be obtained via {@link self::__construct()}.

* Visibility: **public**

#### Arguments

* $id **string** - An out-parameter receiving the internal ID of the main model.


#### Return value

**self** - Chaining enabled.







## Method `_get_model_subquery`
In class: [dependencies\Table](#top)

```
array dependencies\Table::_get_model_subquery()
```

Returns the query inside a `model_info` array, so it can be used as if it's a model.



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
self dependencies\Table::add(mixed $model, string $id)
```

Add a model and make it the working model.

This adds a model to the FROM clause, and makes it the new working right away.

* Visibility: **public**

#### Arguments

* $model **mixed** - See {@link self::get_model_info()} to find out what can be given.
* $id **string** - This is an out-parameter that will receive the internal ID assigned to the new model.


#### Return value

**self** - Chaining enabled.







## Method `add_absolute_depth`
In class: [dependencies\Table](#top)

```
self dependencies\Table::add_absolute_depth(string $as)
```

Add a depth field based on hierarchy.

The depth field added by this method contains will contain the depth &lt;em&gt;relative to the
root node&lt;/em&gt;, therefore making it "absolute".

* Visibility: **public**

#### Arguments

* $as **string** - The field name that the absolute depth variable will become
                  available under. Defaults to `abs_depth`.


#### Return value

**self** - Chaining enabled.







## Method `add_hierarchy`
In class: [dependencies\Table](#top)

```
self dependencies\Table::add_hierarchy()
```

Make this query hierarchical.

Adds stuff to the query needed to use a hierarchy based on hierarchy information
defined in the current working model.

This method is mostly used internally by all the methods that depend on the hierarchical structure.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `add_relative_depth`
In class: [dependencies\Table](#top)

```
self dependencies\Table::add_relative_depth(string $as)
```

Add a depth field based on hierarchy.

The depth field added by this method contains will contain the depth &lt;em&gt;relative to the
parent node&lt;/em&gt;, therefore this method requires you to appoint a parent node first. This
can be done using {@link self::parent_pk()}.

* Visibility: **public**

#### Arguments

* $as **string** - The field name that the relative depth variable will become
                  available under. Defaults to `rel_depth`.


#### Return value

**self** - Chaining Enabled.




#### Throws exceptions

* **[exception\Restriction](../exception/Restriction.md)** - If No parent node was appointed beforehand.




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
\dependencies\Data dependencies\Table::count()
```

Execute the query, returning the amount of rows affected.



* Visibility: **public**


#### Return value

**[dependencies\Data](../dependencies/Data.md)** - An instance of Data wrapping an integer containing the amount of rows.







## Method `distinct`
In class: [dependencies\Table](#top)

```
self dependencies\Table::distinct(boolean $value)
```

Make the SELECT clause a DISTINCT select clause.



* Visibility: **public**

#### Arguments

* $value **boolean** - Can be set to false to disable distinct select.


#### Return value

**self** - Chaining enabled.







## Method `execute`
In class: [dependencies\Table](#top)

```
\dependencies\Resultset dependencies\Table::execute(string $as)
```

Execute the query.



* Visibility: **public**

#### Arguments

* $as **string** - An optional model ID in which the results will be returned.


#### Return value

**[dependencies\Resultset](../dependencies/Resultset.md)** - The wrapper with the result of the query.




#### Throws exceptions

* **[exception\NotFound](../exception/NotFound.md)** - If the given model ID does not point to a known model.
* **[exception\Sql](../exception/Sql.md)** - If an SQL error occurs.




## Method `execute_single`
In class: [dependencies\Table](#top)

```
\dependencies\BaseModel dependencies\Table::execute_single(string $as)
```

Execute and return the first result directly.

This method also automatically adds a limit of 1.

* Visibility: **public**

#### Arguments

* $as **string** - An optional model ID in which the results will be returned.


#### Return value

**[dependencies\BaseModel](../dependencies/BaseModel.md)** - The model that contains the first row.




#### Throws exceptions

* **[exception\NotFound](../exception/NotFound.md)** - If the given model ID does not point to a known model.
* **[exception\Sql](../exception/Sql.md)** - If an SQL error occurs.




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
self dependencies\Table::filter()
```

Add statements to the WHERE clause automatically for given component filters.

Components filters are current GET parameters, merged with the filters set in the
session for the component.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.




#### Throws exceptions

* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If the arguments have an unexpected format.




## Method `from`
In class: [dependencies\Table](#top)

```
self dependencies\Table::from(mixed $model, string $id)
```

Add a model to the FROM clause.



* Visibility: **public**

#### Arguments

* $model **mixed** - See {@link self::get_model_info()} to see what can be given here.
* $id **string** - An out-parameter which will receive the internal ID of the model.


#### Return value

**self** - Chaining enabled.







## Method `getQuery`
In class: [dependencies\Table](#top)

```
string dependencies\Table::getQuery(string $as, array $model)
```

Generate and return the query as a string.



* Visibility: **public**

#### Arguments

* $as **string** - An optional model ID in which the results will be returned.
* $model **array** - An out-parameter that receives model meta-data.


#### Return value

**string** - The query.




#### Throws exceptions

* **[exception\NotFound](../exception/NotFound.md)** - If the given model ID does not point to a known model.
* **[exception\Sql](../exception/Sql.md)** - If an SQL error occurs.




## Method `group`
In class: [dependencies\Table](#top)

```
self dependencies\Table::group(string $column, string|false $direction)
```

Group by the given column in the working model.



* Visibility: **public**

#### Arguments

* $column **string** - The column identifier.
* $direction **string|false** - Optional direction; `&quot;ASC&quot;` or `&quot;DESC&quot;`.


#### Return value

**self** - Chaining enabled.







## Method `having`
In class: [dependencies\Table](#top)

```
self dependencies\Table::having()
```

Add to the HAVING clause.

Adds to the HAVING clause in the exact same way that &lt;code&gt;$this-&gt;where()&lt;/code&gt; adds to there
WHERE clause. Please refer to the &lt;code&gt;where()&lt;/code&gt; documentation for use of this method.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `helper`
In class: [dependencies\Table](#top)

```
self dependencies\Table::helper(string $component, string $name)
```

Call a helper function to do complex table operations.



* Visibility: **public**

#### Arguments

* $component **string** - The name of the component that has the helper function.
* $name **string** - The name of the helper function to call. Note that this is the
                    name _without_ the `table__` prefix that it must have in the
                    component&#039;s Helpers class.


#### Return value

**self** - Chaining enabled.







## Method `inner`
In class: [dependencies\Table](#top)

```
self dependencies\Table::inner()
```

Sets join type of the last join to "INNER".

This is an alias for &lt;code&gt;$this-&gt;set_jointype('INNER')&lt;/code&gt;.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







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
self dependencies\Table::join(string $model_name, string $id, \Closure $join_conditions)
```

Join a foreign model onto the working model.

This method uses the &lt;code&gt;relations&lt;/code&gt; information available on the local model or foreign
model classes to determine which tables to join on which keys in order to join the
model of the given name.

You can define these relations in your model by setting the static &lt;code&gt;$relations&lt;/code&gt;
property in the model class to an array, formatted as follows:

&lt;code&gt;php
static $relations = array(
  "&lt;foreign_model_name&gt;" =&gt; array(
    "&lt;local_column_name&gt;" =&gt; "&lt;join_model_name&gt;.&lt;join_column_name&gt;"[,
    "&lt;join_type&gt;"]
  )
);&lt;/code&gt;

&lt;ul&gt;
&lt;li&gt;&lt;code&gt;&lt;foreign_model_name&gt;&lt;/code&gt;: The model that can be joined.&lt;/li&gt;
&lt;li&gt;&lt;code&gt;&lt;local_column_name&gt;&lt;/code&gt;: The column name in this model that the join column will be linked to.&lt;/li&gt;
&lt;li&gt;&lt;code&gt;&lt;join_model_name&gt;&lt;/code&gt;: The first model to join in order to get to the foreign model.&lt;/li&gt;
&lt;li&gt;&lt;code&gt;&lt;join_column_name&gt;&lt;/code&gt;: The name of the column that links to the local column.&lt;/li&gt;
&lt;/ul&gt;

In most cases, the &lt;code&gt;&lt;join_model_name&gt;&lt;/code&gt; will be equal to the &lt;code&gt;&lt;foreign_model_name&gt;&lt;/code&gt;
for a direct join path. They can however differ to create a longer path of joins, in
this case, the &lt;code&gt;&lt;join_model_name&gt;&lt;/code&gt; will be joined at first and &lt;code&gt;join()&lt;/code&gt; will look
into that model for further relations with the eventual &lt;code&gt;&lt;foreign_model_name&gt;&lt;/code&gt;. This
is useful for joining a foreign model through a link table that has 2 foreign keys.

* Visibility: **public**

#### Arguments

* $model_name **string** - The name of the foreign model. Can be set to
                          `&quot;__CURRENT__&quot;` in order to use the current working model
                          when `$join_conditions` is provided.
* $id **string** - The out-parameter which will receive the internal ID that gets
                  assigned to the model.
* $join_conditions **Closure** - An optional closure which can modify the Conditions
                                 object in order to change the &quot;ON&quot; clause of this
                                 join. This closure is executed once when generating
                                 the ON clause and will receive the following
                                 arguments: The internal ID of the local model, the
                                 internal ID of the foreign model, and the Conditions
                                 object. See {@link Conditions} to find out how the
                                 object can be modified.


#### Return value

**self** - Chaining enabled.







## Method `left`
In class: [dependencies\Table](#top)

```
self dependencies\Table::left()
```

Sets join type of the last join to "LEFT".

This is an alias for &lt;code&gt;$this-&gt;set_jointype('LEFT')&lt;/code&gt;.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `limit`
In class: [dependencies\Table](#top)

```
self dependencies\Table::limit(integer $rowcount, integer $offset)
```

Limit the amount of rows returned.



* Visibility: **public**

#### Arguments

* $rowcount **integer** - The maximum amount of rows allowed.
* $offset **integer** - An optional offset. Rows before the offset will not be included.


#### Return value

**self** - Chaining enabled.







## Method `max_depth`
In class: [dependencies\Table](#top)

```
self dependencies\Table::max_depth(integer $gt)
```

Exclude all nodes with a depth greater than given value.

"Depth" in this method refers to either the relative depth or absolute depth fields
added by the respective methods; {@link self::add_absolute_depth()} or
{@link self::add_relative_depth()}. When both fields are present, relative depth will
be used.

* Visibility: **public**

#### Arguments

* $gt **integer** - The number of maximum depth.


#### Return value

**self** - Chaining enabled.







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
self dependencies\Table::order(string $column, string|false $direction)
```

Order by the given column in the working model.



* Visibility: **public**

#### Arguments

* $column **string** - The column identifier.
* $direction **string|false** - Optional direction; `&quot;ASC&quot;` or `&quot;DESC&quot;`.


#### Return value

**self** - Chaining enabled.







## Method `parent_pk`
In class: [dependencies\Table](#top)

```
self dependencies\Table::parent_pk()
```

Filter by parent' primary key assuming a hierarchical table structure.



* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `pk`
In class: [dependencies\Table](#top)

```
self dependencies\Table::pk()
```

Filter by primary keys.

The amount of primary keys given must be exactly equal to the amount of primary keys
in the table. This method adds a statement to the WHERE clause for each primary key.
Settings this will therefore result in a single result in most cases, and works well
together with {@link self::execute_single()}

* Visibility: **public**


#### Return value

**self** - Chaining enabled.




#### Throws exceptions

* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If The number of given keys doesn&#039;t match the
                                   amount of primary keys defined in the model.




## Method `query`
In class: [dependencies\Table](#top)

```
string dependencies\Table::query(string $all)
```

Builds the query



* Visibility: **public**

#### Arguments

* $all **string** - Column to select.


#### Return value

**string** - The query.







## Method `right`
In class: [dependencies\Table](#top)

```
self dependencies\Table::right()
```

Sets join type of the last join to "RIGHT".

This is an alias for &lt;code&gt;$this-&gt;set_jointype('RIGHT')&lt;/code&gt;.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `select`
In class: [dependencies\Table](#top)

```
self dependencies\Table::select(mixed $content, string $as)
```

Adds a column to the SELECT clause.



* Visibility: **public**

#### Arguments

* $content **mixed** - See {@link self::prepare()} to find out what can be given here.
* $as **string** - An optional alias to select this content by.


#### Return value

**self** - Chaining enabled.




#### Throws exceptions

* **[exception\Restriction](../exception/Restriction.md)** - If The given alias is already in use.




## Method `set_jointype`
In class: [dependencies\Table](#top)

```
self dependencies\Table::set_jointype(string $type)
```

Sets join type for the latest JOIN.



* Visibility: **public**

#### Arguments

* $type **string** - Any of the following: `&quot;LEFT&quot;`, `&quot;RIGHT&quot;`, `&quot;INNER&quot;`.


#### Return value

**self** - Chaining enabled.







## Method `sk`
In class: [dependencies\Table](#top)

```
self dependencies\Table::sk()
```

Filter by secondary keys.

This works the same as {@link self::pk()}, except it adds filters for the secondary
keys defined in the model. Secondary keys are not unique, and therefore filtering by
them does not imply a single result like primary key filtering does.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.




#### Throws exceptions

* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If The number of given keys doesn&#039;t match the
                                   amount of secondary keys defined in the model.




## Method `subquery`
In class: [dependencies\Table](#top)

```
self dependencies\Table::subquery(self $q)
```

Creates a new query in the context of this one.



* Visibility: **public**

#### Arguments

* $q **self** - An out-parameter which will receive the Table object that represents the sub-query.


#### Return value

**self** - Chaining enabled.







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
self dependencies\Table::where()
```

Add to the WHERE clause.

This method can be used in 2 different ways. Please refer to &lt;code&gt;where1&lt;/code&gt; and &lt;code&gt;where2&lt;/code&gt; for the documentation.

* Visibility: **public**


#### Return value

**self** - Chaining enabled.







## Method `workwith`
In class: [dependencies\Table](#top)

```
self dependencies\Table::workwith(string $id)
```

Set the working model.



* Visibility: **public**

#### Arguments

* $id **string** - The internal ID of the model to set as working model.


#### Return value

**self** - Chaining enabled.







## Method `write`
In class: [dependencies\Table](#top)

```
self dependencies\Table::write(string $as)
```

Print the query to the output.

&lt;strong&gt;This method may be used for debugging purposed and it is not recommended to have it
in any final code.&lt;/strong&gt;

* Visibility: **public**

#### Arguments

* $as **string** - An optional model ID in which the results will be returned.


#### Return value

**self** - Chaining enabled.




#### Throws exceptions

* **[exception\NotFound](../exception/NotFound.md)** - If the given model ID does not point to a known model.
* **[exception\Sql](../exception/Sql.md)** - If an SQL error occurs.




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
string dependencies\Table::_get_subquery()
```

Build the query and return it for use as a sub-query.



* Visibility: **private**



#### Throws exceptions

* **[exception\Programmer](../exception/Programmer.md)** - If no columns have been explicitly selected in the query.




## Method `arguments_to_comparisons`
In class: [dependencies\Table](#top)

```
string dependencies\Table::arguments_to_comparisons()
```

Used to convert given arguments to a WHERE or HAVING string.



* Visibility: **private**


#### Return value

**string** - The finished comparison-string.







## Method `compose_condition`
In class: [dependencies\Table](#top)

```
string dependencies\Table::compose_condition(array $condition)
```

Converts an array to a comparison-string.

Used by &lt;code&gt;conditions_to_comparisons&lt;/code&gt; in order to convert Condition formatted arrays to
comparison formatted strings.

* Visibility: **private**

#### Arguments

* $condition **array**


#### Return value

**string** - Comparison.







## Method `conditions_to_comparisons`
In class: [dependencies\Table](#top)

```
string dependencies\Table::conditions_to_comparisons(\dependencies\Conditions $conditions)
```

Used to convert a given Conditions object to a WHERE or HAVING string.



* Visibility: **private**

#### Arguments

* $conditions **[dependencies\Conditions](../dependencies/Conditions.md)** - The Conditions object to use.


#### Return value

**string** - The resulting comparison-string.







## Method `get_column_info`
In class: [dependencies\Table](#top)

```
array dependencies\Table::get_column_info(string $input)
```

Normalizes a string representing a column into an array of meta-data.



* Visibility: **private**

#### Arguments

* $input **string** - Columns have the following format:
                     `&quot;[[&lt;component_name&gt;.]&lt;model_name&gt;.]&lt;column_name&gt;&quot;`.
                     * `&lt;column_name&gt;`: The name of the column. This has to be present in the string.
                     * `&lt;model_name&gt;`: An optional alternative model may be prepended
                       to the column-name using a `.` as separator. This has to be
                       an internal model ID!
                     * `&lt;component_name&gt;`: If the model name was given, an optional
                       component name may be prepended to that using a `.`, in which
                       case this component will be used to look for the model in.


#### Return value

**array** - An associative array with the following keys:
              * `component`: The name of the component.
              * `model`: The internal ID of the model.
              * `name`: The name of the column.







## Method `get_model_info`
In class: [dependencies\Table](#top)

```
array dependencies\Table::get_model_info(\dependencies\Table|string $input)
```

Normalizes several different inputs that represent a model to an array of meta-data.



* Visibility: **private**

#### Arguments

* $input **[dependencies\Table](../dependencies/Table.md)|string** - When given input is a table, its
                           `_get_model_subquery`-method will be used to attain the
                           array of meta-data. When it is a string, it must have the
                           following format: `&quot;[&lt;component_name&gt;.]&lt;model_name&gt;&quot;`.
                           * `&lt;component_name&gt;`: The name of the component that houses
                             the model.
                           * `&lt;model_name&gt;`: The name of the model (class name).


#### Return value

**array** - An array with the following keys:
              * `component`: The name of the component that houses the model.
              * `name`: The name of the model.
              * `path`: The full class-name of the model.
              * `table`: The table name corresponding to the model.
              * `relations`: Cached inter-tabular relations defined in the model.
              * `id`: The internal ID assigned to the model.







## Method `grourder`
In class: [dependencies\Table](#top)

```
string dependencies\Table::grourder(string $c, string $d)
```

Combine group and order because they are similar in syntax.



* Visibility: **private**

#### Arguments

* $c **string** - Column name.
* $d **string** - Direction.


#### Return value

**string** - The resulting MySQL.







## Method `prepare`
In class: [dependencies\Table](#top)

```
string dependencies\Table::prepare(\dependencies\Table|array|string|integer $input)
```

Detect what input could be, and prepare it for insertion into the query.



* Visibility: **private**

#### Arguments

* $input **[dependencies\Table](../dependencies/Table.md)|array|string|integer** - * `Table`: Will be used as a sub-query.
       * `array`: Will be converted to a comma-separated list of values.
       * `&quot;NULL&quot;`: Will become `NULL`.
       * `integer`: And numeric strings will be used as numbers.
       * `string`: Words with periods and text between (\`)-marks will be used as a
         column-identifier, and parsed by `self::get_column_info()`. Text between
         quotation-marks, or with spaces or special characters will be interpreted as
         plain-text, and sanitized by `self::prepare_text()`.


#### Return value

**string** - The prepared value.







## Method `prepare_column`
In class: [dependencies\Table](#top)

```
string dependencies\Table::prepare_column(string|array $column)
```

Normalizes several different inputs which represent a column into a string.



* Visibility: **private**

#### Arguments

* $column **string|array**






## Method `prepare_text`
In class: [dependencies\Table](#top)

```
string dependencies\Table::prepare_text(string $text)
```

Sanitizes and normalizes text-input.



* Visibility: **private**

#### Arguments

* $text **string**






## Method `whaving`
In class: [dependencies\Table](#top)

```
string dependencies\Table::whaving()
```

Combine where and having because they are similar in syntax.



* Visibility: **private**


#### Return value

**string** - The resulting MySQL.






