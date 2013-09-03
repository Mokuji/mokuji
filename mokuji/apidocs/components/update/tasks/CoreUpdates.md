# components\update\tasks\CoreUpdates
[API index](../../../API-index.md)






* Class name: CoreUpdates
* Namespace: components\update\tasks
* This is an **abstract** class




## Class index
**Constants**
* [`CORE_ADEPT_ALBATROSS`](#constant-core_adept_albatross)
* [`CORE_BALLISTIC_BADGER`](#constant-core_ballistic_badger)

**Properties**
* [`protected static mixed $cores`](#property-cores)

**Methods**
* [`public static array detect_cores()`](#method-detect_cores)
* [`public static mixed execute_file_transfer_actions(\dependencies\Data $files)`](#method-execute_file_transfer_actions)
* [`public static boolean need_core_upgrade()`](#method-need_core_upgrade)
* [`public static mixed replace_file_references($input, $matched)`](#method-replace_file_references)
* [`public static mixed suggest_file_transfer_actions()`](#method-suggest_file_transfer_actions)
* [`protected static mixed add_base($input)`](#method-add_base)
* [`protected static mixed detect_clean_moves($source_format, $target_format, $fallback)`](#method-detect_clean_moves)
* [`protected static mixed detect_deletables(array $locations, $post_delete)`](#method-detect_deletables)
* [`protected static mixed strip_base($input)`](#method-strip_base)





# Constants


## Constant `CORE_ADEPT_ALBATROSS`
In class: [components\update\tasks\CoreUpdates](#top)

```
const mixed CORE_ADEPT_ALBATROSS = 1
```







## Constant `CORE_BALLISTIC_BADGER`
In class: [components\update\tasks\CoreUpdates](#top)

```
const mixed CORE_BALLISTIC_BADGER = 2
```







# Properties


## Property `$cores`
In class: [components\update\tasks\CoreUpdates](#top)

```
protected mixed $cores
```





* Visibility: **protected**
* This property is **static**.


# Methods


## Method `detect_cores`
In class: [components\update\tasks\CoreUpdates](#top)

```
array components\update\tasks\CoreUpdates::detect_cores()
```

Detects cores present in order of age and whether they are marked as installed.



* Visibility: **public**
* This method is **static**.


#### Return value

**array** - The present cores in order of age.







## Method `execute_file_transfer_actions`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::execute_file_transfer_actions(\dependencies\Data $files)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $files **[dependencies\Data](../../../dependencies/Data.md)**






## Method `need_core_upgrade`
In class: [components\update\tasks\CoreUpdates](#top)

```
boolean components\update\tasks\CoreUpdates::need_core_upgrade()
```

Indicates whether or not the current setup needs a core upgrade.



* Visibility: **public**
* This method is **static**.






## Method `replace_file_references`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::replace_file_references($input, $matched)
```





* Visibility: **public**
* This method is **static**.

#### Arguments

* $input **mixed**
* $matched **mixed**






## Method `suggest_file_transfer_actions`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::suggest_file_transfer_actions()
```





* Visibility: **public**
* This method is **static**.






## Method `add_base`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::add_base($input)
```





* Visibility: **protected**
* This method is **static**.

#### Arguments

* $input **mixed**






## Method `detect_clean_moves`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::detect_clean_moves($source_format, $target_format, $fallback)
```





* Visibility: **protected**
* This method is **static**.

#### Arguments

* $source_format **mixed**
* $target_format **mixed**
* $fallback **mixed**






## Method `detect_deletables`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::detect_deletables(array $locations, $post_delete)
```





* Visibility: **protected**
* This method is **static**.

#### Arguments

* $locations **array**
* $post_delete **mixed**






## Method `strip_base`
In class: [components\update\tasks\CoreUpdates](#top)

```
mixed components\update\tasks\CoreUpdates::strip_base($input)
```





* Visibility: **protected**
* This method is **static**.

#### Arguments

* $input **mixed**





