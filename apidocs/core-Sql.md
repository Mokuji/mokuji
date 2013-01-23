# core\Sql






* Class name: Sql
* Namespace: core




## Class index

**Properties**
* `private mixed $connection`
* `private mixed $prefix`

**Methods**
* `public mixed __construct()`
* `public mixed __destruct()`
* `public mixed conditions($c)`
* `public mixed escape($value)`
* `public mixed execute_non_query($query)`
* `public mixed execute_query($query)`
* `public mixed execute_scalar($query)`
* `public mixed execute_single($query)`
* `public mixed get_insert_id()`
* `public mixed get_prefix()`
* `public mixed make_query()`
* `public mixed model($component_name, $model_name)`
* `public mixed query($query)`
* `public mixed set_connection_data($host, $user, $pass, $name, $prefix)`
* `public mixed sub_table($component_name, $model_name, array $select)`
* `public mixed table($component_name, $model_name, $id)`







Properties
----------


### $connection

```
private mixed $connection
```





* Visibility: **private**


### $prefix

```
private mixed $prefix
```





* Visibility: **private**


Methods
-------


### __construct

```
mixed core\Sql::__construct()
```





* Visibility: **public**



### __destruct

```
mixed core\Sql::__destruct()
```





* Visibility: **public**



### conditions

```
mixed core\Sql::conditions($c)
```





* Visibility: **public**

#### Arguments

* $c **mixed**



### escape

```
mixed core\Sql::escape($value)
```





* Visibility: **public**

#### Arguments

* $value **mixed**



### execute_non_query

```
mixed core\Sql::execute_non_query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



### execute_query

```
mixed core\Sql::execute_query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



### execute_scalar

```
mixed core\Sql::execute_scalar($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



### execute_single

```
mixed core\Sql::execute_single($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



### get_insert_id

```
mixed core\Sql::get_insert_id()
```





* Visibility: **public**



### get_prefix

```
mixed core\Sql::get_prefix()
```





* Visibility: **public**



### make_query

```
mixed core\Sql::make_query()
```





* Visibility: **public**



### model

```
mixed core\Sql::model($component_name, $model_name)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**



### query

```
mixed core\Sql::query($query)
```





* Visibility: **public**

#### Arguments

* $query **mixed**



### set_connection_data

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



### sub_table

```
mixed core\Sql::sub_table($component_name, $model_name, array $select)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**
* $select **array**



### table

```
mixed core\Sql::table($component_name, $model_name, $id)
```





* Visibility: **public**

#### Arguments

* $component_name **mixed**
* $model_name **mixed**
* $id **mixed**


