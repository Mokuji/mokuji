# dependencies\forms\TextAreaField






* Class name: TextAreaField
* Namespace: dependencies\forms
* Parent class: [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)




## Class index

**Properties**

**Methods**
* [`public mixed render(array $options)`](#method-render)


## Inheritance index

**Properties**
* `protected mixed $column_name`
* `protected mixed $insert_value`
* `protected mixed $model`
* `protected mixed $title`
* `protected mixed $value`

**Methods**
* `public mixed __construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)`



Properties
----------


### Property `$column_name`

```
protected mixed $column_name
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)


### Property `$insert_value`

```
protected mixed $insert_value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)


### Property `$model`

```
protected mixed $model
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)


### Property `$title`

```
protected mixed $title
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)


### Property `$value`

```
protected mixed $value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)


Methods
-------


### Method `__construct`

```
mixed dependencies\forms\BaseFormField::__construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)
```

Initiates a new form field.



* Visibility: **public**
* This method is defined by [dependencies\forms\BaseFormField](/apidocs/dependencies/forms/BaseFormField.md)

#### Arguments

* $column_name **string** - The table column name for this field.
* $title **string** - The preferred and translated title to use for this field.
* $model **[dependencies\BaseModel](/apidocs/dependencies/BaseModel.md)** - The model that this field is related to.
* $options **array** - An optional set of options to further customize this field.



### Method `render`

```
mixed dependencies\forms\TextAreaField::render(array $options)
```

Outputs this field to the output stream.



* Visibility: **public**

#### Arguments

* $options **array** - An optional set of options to further customize the rendering of this field.


