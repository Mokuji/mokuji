# core\Url
[API index](../API-index.md)






* Class name: Url
* Namespace: core




## Class index
**Constants**
* [`ALL`](#constant-all)
* [`ANCHOR`](#constant-anchor)
* [`DOMAIN`](#constant-domain)
* [`FILE`](#constant-file)
* [`PATH`](#constant-path)
* [`QUERY`](#constant-query)
* [`SCHEME`](#constant-scheme)

**Properties**
* [`public static mixed $TOP_LEVEL_DOMAINS`](#property-top_level_domains)
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


## Property `$TOP_LEVEL_DOMAINS`
In class: [core\Url](#top)

```
public mixed $TOP_LEVEL_DOMAINS = array('aero', 'asia', 'biz', 'cat', 'com', 'coop', 'info', 'int', 'jobs', 'mobi', 'museum', 'name', 'net', 'org', 'post', 'pro', 'tel', 'travel', 'xxx', 'edu', 'gov', 'mil', 'ac', 'ad', 'ae', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'as', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'cr', 'cs', 'cu', 'cv', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'ee', 'eg', 'eh', 'er', 'es', 'et', 'eu', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd', 'ge', 'gf', 'gg', 'gh', 'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy', 'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'iq', 'ir', 'is', 'it', 'je', 'jm', 'jo', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly', 'ma', 'mc', 'md', 'me', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'nc', 'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'pa', 'pe', 'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py', 'qa', 're', 'ro', 'rs', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'ss', 'st', 'su', 'sv', 'sx', 'sy', 'sz', 'tc', 'td', 'tf', 'tg', 'th', 'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'tp', 'tr', 'tt', 'tv', 'tw', 'tz', 'ua', 'ug', 'uk', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn', 'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm', 'zw', 'arpa')
```





* Visibility: **public**
* This property is **static**.


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





