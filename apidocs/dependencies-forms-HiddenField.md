# dependencies\forms\HiddenField






* Class name: HiddenField
* Namespace: dependencies\forms
* Parent class: [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)




## Class index

**Properties**

**Methods**
* `public mixed __construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)`
* `public mixed render(array $options)`


## Inheritance index

**Properties**
* `protected mixed $column_name`
* `protected mixed $insert_value`
* `protected mixed $model`
* `protected mixed $title`
* `protected mixed $value`

**Methods**



Properties
----------


### $column_name

```
protected mixed $column_name
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)


### $insert_value

```
protected mixed $insert_value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)


### $model

```
protected mixed $model
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)


### $title

```
protected mixed $title
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)


### $value

```
protected mixed $value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](dependencies-forms-BaseFormField)


Methods
-------


### __construct

```
mixed dependencies\forms\HiddenField::__construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)
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
mixed dependencies\forms\HiddenField::render(array $options)
```

Outputs this field to the output stream.



* Visibility: **public**

#### Arguments

* $options **array** - An optional set of options to further customize the rendering of this field.


