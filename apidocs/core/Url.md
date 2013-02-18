# core\Url
[API index](../API-index.md)






* Class name: Url
* Namespace: core




## Class index
**Constants**
* [`  ALL`](#constant-all)
* [`  ANCHOR`](#constant-anchor)
* [`  DOMAIN`](#constant-domain)
* [`  FILE`](#constant-file)
* [`  PATH`](#constant-path)
* [`  QUERY`](#constant-query)
* [`  SCHEME`](#constant-scheme)

**Properties**
* [`public mixed $redirect_url`](#property-redirect_url)
* [`public mixed $redirected`](#property-redirected)
* [`public mixed $referer_url`](#property-referer_url)
* [`public mixed $url`](#property-url)

**Methods**
* [`public mixed cancel_redirect()`](#method-cancel_redirect)
* [`public mixed init()`](#method-init)
* [`public mixed parse($url, $flags)`](#method-parse)
* [`public mixed previous($allow_external, $allow_backend_to_frontend)`](#method-previous)
* [`public mixed redirect($url)`](#method-redirect)





# Constants


## Constant `ALL`
In class: [core\Url](#top)

```
const ALL = 0
```





## Constant `ANCHOR`
In class: [core\Url](#top)

```
const ANCHOR = 32
```





## Constant `DOMAIN`
In class: [core\Url](#top)

```
const DOMAIN = 2
```





## Constant `FILE`
In class: [core\Url](#top)

```
const FILE = 8
```





## Constant `PATH`
In class: [core\Url](#top)

```
const PATH = 4
```





## Constant `QUERY`
In class: [core\Url](#top)

```
const QUERY = 16
```





## Constant `SCHEME`
In class: [core\Url](#top)

```
const SCHEME = 1
```





# Properties


## Property `$redirect_url`
In class: [core\Url](#top)

```
public mixed $redirect_url = null
```





* Visibility: **public**


## Property `$redirected`
In class: [core\Url](#top)

```
public mixed $redirected = false
```





* Visibility: **public**


## Property `$referer_url`
In class: [core\Url](#top)

```
public mixed $referer_url = false
```





* Visibility: **public**


## Property `$url`
In class: [core\Url](#top)

```
public mixed $url
```





* Visibility: **public**


# Methods


## Method `cancel_redirect`
In class: [core\Url](#top)

```
mixed core\Url::cancel_redirect()
```





* Visibility: **public**



## Method `init`
In class: [core\Url](#top)

```
mixed core\Url::init()
```





* Visibility: **public**



## Method `parse`
In class: [core\Url](#top)

```
mixed core\Url::parse($url, $flags)
```





* Visibility: **public**

#### Arguments

* $url **mixed**
* $flags **mixed**



## Method `previous`
In class: [core\Url](#top)

```
mixed core\Url::previous($allow_external, $allow_backend_to_frontend)
```





* Visibility: **public**

#### Arguments

* $allow_external **mixed**
* $allow_backend_to_frontend **mixed**



## Method `redirect`
In class: [core\Url](#top)

```
mixed core\Url::redirect($url)
```





* Visibility: **public**

#### Arguments

* $url **mixed**


