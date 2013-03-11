# Superclass
[API index](API-index.md)

The Superclass that allows for the tx() notation of loading core classes.

Your main gateway of expression in the Tuxion CMS.


* Class name: Superclass
* Namespace: global




## Class index

**Properties**
* [`private static mixed $system`](#property-system)

**Methods**
* [`public static \Superclass get_instance()`](#method-get_instance)
* [`public Object load_class(String $class, Array $args)`](#method-load_class)







# Properties


## Property `$system`
In class: [Superclass](#top)

```
private mixed $system = array()
```

The private array that holds the core class singletons and an instance of itself.



* Visibility: **private**
* This property is **static**.


# Methods


## Method `get_instance`
In class: [Superclass](#top)

```
\Superclass Superclass::get_instance()
```

Retrieves the superclass singleton instance.

Note: uses lazy initiation.

* Visibility: **public**
* This method is **static**.



#### Throws exceptions

* **[exception\Unexpected](exception/Unexpected.md)**




## Method `load_class`
In class: [Superclass](#top)

```
Object Superclass::load_class(String $class, Array $args)
```

Loads the core class with the given name.



* Visibility: **public**

#### Arguments

* $class **String** - The name of the core class to load. (Case sensitive)
* $args **Array** - An optional array of arguments to supply to the `init` function if this is the first time it loads.


#### Return value

**Object** - The singleton object of the requested class.




#### Throws exceptions

* **[exception\FileMissing](exception/FileMissing.md)** - If the core class could not be found.



