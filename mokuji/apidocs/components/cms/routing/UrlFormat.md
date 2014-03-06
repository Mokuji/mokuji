# components\cms\routing\UrlFormat
[API index](../../../API-index.md)

An abstract URL format class.

Validates and formats various URLs.


* Class name: UrlFormat
* Namespace: components\cms\routing
* This is an **abstract** class




## Class index

**Properties**
* [`protected mixed $languageId`](#property-languageid)
* [`protected mixed $languageShortcode`](#property-languageshortcode)
* [`protected mixed $pageId`](#property-pageid)
* [`protected mixed $urlExtensions`](#property-urlextensions)
* [`protected mixed $urlKey`](#property-urlkey)

**Methods**
* [`abstract public mixed __construct(string $url)`](#method-__construct)
* [`public mixed __toString()`](#method-__toString)
* [`public mixed getLanguageId()`](#method-getLanguageId)
* [`public mixed getLanguageShortcode()`](#method-getLanguageShortcode)
* [`public mixed getPageId()`](#method-getPageId)
* [`public mixed getUrlExtensions()`](#method-getUrlExtensions)
* [`public mixed getUrlKey()`](#method-getUrlKey)
* [`abstract public string output(array $getData)`](#method-output)
* [`protected void fromUrlFormat(\components\cms\routing\UrlFormat $url)`](#method-fromUrlFormat)
* [`protected string idToShortcode(integer $id)`](#method-idToShortcode)
* [`protected array parseUrlExtensions(string $raw)`](#method-parseUrlExtensions)
* [`protected integer shortcodeToId(string $shortcode)`](#method-shortcodeToId)
* [`protected void useHomepage()`](#method-useHomepage)







# Properties


## Property `$languageId`
In class: [components\cms\routing\UrlFormat](#top)

```
protected mixed $languageId = null
```





* Visibility: **protected**


## Property `$languageShortcode`
In class: [components\cms\routing\UrlFormat](#top)

```
protected mixed $languageShortcode = null
```





* Visibility: **protected**


## Property `$pageId`
In class: [components\cms\routing\UrlFormat](#top)

```
protected mixed $pageId = null
```





* Visibility: **protected**


## Property `$urlExtensions`
In class: [components\cms\routing\UrlFormat](#top)

```
protected mixed $urlExtensions = array()
```





* Visibility: **protected**


## Property `$urlKey`
In class: [components\cms\routing\UrlFormat](#top)

```
protected mixed $urlKey = null
```





* Visibility: **protected**


# Methods


## Method `__construct`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::__construct(string $url)
```

Creates a new instance.



* Visibility: **public**
* This method is **abstract**.

#### Arguments

* $url **string** - The URL to handle.






## Method `__toString`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::__toString()
```





* Visibility: **public**






## Method `getLanguageId`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getLanguageId()
```





* Visibility: **public**






## Method `getLanguageShortcode`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getLanguageShortcode()
```





* Visibility: **public**






## Method `getPageId`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getPageId()
```





* Visibility: **public**






## Method `getUrlExtensions`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getUrlExtensions()
```





* Visibility: **public**






## Method `getUrlKey`
In class: [components\cms\routing\UrlFormat](#top)

```
mixed components\cms\routing\UrlFormat::getUrlKey()
```





* Visibility: **public**






## Method `output`
In class: [components\cms\routing\UrlFormat](#top)

```
string components\cms\routing\UrlFormat::output(array $getData)
```

Outputs the current URL data into the format the class provides.



* Visibility: **public**
* This method is **abstract**.

#### Arguments

* $getData **array** - The GET data to append to the URL when outputting


#### Return value

**string** - A formatted version of the URL data.







## Method `fromUrlFormat`
In class: [components\cms\routing\UrlFormat](#top)

```
void components\cms\routing\UrlFormat::fromUrlFormat(\components\cms\routing\UrlFormat $url)
```

Use another UrlFormat object as data source, rather than parsing strings.



* Visibility: **protected**

#### Arguments

* $url **[components\cms\routing\UrlFormat](../../../components/cms/routing/UrlFormat.md)** - The data source.






## Method `idToShortcode`
In class: [components\cms\routing\UrlFormat](#top)

```
string components\cms\routing\UrlFormat::idToShortcode(integer $id)
```

Gets a language shortcode based on it's ID.



* Visibility: **protected**

#### Arguments

* $id **integer**






## Method `parseUrlExtensions`
In class: [components\cms\routing\UrlFormat](#top)

```
array components\cms\routing\UrlFormat::parseUrlExtensions(string $raw)
```

Parses URL extensions.



* Visibility: **protected**

#### Arguments

* $raw **string**






## Method `shortcodeToId`
In class: [components\cms\routing\UrlFormat](#top)

```
integer components\cms\routing\UrlFormat::shortcodeToId(string $shortcode)
```

Gets a language ID based on it's shortcode.



* Visibility: **protected**

#### Arguments

* $shortcode **string**






## Method `useHomepage`
In class: [components\cms\routing\UrlFormat](#top)

```
void components\cms\routing\UrlFormat::useHomepage()
```

If the format is used to load the homepage,
determine the information needed from the homepage setting.



* Visibility: **protected**





