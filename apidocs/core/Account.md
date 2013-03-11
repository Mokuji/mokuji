# core\Account
[API index](../API-index.md)

Handles the basic account operations and manages the users session.




* Class name: Account
* Namespace: core




## Class index

**Properties**
* [`public mixed $user`](#property-user)

**Methods**
* [`public boolean check_level(int $level, boolean $exact)`](#method-check_level)
* [`public void init()`](#method-init)
* [`public boolean is_login()`](#method-is_login)
* [`public \core\Account login(String $email, String $pass, $expiry_date)`](#method-login)
* [`public \core\Account logout()`](#method-logout)
* [`public void page_authorisation(int $level, boolean $exact)`](#method-page_authorisation)
* [`public boolean register(String $email, String $username, String $password, int $level)`](#method-register)







# Properties


## Property `$user`
In class: [core\Account](#top)

```
public mixed $user
```

The basic user information for the current session.



* Visibility: **public**


# Methods


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
\core\Account core\Account::login(String $email, String $pass, $expiry_date)
```

Performs a login attempt for the current session.



* Visibility: **public**

#### Arguments

* $email **String** - The email or username of the user to log in with.
* $pass **String** - The plaintext password to log in with.
* $expiry_date **mixed**


#### Return value

**[core\Account](../core/Account.md)** - Returns $this for chaining.




#### Throws exceptions

* **[exception\Validation](../exception/Validation.md)** - If the IP address of the remote connection is blacklisted.
* **[exception\EmptyResult](../exception/EmptyResult.md)** - If the user account is not found.
* **[exception\Validation](../exception/Validation.md)** - If the password is invalid.




## Method `logout`
In class: [core\Account](#top)

```
\core\Account core\Account::logout()
```

Logs out the current user.



* Visibility: **public**


#### Return value

**[core\Account](../core/Account.md)** - Returns $this for chaining.







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






