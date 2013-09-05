# dependencies\forms\RadioField
[API index](../../API-index.md)






* Class name: RadioField
* Namespace: dependencies\forms
* Parent class: [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)




## Class index

**Properties**
* [`protected mixed $option_set`](#property-option_set)

**Methods**
* [`public mixed __construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)`](#method-__construct)
* [`public mixed render(array $options)`](#method-render)


## Inheritance index

**Properties**
* [`protected mixed $column_name`](#property-column_name)
* [`protected mixed $form_id`](#property-form_id)
* [`protected mixed $insert_value`](#property-insert_value)
* [`protected mixed $model`](#property-model)
* [`protected mixed $title`](#property-title)
* [`protected mixed $value`](#property-value)

**Methods**



# Properties


## Property `$column_name`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $column_name
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


## Property `$form_id`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $form_id
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


## Property `$insert_value`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $insert_value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


## Property `$model`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $model
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


## Property `$option_set`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $option_set
```





* Visibility: **protected**


## Property `$title`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $title
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


## Property `$value`
In class: [dependencies\forms\RadioField](#top)

```
protected mixed $value
```





* Visibility: **protected**
* This property is defined by [dependencies\forms\BaseFormField](../../dependencies/forms/BaseFormField.md)


# Methods


## Method `__construct`
In class: [dependencies\forms\RadioField](#top)

```
mixed dependencies\forms\RadioField::__construct(string $column_name, string $title, \dependencies\BaseModel $model, array $options)
```

Initiates a new form field.



* Visibility: **public**

#### Arguments

* $column_name **string** - The table column name for this field.
* $title **string** - The preferred and translated title to use for this field.
* $model **[dependencies\BaseModel](../../dependencies/BaseModel.md)** - The model that this field is related to.
* $options **array** - An optional set of options to further customize this field.






## Method `render`
In class: [dependencies\forms\RadioField](#top)

```
mixed dependencies\forms\RadioField::render(array $options)
```

Outputs this field to the output stream.



* Visibility: **public**

#### Arguments

* $options **array** - An optional set of options to further customize the rendering of this field.





