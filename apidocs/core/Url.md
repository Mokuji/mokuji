# core\Url






* Class name: Url
* Namespace: core




## Class index
**Constants**
* [`  ALL`](#constant-ALL)
* [`  ANCHOR`](#constant-ANCHOR)
* [`  DOMAIN`](#constant-DOMAIN)
* [`  FILE`](#constant-FILE)
* [`  PATH`](#constant-PATH)
* [`  QUERY`](#constant-QUERY)
* [`  SCHEME`](#constant-SCHEME)

**Properties**
* [`public mixed $redirect_url`](#property-$redirect_url)
* [`public mixed $redirected`](#property-$redirected)
* [`public mixed $referer_url`](#property-$referer_url)
* [`public mixed $url`](#property-$url)

**Methods**
* [`public mixed cancel_redirect()`](#method-cancel_redirect)
* [`public mixed init()`](#method-init)
* [`public mixed parse($url, $flags)`](#method-parse)
* [`public mixed previous($allow_external, $allow_backend_to_frontend)`](#method-previous)
* [`public mixed redirect($url)`](#method-redirect)





Constants
----------


### Constant `ALL`

```
const ALL = 0
```





### Constant `ANCHOR`

```
const ANCHOR = 32
```





### Constant `DOMAIN`

```
const DOMAIN = 2
```





### Constant `FILE`

```
const FILE = 8
```





### Constant `PATH`

```
const PATH = 4
```





### Constant `QUERY`

```
const QUERY = 16
```





### Constant `SCHEME`

```
const SCHEME = 1
```





Properties
----------


### Property `$redirect_url`

```
public mixed $redirect_url = null
```





* Visibility: **public**


### Property `$redirected`

```
public mixed $redirected = false
```





* Visibility: **public**


### Property `$referer_url`

```
public mixed $referer_url = false
```





* Visibility: **public**


### Property `$url`

```
public mixed $url
```





* Visibility: **public**


Methods
-------


### Method `cancel_redirect`

```
mixed core\Url::cancel_redirect()
```





* Visibility: **public**



### Method `init`

```
mixed core\Url::init()
```





* Visibility: **public**



### Method `parse`

```
mixed core\Url::parse($url, $flags)
```





* Visibility: **public**

#### Arguments

* $url **mixed**
* $flags **mixed**



### Method `previous`

```
mixed core\Url::previous($allow_external, $allow_backend_to_frontend)
```





* Visibility: **public**

#### Arguments

* $allow_external **mixed**
* $allow_backend_to_frontend **mixed**



### Method `redirect`

```
mixed core\Url::redirect($url)
```





* Visibility: **public**

#### Arguments

* $url **mixed**


