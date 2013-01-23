# core\Url






* Class name: Url
* Namespace: core




## Class index
**Constants**
* `  ALL`
* `  ANCHOR`
* `  DOMAIN`
* `  FILE`
* `  PATH`
* `  QUERY`
* `  SCHEME`

**Properties**
* `public mixed $redirect_url`
* `public mixed $redirected`
* `public mixed $referer_url`
* `public mixed $url`

**Methods**
* `public mixed cancel_redirect()`
* `public mixed init()`
* `public mixed parse($url, $flags)`
* `public mixed previous($allow_external, $allow_backend_to_frontend)`
* `public mixed redirect($url)`





Constants
----------


### ALL

```
const ALL = 0
```





### ANCHOR

```
const ANCHOR = 32
```





### DOMAIN

```
const DOMAIN = 2
```





### FILE

```
const FILE = 8
```





### PATH

```
const PATH = 4
```





### QUERY

```
const QUERY = 16
```





### SCHEME

```
const SCHEME = 1
```





Properties
----------


### $redirect_url

```
public mixed $redirect_url = null
```





* Visibility: **public**


### $redirected

```
public mixed $redirected = false
```





* Visibility: **public**


### $referer_url

```
public mixed $referer_url = false
```





* Visibility: **public**


### $url

```
public mixed $url
```





* Visibility: **public**


Methods
-------


### cancel_redirect

```
mixed core\Url::cancel_redirect()
```





* Visibility: **public**



### init

```
mixed core\Url::init()
```





* Visibility: **public**



### parse

```
mixed core\Url::parse($url, $flags)
```





* Visibility: **public**

#### Arguments

* $url **mixed**
* $flags **mixed**



### previous

```
mixed core\Url::previous($allow_external, $allow_backend_to_frontend)
```





* Visibility: **public**

#### Arguments

* $allow_external **mixed**
* $allow_backend_to_frontend **mixed**



### redirect

```
mixed core\Url::redirect($url)
```





* Visibility: **public**

#### Arguments

* $url **mixed**


