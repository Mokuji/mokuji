# dependencies\init\Environments
[API index](../../API-index.md)

A static class that helps you to initialize Mokuji environments.




* Class name: Environments
* Namespace: dependencies\init
* This is an **abstract** class




## Class index


**Methods**
* [`public static void on_run(\dependencies\init\Initializer $init, integer $environment)`](#method-on_run)
* [`public static void on_set(\dependencies\init\Initializer $init, integer $environment)`](#method-on_set)









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





