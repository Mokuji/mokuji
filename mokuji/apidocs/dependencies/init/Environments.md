# dependencies\init\Environments
[API index](../../API-index.md)

A static class that helps you to initialize Mokuji environments.




* Class name: Environments
* Namespace: dependencies\init
* This is an **abstract** class




## Class index
**Constants**
* [`BACKEND`](#constant-backend)
* [`FRONTEND`](#constant-frontend)
* [`INSTALL`](#constant-install)
* [`MINIMAL`](#constant-minimal)
* [`REST`](#constant-rest)
* [`SHELL`](#constant-shell)


**Methods**
* [`public static void on_run(\dependencies\init\Initializer $init, integer $environment)`](#method-on_run)
* [`public static void on_set(\dependencies\init\Initializer $init, integer $environment)`](#method-on_set)





# Constants


## Constant `BACKEND`
In class: [dependencies\init\Environments](#top)

```
const mixed BACKEND = 2
```

Backend environment.





## Constant `FRONTEND`
In class: [dependencies\init\Environments](#top)

```
const mixed FRONTEND = 1
```

Frontend environment.





## Constant `INSTALL`
In class: [dependencies\init\Environments](#top)

```
const mixed INSTALL = 3
```

Install environment.





## Constant `MINIMAL`
In class: [dependencies\init\Environments](#top)

```
const mixed MINIMAL = 4
```

Minimal environment.





## Constant `REST`
In class: [dependencies\init\Environments](#top)

```
const mixed REST = 5
```

REST environment.





## Constant `SHELL`
In class: [dependencies\init\Environments](#top)

```
const mixed SHELL = 0
```

Shell environment.







# Methods


## Method `on_run`
In class: [dependencies\init\Environments](#top)

```
void dependencies\init\Environments::on_run(\dependencies\init\Initializer $init, integer $environment)
```

Performs environment specific logic to be performed when running an environment.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $init **[dependencies\init\Initializer](../../dependencies/init/Initializer.md)** - The initializer calling this function.
* $environment **integer** - The environment that has been set.






## Method `on_set`
In class: [dependencies\init\Environments](#top)

```
void dependencies\init\Environments::on_set(\dependencies\init\Initializer $init, integer $environment)
```

Performs verifications and operations before setting an environment.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $init **[dependencies\init\Initializer](../../dependencies/init/Initializer.md)** - The initializer calling this function.
* $environment **integer** - The environment that has been set.





