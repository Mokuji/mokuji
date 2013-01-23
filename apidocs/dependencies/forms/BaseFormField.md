# dependencies\forms\BaseFormField






* Class name: BaseFormField
* Namespace: dependencies\forms
* This is an **abstract** class




## Class index

**Properties**
* [`protected mixed $column_name`](#property-$column_name)
* [`protected mixed $insert_value`](#property-$insert_value)
* [`protected mixed $model`](#property-$model)
* [`protected mixed $title`](#property-$title)
* [`protected mixed $value`](#property-$value)

**Methods**
* [`public mixed __construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)`](#method-__construct)
* [`public mixed render(array $options)`](#method-render)







Properties
----------


### Property `$column_name`

```
protected mixed $column_name
```





* Visibility: **protected**


### Property `$insert_value`

```
protected mixed $insert_value
```





* Visibility: **protected**


### Property `$model`

```
protected mixed $model
```





* Visibility: **protected**


### Property `$title`

```
protected mixed $title
```





* Visibility: **protected**


### Property `$value`

```
protected mixed $value
```





* Visibility: **protected**


Methods
-------


### Method `__construct`

```
mixed dependencies\forms\BaseFormField::__construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)
```

Initiates a new form field.



* Visibility: **public**

#### Arguments

* $column_name **string** - The table column name for this field.
* $title **string** - The preferred and translated title to use for this field.
* $model **[dependencies\BaseModel](/apidocs/dependencies/BaseModel.md)** - The model that this field is related to.
* $options **array** - An optional set of options to further customize this field.



### Method `render`

```
mixed dependencies\forms\BaseFormField::render(array $options)
```

Outputs this field to the output stream.



* Visibility: **public**

#### Arguments

* $options **array** - An optional set of options to further customize the rendering of this field.


