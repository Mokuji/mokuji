# dependencies\forms\BaseFormField






* Class name: BaseFormField
* Namespace: dependencies\forms
* This is an **abstract** class




## Class index

**Properties**
* `protected mixed $column_name`
* `protected mixed $insert_value`
* `protected mixed $model`
* `protected mixed $title`
* `protected mixed $value`

**Methods**
* `public mixed __construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)`
* `public mixed render(array $options)`







Properties
----------


### $column_name

```
protected mixed $column_name
```





* Visibility: **protected**


### $insert_value

```
protected mixed $insert_value
```





* Visibility: **protected**


### $model

```
protected mixed $model
```





* Visibility: **protected**


### $title

```
protected mixed $title
```





* Visibility: **protected**


### $value

```
protected mixed $value
```





* Visibility: **protected**


Methods
-------


### __construct

```
mixed dependencies\forms\BaseFormField::__construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)
```

Initiates a new form field.



* Visibility: **public**

#### Arguments

* $column_name **string** - The table column name for this field.
* $title **string** - The preferred and translated title to use for this field.
* $model **[dependencies\BaseModel](dependencies-BaseModel)** - The model that this field is related to.
* $options **array** - An optional set of options to further customize this field.



### render

```
mixed dependencies\forms\BaseFormField::render(array $options)
```

Outputs this field to the output stream.



* Visibility: **public**

#### Arguments

* $options **array** - An optional set of options to further customize the rendering of this field.


