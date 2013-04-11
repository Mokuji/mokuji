# core\Security
[API index](../API-index.md)






* Class name: Security
* Namespace: core




## Class index
**Constants**
* [`OUTPUT_BASE64`](#constant-output_base64)
* [`OUTPUT_BINARY`](#constant-output_binary)
* [`OUTPUT_DECIMAL`](#constant-output_decimal)
* [`OUTPUT_HEX`](#constant-output_hex)
* [`PASSWORD_STRENGTH_ACCEPTABLE`](#constant-password_strength_acceptable)
* [`PASSWORD_STRENGTH_STRONG`](#constant-password_strength_strong)
* [`PASSWORD_STRENGTH_VERY_WEAK`](#constant-password_strength_very_weak)
* [`PASSWORD_STRENGTH_WEAK`](#constant-password_strength_weak)

**Properties**
* [`public static mixed $HASH_DEFAULT`](#property-hash_default)
* [`public static mixed $HASH_PREFERENCES`](#property-hash_preferences)

**Methods**
* [`public int get_password_strength(String $password)`](#method-get_password_strength)
* [`public mixed hash(string $input, string $algorithm, int $output_type)`](#method-hash)
* [`public string pref_hash_algo(int $bits, bool $inclusive, $result_bits)`](#method-pref_hash_algo)
* [`public string random_string(int $length, int $output_type, bool $secure)`](#method-random_string)
* [`private mixed _conv_rate($output_type)`](#method-_conv_rate)
* [`private mixed _convert_bin($input, $output_type)`](#method-_convert_bin)
* [`private string _random_bits(int $bits, bool $secure, int $output_type)`](#method-_random_bits)





# Constants


## Constant `OUTPUT_BASE64`
In class: [core\Security](#top)

```
const OUTPUT_BASE64 = 2
```





## Constant `OUTPUT_BINARY`
In class: [core\Security](#top)

```
const OUTPUT_BINARY = 0
```





## Constant `OUTPUT_DECIMAL`
In class: [core\Security](#top)

```
const OUTPUT_DECIMAL = 3
```





## Constant `OUTPUT_HEX`
In class: [core\Security](#top)

```
const OUTPUT_HEX = 1
```





## Constant `PASSWORD_STRENGTH_ACCEPTABLE`
In class: [core\Security](#top)

```
const PASSWORD_STRENGTH_ACCEPTABLE = 3
```





## Constant `PASSWORD_STRENGTH_STRONG`
In class: [core\Security](#top)

```
const PASSWORD_STRENGTH_STRONG = 4
```





## Constant `PASSWORD_STRENGTH_VERY_WEAK`
In class: [core\Security](#top)

```
const PASSWORD_STRENGTH_VERY_WEAK = 1
```





## Constant `PASSWORD_STRENGTH_WEAK`
In class: [core\Security](#top)

```
const PASSWORD_STRENGTH_WEAK = 2
```





# Properties


## Property `$HASH_DEFAULT`
In class: [core\Security](#top)

```
public mixed $HASH_DEFAULT = 'sha256'
```





* Visibility: **public**
* This property is **static**.


## Property `$HASH_PREFERENCES`
In class: [core\Security](#top)

```
public mixed $HASH_PREFERENCES = array('128' => array('ripemd128', 'snefru'), '160' => array('ripemd160', 'sha1'), '224' => array('sha224'), '256' => array('sha256'), '384' => array('sha384'), '512' => array('sha512', 'whirlpool'))
```





* Visibility: **public**
* This property is **static**.


# Methods


## Method `get_password_strength`
In class: [core\Security](#top)

```
int core\Security::get_password_strength(String $password)
```

Checks the password supplied is strong enough.



* Visibility: **public**

#### Arguments

* $password **String** - The password to get the strength of.


#### Return value

**int** - Returns an integer indicating the password strength. See the constants of this class.







## Method `hash`
In class: [core\Security](#top)

```
mixed core\Security::hash(string $input, string $algorithm, int $output_type)
```

Generates a hash using php's hash() function.



* Visibility: **public**

#### Arguments

* $input **string** - The input string to hash.
* $algorithm **string** - The algorithm to use for hashing.
* $output_type **int** - The output type for the generated bits.






## Method `pref_hash_algo`
In class: [core\Security](#top)

```
string core\Security::pref_hash_algo(int $bits, bool $inclusive, $result_bits)
```

Gets the prefered hashing algorithm for a certain amount of bits worth of entropy.

When setting inclusive = false that means:
 The prefered algorithm that is used to it's optimum with the given entropy.
 For instance: given 230 bits of entropy the best 224 bits algorithm is picked.

When setting inclusive = true that means:
 The prefered algorithm that is able to contain the full entropy available.
 For instance: given 230 bits of entropy the best 256 bits algorithm is picked.

* Visibility: **public**

#### Arguments

* $bits **int** - Amount of bits of entropy.
* $inclusive **bool** - Whether or not to use the full entropy.
* $result_bits **mixed**


#### Return value

**string** - Hashing algorithm.







## Method `random_string`
In class: [core\Security](#top)

```
string core\Security::random_string(int $length, int $output_type, bool $secure)
```

Generates a random string.



* Visibility: **public**

#### Arguments

* $length **int** - Length of the random string to get in characters.
* $output_type **int** - The output type for the generated bits.
* $secure **bool** - Use a cryptographically secure method of getting these random bits.


#### Return value

**string** - A (pseudo) random string.







## Method `_conv_rate`
In class: [core\Security](#top)

```
mixed core\Security::_conv_rate($output_type)
```

Get the conversion rate in characters from bytes.



* Visibility: **private**

#### Arguments

* $output_type **mixed**






## Method `_convert_bin`
In class: [core\Security](#top)

```
mixed core\Security::_convert_bin($input, $output_type)
```

Converts binary strings to other notations.



* Visibility: **private**

#### Arguments

* $input **mixed**
* $output_type **mixed**






## Method `_random_bits`
In class: [core\Security](#top)

```
string core\Security::_random_bits(int $bits, bool $secure, int $output_type)
```

Generate pseudo random bits using the best available method.



* Visibility: **private**

#### Arguments

* $bits **int** - Amount of random bits to generate.
* $secure **bool** - Use a cryptographically secure method of getting these random bits.
* $output_type **int** - The output type for the generated bits.


#### Return value

**string** - A (pseudo) random string.






