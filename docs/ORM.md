# Using the Mokuji ORM

## Introduction

"ORM" Stands for
[Object Relational Mapping<sup>wiki</sup>](https://en.wikipedia.org/wiki/Object_relational_mapping).
In short; an ORM is a technique in which software will map rows of an external database to
internal objects. Those objects can then be modified using the class methods available on
it, and synchronised back with the external database afterwards.

In Mokuji, when we use the query builder class
([Table<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/apidocs/dependencies/Table.md))
to access the database, results will be mapped to
[Resultset<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/apidocs/dependencies/Resultset.md)
objects, in which every row is mapped to a model.

In this guide we will learn to use the Table class to easily and efficiently write MySQL
queries, how to access the query results using the Resultset class and how to work with
models; Using them to edit or create new database rows and even how to define our own
models to use in conjunction with the Table class.

## Table of Contents

<!-- MarkdownTOC - -->
- The basics
  * Preparing
  * Fetching rows
      - Fetching all rows
      - Filtering the query
      - Traversing rows
      - Fetching a single row by primary key
  * Working with a row (model)
- Advanced guide
  * Building the query
      - Adding models (MySQL tables)
      - Accessing columns
      - Joining models
      - Creating sub-queries
      - Hierarchy
      - Other clauses
  * Executing the query
  * Accessing the results
      - The Data class
      - Traversing hierarchically structured results
- Using the Conditions class
- Creating and using models
  * Modifying rows with the model
  * Creating new rows with the model
  * Extending the BaseModel
      - Defining relations
      - Defining custom getter
      - Defining hierarchical structures
    
<!-- /MarkdownTOC - -->

## The basics

### Preparing

To start building a query, we must acquire an instance of Table. We do this using the Sql
[core class<sup>guide</sup>](#Core-classes) of which the `table()` method will generate
such an instance for us:

```php
$component_name = 'menu';
$model_name = 'MenuItems';

//Create an instance of Table.
tx('Sql')->table($component_name, $model_name, $MI);
```

Alternatively, if we are already working inside a component (like one of its models or
controllers), we can use the `table()`-helper, which already uses the right component
name (assume we are in a class within the `menu`-component):

```php
$model_name = 'MenuItems'

//Create an instance of Table.
$this->table($model_name, $MI);
```

The last parameter (`$MI`) that we gave to both methods is an out-parameter. Pass it to
the method as an empty variable, and it will get a value assigned to it. In this case it
gets the internal ID of the model assigned. Hence the name "MI", for "MenuItems" (though
you may name it any way you want). Many of the more advanced methods used to build the
query require us to use this variable, you don't have to pass it if you don't need it.

### Fetching rows

After instantiating the Table class as described in the previous section, we can start
chaining query-builder methods onto it. These methods are used to let the table class
generate the required MySQL for the clauses in the eventual MySQL query.

#### Fetching all rows

Simply
[`execute()`<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-execute):
the query straight away:

```php
$rows = $this->table('MenuItems')->execute();
```

#### Filtering the query

We can use the
[`filter()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-filter)
to add filters directly from the GET parameters.

```php
//Fetch all MenuItemInfo that has an "item_id" equal to the value in $_GET['m'].
$rows = $this->table('MenuItemInfo')->filter('m', 'item_id')->execute();
```

Besides GET parameters, filter also looks for values in the session set by
`create_filter()` in components:

```php
//Create a filter in the SESSION.
$this->create_filter('menu_item_id', 2);

//Fetch all MenuItemInfo that has an "item_id" equal to the value we just made in the filter.
$rows = $this->table('MenuItemInfo')->filter('menu_item_id', 'item_id')->execute();
```

If a filter key is available in both GET and SESSION, the GET filter will be used.

To create direct filters (not using the parameters in GET or SESSION) we can use the
[`where()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-where).

```
//Fetch all MenuItemInfo that has an "item_id" equal to 1.
$rows = $this->table('MenuItemInfo')->where('item_id', 1)->execute();
```

#### Traversing rows

After a set of rows is retrieved we can iterate every row like so:

```php
$rows->each(function($row){
  //We can access every row here.
  $row->id; //1, 2, 3, 4...
});
```

More information about what you can do with a set of rows can be found further down the
page in the section about [accessing the results<sup>#</sup>](#accessing-the-results).

#### Fetching a single row by primary key

The
[`pk()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-pk)
can be used for this in combination with
[`execute_single()`<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-execute-single):

```php
//Select the MenuItem with "id" 3.
$row = $this->table('MenuItems')->pk(3)->execute_single();

//We can now access the row.
$row->id; //3
```

### Working with a row (model)

Simply change the properties on the model, they may to the fields in the database:

```php
//Consider this query:
$row = $this->table('MenuItemInfo')->pk(1)->execute_single();

//We can edit the title as such:
$row->title = 'Home';

//Or edit multiple fields as such:
$row->merge(array(
  'title' => 'Home',
  'description' => 'A link to the home-page'
));

//After we're done, we save the model to synchronise it back with the database.
$row->save();
```

More information on [how to work with models<sup>#</sup>](#creating-and-using-models) can
be found further down the page.

## Advanced guide

### Building the query

#### Adding models (MySQL tables)

By default, a Table instance uses one model (the one provided on instantiation) and
performs all operations with this model. This model is therefore called the "working
model". It is, however, very easy to add more models. The easiest way is to use the
[`add()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-add).
This method adds the model of the given name to the FROM clause, and makes it the new
working model:

```php
$this->table('MenuItems', $MI)->add('MenuItemInfo', $MII);
```

Just like when passing a model name to the constructor, this method also allows for an
out-parameter that gets the internal model ID. One way to use these ID's (`$MI` and
`$MII`) is to switch between which model is the working model:

```php
//Create a Table instance in which MenuItems is the working model.
$this->table('MenuItems', $MI)

//Adding MenuItemInfo makes that the new working model.
->add('MenuItemInfo', $MII)

//Make MenuItems the working model again.
->workwith($MI)

//Or switch back to MenuItemInfo
->workwith($MII);
```

So far, we haven't used the working model yet, but if you continue reading you'll see how
useful it is! Basically the working model is the model that is used every time a method
needs a table name for the query, for instance when [accessing a column<sup>#</sup>](#accessing-columns).

Another way to add models is by joining them using the
[`join`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-join).
This opens up so many features that it has its [own section<sup>#</sup>](#joining-models).

#### Accessing columns

As mentioned before, many methods allow column-names to be used, most prominently when
[creating filters<sup>#</sup>](#creating-filters). Columns are associated with their
models (tables) and by default, when we pass a column name, the method will use the
**working model** to look in for the column. You can, however, use an explicit model when
passing a column name. Let's look at two different ways to select from a model explicitly:

```php
//Create a query builder.
$this->table('MenuItems', $MI)

//Add another model (this is now the working model).
->add('MenuItemInfo', $MII)

//Now let's say we want to filter on the ID of the first model ($MI).

//Method 1: Changing the working model.
//This is not very elegant.
->workwith($MI)->where('id', 1)->workwith($MII)

//Method 2: Use an explicit column name.
->where("$MI.id", 1)
```

Explicit column names contain the ID of the model, but do not change the working model.
This allows for very quick access to a column on a model different from the working model.

#### Joining models

Joining a model is basically the advanced way to
[add a model<sup>#</sup>](#adding-models-mysql-tables) to the query. It is done using the
[`join()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-join)
and it allows for filters to be created that restrict which rows of the foreign model will
be added to each row of the local model. The easiest way to join a model is by letting the
system generate these filters using the "relations" data
[defined<sup>#</sup>](#defining-relations) in the model.

Assuming relations between models have already been set up, this is what joining a model
will look like:

```php
//Create a query builder.
$this->table('MenuItems', $MI)

//Join a foreign model.
->join('MenuItemInfo', $MII)
```

It's as simple as that. The system will find the relations between `MenuItems` (The local
model) and `MenuItemInfo` (The foreign model), and join them together using automatically
generated join-conditions.

If we need more advanced join-conditions, however, there is a relatively easy way to
modify them: Simply pass a
[Closure<sup>API</sup>](http://www.php.net/manual/en/functions.anonymous.php) as a third
argument:

```php
->join('MenuItemInfo', $MII, function($MI, $MII, $conditions){
  $conditions->add('id_to_id', array("$MI.id", "$MII.id"))->utilize('id_to_id');
});
```

As shown, the Closure receives the ID of the local model, the ID of the foreign model and
a Conditions object. With these parameters we can create our own set of conditions by
[using the Conditions class<sup>#</sup>](#using-the-conditions-class).

#### Creating sub-queries

Any Table object can function as a sub-query, as long as a has
[explicitly selected<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-select)
the columns. It can be used in the query as a sub-query by passing it anywhere one might
want it to go:

```php
//Pre-define a sub-query with an explicitly selected column.
$sub = $this->table('MenuItemInfo')->select('id');

//Use the sub-query. For instance in a WHERE clause.
$this->table('MenuItems')->where('id', 'IN', $sub);
```

In this example, the sub-query is pre-defined and completely separate from the main query
before it was inserted into it. A better way to create a Table instance that will function
as a sub-query is by calling the
[`subquery()`-method<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-subquery)
on the main Table instance. This will do two things for us:

1. It makes the two queries share their models. This has no side-effects on its own, but
   can be used to access a model of the main query from within the sub-query, and
   depending on where the sub-query is going to be used, this may be required.
2. It allows for in-line building of a sub-query instead of having to pre-define it. This
   is a much requested feature to improve the flow of building the query and is
   demonstrated below:

```php
//Start the query.
$this->table('MenuItems')

//Create a sub-query.
->subquery($sub, 'MenuItemInfo', function($sub){
  $sub->select('id');
})

//Use the newly created sub-query somewhere.
->where('id', 'IN', $sub);
```

#### Hierarchy

A big feature in this ORM is how easily it allows for working with hierarchically
structured tables. A full guide on this can be found [here<sup>guide</sup>](#).

#### Other clauses

For adding any of the SQL clauses, that weren't covered in this guide, to the query please
refer to the
[API documentation](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md).

### Executing the query

Right. So we've "built" our query, that is, added all the clauses, models, sub-queries and
hierarchies we wanted to add. How do we proceed?

By executing the query! There are two methods that do this for us:

- [`execute()`<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-execute)
  Will query the server and return the results in a
  [Resultset<sup>#</sup>](#accessing-the-results) object.

- [`execute_single()`<sup>API</sup>](https://github.com/Tuxion/mokuji/blob/master/mokuji/apidocs/dependencies/Table.md#method-execute-single)
  Will limit the result-set to a single result, query the server and return the first model
  from the result-set straight away.

### Accessing the results

#### The Data class

#### Traversing hierarchically structured results

## Using the Conditions class

## Creating and using models

### Modifying rows with the model

### Creating new rows with the model

### Extending the BaseModel

#### Defining relations
#### Defining custom getter
#### Defining hierarchical structures
