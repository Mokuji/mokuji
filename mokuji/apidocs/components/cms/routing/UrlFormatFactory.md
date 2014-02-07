# components\cms\routing\UrlFormatFactory
[API index](../../../API-index.md)

An abstract URL format factory.

Detects, validates and formats various URLs.


* Class name: UrlFormatFactory
* Namespace: components\cms\routing
* This is an **abstract** class




## Class index


**Methods**
* [`public static \components\cms\routing\UrlFormat detect(mixed $url, boolean $homepage)`](#method-detect)
* [`public static \components\cms\routing\UrlFormat format(mixed $url, boolean $cast, boolean $homepage)`](#method-format)
* [`public static boolean validate(mixed $url)`](#method-validate)
* [`private static mixed getPrefferedFormatClassName()`](#method-getPrefferedFormatClassName)









# Methods


## Method `detect`
In class: [components\cms\routing\UrlFormatFactory](#top)

```
\components\cms\routing\UrlFormat components\cms\routing\UrlFormatFactory::detect(mixed $url, boolean $homepage)
```

Detects the URL format of the provided URL.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $url **mixed** - The URL to detect the format of. Must be either string or UrlFormat.
* $homepage **boolean** - &amp;$homepage Whether or not the URL got defaulted to the homepage.


#### Return value

**[components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)** - The format class handling this URL.







## Method `format`
In class: [components\cms\routing\UrlFormatFactory](#top)

```
\components\cms\routing\UrlFormat components\cms\routing\UrlFormatFactory::format(mixed $url, boolean $cast, boolean $homepage)
```

Formats a given URL to the preferred format.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $url **mixed** - The URL to format. Must be either string or UrlFormat.
* $cast **boolean** - &amp;$cast A boolean that indicates whether or not the URL has been cast in a new format.
* $homepage **boolean** - &amp;$homepage Whether or not the URL got defaulted to to the homepage.


#### Return value

**[components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)** - The format class handling this URL.







## Method `validate`
In class: [components\cms\routing\UrlFormatFactory](#top)

```
boolean components\cms\routing\UrlFormatFactory::validate(mixed $url)
```

Validates the provided URL for formatting errors.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $url **mixed** - The URL to validate the format of. Must be either string or UrlFormat.


#### Return value

**boolean** - Whether or not the format was valid.







## Method `getPrefferedFormatClassName`
In class: [components\cms\routing\UrlFormatFactory](#top)

```
mixed components\cms\routing\UrlFormatFactory::getPrefferedFormatClassName()
```





* Visibility: **private**
* This method is **static**.





