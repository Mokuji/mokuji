# core\Account
[API index](../API-index.md)

Handles the basic account operations and manages the users session.




* Class name: Account
* Namespace: core




## Class index
**Constants**
* [`PERSISTENT_COOKIE_DURATION`](#constant-persistent_cookie_duration)

**Properties**
* [`public mixed $user`](#property-user)

**Methods**
* [`public self become_user(Integer $user_id, $persistent)`](#method-become_user)
* [`public boolean check_level(int $level, boolean $exact)`](#method-check_level)
* [`public void init()`](#method-init)
* [`public boolean is_login()`](#method-is_login)
* [`public self login(String $email, String $pass, $expiry_date, $persistent)`](#method-login)
* [`public boolean login_cookie()`](#method-login_cookie)
* [`public self logout()`](#method-logout)
* [`public void page_authorisation(int $level, boolean $exact)`](#method-page_authorisation)
* [`public boolean register(String $email, String $username, String $password, int $level)`](#method-register)
* [`private Object _check_ip_permissions()`](#method-_check_ip_permissions)
* [`private string _generate_authentication_token(integer $user_id, string $series_token, array $data)`](#method-_generate_authentication_token)
* [`private self _set_logged_in(\dependencies\Data $user, $expiry_date, $persistent, $series_token)`](#method-_set_logged_in)





# Constants


## Constant `PERSISTENT_COOKIE_DURATION`
In class: [core\Account](#top)

```
const int PERSISTENT_COOKIE_DURATION = 604800
```

The duration in seconds a "remember-me" cookie may be valid for.

Value: 7 days.



# Properties


## Property `$user`
In class: [core\Account](#top)

```
public mixed $user
```

The basic user information for the current session.



* Visibility: **public**


# Methods


## Method `become_user`
In class: [core\Account](#top)

```
self core\Account::become_user(Integer $user_id, $persistent)
```

Logins a login attempt for the current session.



* Visibility: **public**

#### Arguments

* $user_id **Integer** - The user ID of the user to log in with.
* $persistent **mixed**


#### Return value

**self** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Validation](../exception/Validation.md)** - If the IP address of the remote connection is blacklisted.
* **[exception\EmptyResult](../exception/EmptyResult.md)** - If the user account is not found.




## Method `check_level`
In class: [core\Account](#top)

```
boolean core\Account::check_level(int $level, boolean $exact)
```

Checks whether the currently logged in user has a certain user level.

When not checking the exact level,
it checks whether the user level is greater than or equal to the provided level.

* Visibility: **public**

#### Arguments

* $level **int** - The level the user should be checked against.
* $exact **boolean** - Whether the `$level` parameter should be exactly matched.


#### Return value

**boolean** - Whether or not the user meets the level requirements.







## Method `init`
In class: [core\Account](#top)

```
void core\Account::init()
```

Initializes the class.

Checks if the user is logged in.
Updates session expiry.
Logs out the user if session expired.

* Visibility: **public**






## Method `is_login`
In class: [core\Account](#top)

```
boolean core\Account::is_login()
```

Returns true if the user is logged in.

Short for $this-&gt;user-&gt;check('login').

* Visibility: **public**






## Method `login`
In class: [core\Account](#top)

```
self core\Account::login(String $email, String $pass, $expiry_date, $persistent)
```

Performs a login attempt for the current session.



* Visibility: **public**

#### Arguments

* $email **String** - The email or user-name of the user to log in with.
* $pass **String** - The plain text password to log in with.
* $expiry_date **mixed**
* $persistent **mixed**


#### Return value

**self** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Validation](../exception/Validation.md)** - If the IP address of the remote connection is blacklisted.
* **[exception\EmptyResult](../exception/EmptyResult.md)** - If the user account is not found.
* **[exception\Validation](../exception/Validation.md)** - If the password is invalid.




## Method `login_cookie`
In class: [core\Account](#top)

```
boolean core\Account::login_cookie()
```

Looks for a login cookie, and if present, attempts to log the user in with it.



* Visibility: **public**


#### Return value

**boolean** - Whether the user was logged in.







## Method `logout`
In class: [core\Account](#top)

```
self core\Account::logout()
```

Logs out the current user.



* Visibility: **public**


#### Return value

**self** - Returns $this for chaining.







## Method `page_authorisation`
In class: [core\Account](#top)

```
void core\Account::page_authorisation(int $level, boolean $exact)
```

Checks whether the currently logged in user has permission to view this page.

Similar to check_level except it redirects the user if the user is not authorized.

* Visibility: **public**

#### Arguments

* $level **int** - The level the user should be checked against.
* $exact **boolean** - Whether the `$level` parameter should be exactly matched.



#### Throws exceptions

* **[exception\User](../exception/User.md)** - If the redirect target requires the user to be logged in as well.




## Method `register`
In class: [core\Account](#top)

```
boolean core\Account::register(String $email, String $username, String $password, int $level)
```

Registers a new user account.



* Visibility: **public**

#### Arguments

* $email **String** - The email address to set.
* $username **String** - The optional username to set.
* $password **String** - The password to set.
* $level **int** - The user level to set. (1 = Normal user, 2 = Administrator)


#### Return value

**boolean** - Whether registering the user was successful.







## Method `_check_ip_permissions`
In class: [core\Account](#top)

```
Object core\Account::_check_ip_permissions()
```

Check if a user is allowed to login based on IP.



* Visibility: **private**


#### Return value

**Object** - $ipinfo.




#### Throws exceptions

* **[exception\Validation](../exception/Validation.md)** - If the IP address of the remote connection is blacklisted.




## Method `_generate_authentication_token`
In class: [core\Account](#top)

```
string core\Account::_generate_authentication_token(integer $user_id, string $series_token, array $data)
```

Return a persistent authentication token with the given user ID.



* Visibility: **private**

#### Arguments

* $user_id **integer** - The ID of the user to include in the token.
* $series_token **string** - An optional series token to include. Will be generated when null is given.
* $data **array** - An out-parameter that will be filled with an array of the different components:
                   * `user_id`: The given user ID.
                   * `access_token`: The generated access token.
                   * `series_token`: The given or generated series token.


#### Return value

**string** - The full token.







## Method `_set_logged_in`
In class: [core\Account](#top)

```
self core\Account::_set_logged_in(\dependencies\Data $user, $expiry_date, $persistent, $series_token)
```

Sets the log-in session for a given user object.



* Visibility: **private**

#### Arguments

* $user **[dependencies\Data](../dependencies/Data.md)** - A row from the users table.
* $expiry_date **mixed**
* $persistent **mixed**
* $series_token **mixed**


#### Return value

**self** - Chaining enabled.






