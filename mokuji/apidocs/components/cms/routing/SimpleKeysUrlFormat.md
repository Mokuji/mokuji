# components\cms\routing\SimpleKeysUrlFormat
[API index](../../../API-index.md)

The simple keys URL format class.

Example: /about
Detects, validates and formats various URLs.


* Class name: SimpleKeysUrlFormat
* Namespace: components\cms\routing
* Parent class: [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)




## Class index
**Constants**
* [`REGEX`](#constant-regex)

**Properties**
* [`protected static array $urlKeyMatches`](#property-urlkeymatches)

**Methods**
* [`public static boolean validate(string $url)`](#method-validate)
* [`public mixed __construct(string $url)`](#method-__construct)
* [`public mixed getLanguageId()`](#method-getLanguageId)
* [`public mixed getLanguageShortcode()`](#method-getLanguageShortcode)
* [`public integer getPageId()`](#method-getPageId)
* [`public string output(array $getData)`](#method-output)


## Inheritance index

**Properties**
* [`protected mixed $languageId`](#property-languageid)
* [`protected mixed $languageShortcode`](#property-languageshortcode)
* [`protected mixed $pageId`](#property-pageid)
* [`protected mixed $urlExtensions`](#property-urlextensions)
* [`protected mixed $urlKey`](#property-urlkey)

**Methods**
* [`public mixed __toString()`](#method-__toString)
* [`public mixed getUrlExtensions()`](#method-getUrlExtensions)
* [`public mixed getUrlKey()`](#method-getUrlKey)
* [`protected void fromUrlFormat(\components\cms\routing\UrlFormat $url)`](#method-fromUrlFormat)
* [`protected string idToShortcode(integer $id)`](#method-idToShortcode)
* [`protected array parseUrlExtensions(string $raw)`](#method-parseUrlExtensions)
* [`protected integer shortcodeToId(string $shortcode)`](#method-shortcodeToId)
* [`protected void useHomepage()`](#method-useHomepage)

# Constants


## Constant `REGEX`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
const mixed REGEX = '~^/([\w\-]{3,})(/?([\w\/\-]*))?$~'
```







# Properties


## Property `$urlKeyMatches`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected array $urlKeyMatches = array()
```

Caches the page ID matches for different URL-keys.

Array keys are lowercase URL-keys. Values are page IDs (integer).

* Visibility: **protected**
* This property is **static**.


## Property `$languageId`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected mixed $languageId = null
```





* Visibility: **protected**
* This property is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)


## Property `$languageShortcode`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected mixed $languageShortcode = null
```





* Visibility: **protected**
* This property is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)


## Property `$pageId`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected mixed $pageId = null
```





* Visibility: **protected**
* This property is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)


## Property `$urlExtensions`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected mixed $urlExtensions = array()
```





* Visibility: **protected**
* This property is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)


## Property `$urlKey`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
protected mixed $urlKey = null
```





* Visibility: **protected**
* This property is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)


# Methods


## Method `validate`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
boolean components\cms\routing\SimpleKeysUrlFormat::validate(string $url)
```

Validates the provided URL for formatting errors.



* Visibility: **public**
* This method is **static**.

#### Arguments

* $url **string** - The URL to validate the format of.


#### Return value

**boolean** - Whether or not the format was valid.







## Method `__construct`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\SimpleKeysUrlFormat::__construct(string $url)
```

Creates a new instance.



* Visibility: **public**

#### Arguments

* $url **string** - The URL to handle.






## Method `__toString`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::__toString()
```





* Visibility: **public**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)






## Method `getLanguageId`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\SimpleKeysUrlFormat::getLanguageId()
```





* Visibility: **public**






## Method `getLanguageShortcode`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\SimpleKeysUrlFormat::getLanguageShortcode()
```





* Visibility: **public**






## Method `getPageId`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
integer components\cms\routing\SimpleKeysUrlFormat::getPageId()
```

Overrides the standard getter.

Attempts to locate the page based on the current URL-key and globally caches the results.

* Visibility: **public**






## Method `getUrlExtensions`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getUrlExtensions()
```





* Visibility: **public**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)






## Method `getUrlKey`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getUrlKey()
```





* Visibility: **public**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)






## Method `output`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
string components\cms\routing\SimpleKeysUrlFormat::output(array $getData)
```

Outputs the current URL data into the format the class provides.



* Visibility: **public**

#### Arguments

* $getData **array** - The GET data to append to the URL when outputting


#### Return value

**string** - A formatted version of the URL data.







## Method `fromUrlFormat`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
void components\cms\routing\UrlFormat::fromUrlFormat(\components\cms\routing\UrlFormat $url)
```

Use another UrlFormat object as data source, rather than parsing strings.



* Visibility: **protected**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)

#### Arguments

* $url **[components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)** - The data source.






## Method `idToShortcode`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
string components\cms\routing\UrlFormat::idToShortcode(integer $id)
```

Gets a language shortcode based on it's ID.



* Visibility: **protected**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)

#### Arguments

* $id **integer**






## Method `parseUrlExtensions`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
array components\cms\routing\UrlFormat::parseUrlExtensions(string $raw)
```

Parses URL extensions.



* Visibility: **protected**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)

#### Arguments

* $raw **string**






## Method `shortcodeToId`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
integer components\cms\routing\UrlFormat::shortcodeToId(string $shortcode)
```

Gets a language ID based on it's shortcode.



* Visibility: **protected**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)

#### Arguments

* $shortcode **string**






## Method `useHomepage`
In class: [components\cms\routing\SimpleKeysUrlFormat](#top)

```
void components\cms\routing\UrlFormat::useHomepage()
```

If the format is used to load the homepage,
determine the information needed from the homepage setting.



* Visibility: **protected**
* This method is defined by [components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)





