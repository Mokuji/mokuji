# core\Component
[API index](../API-index.md)

Provides core features to manage and access components.




* Class name: Component
* Namespace: core




## Class index

**Properties**
* [`private mixed $checks`](#property-checks)
* [`private mixed $components`](#property-components)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public \dependencies\BaseComponent actions(String $of)`](#method-actions)
* [`public boolean available(String $component_name)`](#method-available)
* [`public boolean check(String $component_name)`](#method-check)
* [`public mixed enter(String $component)`](#method-enter)
* [`public \dependencies\BaseComponent helpers(String $of)`](#method-helpers)
* [`public \dependencies\BaseComponent json(String $of)`](#method-json)
* [`public mixed load(String $component, String $part, boolean $instantiate)`](#method-load)
* [`public \dependencies\BaseViews modules(String $of)`](#method-modules)
* [`public \dependencies\BaseViews sections(String $of)`](#method-sections)
* [`public \dependencies\BaseViews views(String $of)`](#method-views)







# Properties


## Property `$checks`
In class: [core\Component](#top)

```
private mixed $checks = array()
```

Caches whether components are available and valid.



* Visibility: **private**


## Property `$components`
In class: [core\Component](#top)

```
private mixed $components
```

Keeps track of a components information that has been loaded.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [core\Component](#top)

```
mixed core\Component::__construct()
```

Initializes the class.



* Visibility: **public**






## Method `actions`
In class: [core\Component](#top)

```
\dependencies\BaseComponent core\Component::actions(String $of)
```

Returns an instance of the "Actions" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.






## Method `available`
In class: [core\Component](#top)

```
boolean core\Component::available(String $component_name)
```

Checks whether a component is available and has a valid structure.



* Visibility: **public**

#### Arguments

* $component_name **String** - The name of the component.






## Method `check`
In class: [core\Component](#top)

```
boolean core\Component::check(String $component_name)
```

Validates a component's folder structure.



* Visibility: **public**

#### Arguments

* $component_name **String** - The name of the component.



#### Throws exceptions

* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If the component name is empty.
* **[exception\InvalidArgument](../exception/InvalidArgument.md)** - If the component name contains invalid characters.
* **[exception\FileMissing](../exception/FileMissing.md)** - If the component does not exist.
* **[exception\FileMissing](../exception/FileMissing.md)** - If the component does not have Actions, Modules, Views or Sections.
* **[exception\FileMissing](../exception/FileMissing.md)** - If the component does not have includes, models or templates.
* **[exception\FileMissing](../exception/FileMissing.md)** - If the component does not have frontend, backend or global templates.




## Method `enter`
In class: [core\Component](#top)

```
mixed core\Component::enter(String $component)
```

Calls the entrance function of the components "EntryPoint" class



* Visibility: **public**

#### Arguments

* $component **String** - The component name.






## Method `helpers`
In class: [core\Component](#top)

```
\dependencies\BaseComponent core\Component::helpers(String $of)
```

Returns an instance of the "Helpers" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.






## Method `json`
In class: [core\Component](#top)

```
\dependencies\BaseComponent core\Component::json(String $of)
```

Returns an instance of the "Json" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.






## Method `load`
In class: [core\Component](#top)

```
mixed core\Component::load(String $component, String $part, boolean $instantiate)
```

Allows loading components and their parts.



* Visibility: **public**

#### Arguments

* $component **String** - The component name.
* $part **String** - The optional name of the part to load.
* $instantiate **boolean** - Whether or not to instantiate the requested part.


#### Return value

**mixed** - Returns null if `$part` is null, a boolean if `$instantiate` is false or the instantiated part if `$instantiate` is true.




#### Throws exceptions

* **[exception\NotFound](../exception/NotFound.md)** - If the loaded file does not contain the expected part.




## Method `modules`
In class: [core\Component](#top)

```
\dependencies\BaseViews core\Component::modules(String $of)
```

Returns an instance of the "Modules" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.






## Method `sections`
In class: [core\Component](#top)

```
\dependencies\BaseViews core\Component::sections(String $of)
```

Returns an instance of the "Sections" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.






## Method `views`
In class: [core\Component](#top)

```
\dependencies\BaseViews core\Component::views(String $of)
```

Returns an instance of the "Views" class for the given component.



* Visibility: **public**

#### Arguments

* $of **String** - The component name.





