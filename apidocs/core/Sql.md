# core\Sql
[API index](../API-index.md)






* Class name: Sql
* Namespace: core




## Class index

**Properties**
* [`private mixed $connection`](#property-connection)
* [`private mixed $prefix`](#property-prefix)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed __destruct()`](#method-__destruct)
* [`public mixed conditions($c)`](#method-conditions)
* [`public mixed escape($value)`](#method-escape)
* [`public mixed execute_non_query($query)`](#method-execute_non_query)
* [`public mixed execute_query($query)`](#method-execute_query)
* [`public mixed execute_scalar($query)`](#method-execute_scalar)
* [`public mixed execute_single($query)`](#method-execute_single)
* [`public mixed get_insert_id()`](#method-get_insert_id)
* [`public mixed get_prefix()`](#method-get_prefix)
* [`public mixed make_query()`](#method-make_query)
* [`public mixed model($component_name, $model_name)`](#method-model)
* [`public mixed query($query)`](#method-query)
* [`public mixed set_connection_data($host, $user, $pass, $name, $prefix)`](#method-set_connection_data)
* [`public mixed sub_table($component_name, $model_name, array $select)`](#method-sub_table)
* [`public mixed table($component_name, $model_name, $id)`](#method-table)







# Properties


## Property `$connection`

```
private mixed $connection
```





* Visibility: **private**


## Property `$prefix`

```
private mixed $prefix
```





* Visibility: **private**


# Methods


## Method `__construct`

```
mixed core\Sql::__construct()
```





* Visibility: **public**



## Method `__destruct`

```
mixed core\Sql::__destruct()
```





* Visibility: **public**



## Method `conditions`

```
mixed core\Sql::conditions($c)
```





* Visibility: **public**

#### Arguments

* $c **mixed**



## Method `escape`

```
mixed core\Sql::escape($value)
```





* Visibility: **public**

#### Arguments

* $value **mixed**



## Method `execute_non_query`

```
mixed core\Sql::execute_non_query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



## Method `execute_query`

```
mixed core\Sql::execute_query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



## Method `execute_scalar`

```
mixed core\Sql::execute_scalar($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



## Method `execute_single`

```
mixed core\Sql::execute_single($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



## Method `get_insert_id`

```
mixed core\Sql::get_insert_id()
```





* Visibility: **public**



## Method `get_prefix`

```
mixed core\Sql::get_prefix()
```





* Visibility: **public**



## Method `make_query`

```
mixed core\Sql::make_query()
```





* Visibility: **public**



## Method `model`

```
mixed core\Sql::model($component_name, $model_name)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**



## Method `query`

```
mixed core\Sql::query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



## Method `set_connection_data`

```
mixed core\Sql::set_connection_data($host, $user, $pass, $name, $prefix)
```





* Visibility: **public**

#### Arguments

* $host **mixed**
* $user **mixed**
* $pass **mixed**
* $name **mixed**
* $prefix **mixed**



## Method `sub_table`

```
mixed core\Sql::sub_table($component_name, $model_name, array $select)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**
* $select **array**



## Method `table`

```
mixed core\Sql::table($component_name, $model_name, $id)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**
* $id **mixed**


