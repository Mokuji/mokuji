# dependencies\init\Defines
[API index](../../API-index.md)

A static class that allows you to initialize Mokuji defines.




* Class name: Defines
* Namespace: dependencies\init
* This is an **abstract** class




## Class index


**Methods**
* [`public static void map_values($site, $https, $is_installed, $debugging)`](#method-map_values)
* [`public static void persistent_defines()`](#method-persistent_defines)









# Methods


## Method `map_values`
In class: [dependencies\init\Defines](#top)

```
void dependencies\init\Defines::map_values($site, $https, $is_installed, $debugging)
```

Initializes the mapped defined values.

They are the ones that may differ per page load.

* Visibility: **public**
* This method is **static**.

#### Arguments

* $site **mixed**
* $https **mixed**
* $is_installed **mixed**
* $debugging **mixed**






## Method `persistent_defines`
In class: [dependencies\init\Defines](#top)

```
void dependencies\init\Defines::persistent_defines()
```

Initializes the persistent defined values.

They are the ones that don't change at all.

* Visibility: **public**
* This method is **static**.





