# core\Config
[API index](../API-index.md)

Provides core features to manage and access configuration variables.




* Class name: Config
* Namespace: core




## Class index

**Properties**
* [`private mixed $site`](#property-site)
* [`private mixed $system`](#property-system)
* [`private mixed $user`](#property-user)

**Methods**
* [`public mixed __construct()`](#method-__construct)
* [`public mixed init()`](#method-init)
* [`public mixed site()`](#method-site)
* [`public mixed system()`](#method-system)
* [`public mixed user()`](#method-user)







# Properties


## Property `$site`
In class: [core\Config](#top)

```
private mixed $site
```

Holds site related configuration variables.



* Visibility: **private**


## Property `$system`
In class: [core\Config](#top)

```
private mixed $system
```

Holds system related configuration variables.



* Visibility: **private**


## Property `$user`
In class: [core\Config](#top)

```
private mixed $user
```

Holds user configured configuration variables.



* Visibility: **private**


# Methods


## Method `__construct`
In class: [core\Config](#top)

```
mixed core\Config::__construct()
```

Initializes the class.



* Visibility: **public**






## Method `init`
In class: [core\Config](#top)

```
mixed core\Config::init()
```

When we're not in the installation environment, loads user configuration from the database.



* Visibility: **public**






## Method `site`
In class: [core\Config](#top)

```
mixed core\Config::site()
```

Gets or sets site related configuration variables.

Usage:
  0 params returns Data of all configuration variables.
  1 param: String $key The key for the variable to get.
  2 params: String $key The key of the variable to set. mixed $val The value to set.

* Visibility: **public**






## Method `system`
In class: [core\Config](#top)

```
mixed core\Config::system()
```

Gets or sets system related configuration variables.

Usage:
  0 params returns Data of all configuration variables.
  1 param: String $key The key for the variable to get.
  2 params: String $key The key of the variable to set. mixed $val The value to set.

* Visibility: **public**






## Method `user`
In class: [core\Config](#top)

```
mixed core\Config::user()
```

Gets or sets user configured configuration variables.

Usage:
  0 params returns Data of all configuration variables.
  1 param: String $key The key for the variable to get.
  2 params: String $key The key of the variable to set. mixed $val The value to set.
  3 params: String $key The key of the variable to set. mixed $val The value to set. int $lang The optional language ID for which to store the value in the database.

* Visibility: **public**





