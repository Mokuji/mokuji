# core\Security






* Class name: Security
* Namespace: core




## Class index
**Constants**
* `  OUTPUT_BASE64`
* `  OUTPUT_BINARY`
* `  OUTPUT_DECIMAL`
* `  OUTPUT_HEX`
* `  PASSWORD_STRENGTH_ACCEPTABLE`
* `  PASSWORD_STRENGTH_STRONG`
* `  PASSWORD_STRENGTH_VERY_WEAK`
* `  PASSWORD_STRENGTH_WEAK`

**Properties**
* `public static mixed $HASH_DEFAULT`
* `public static mixed $HASH_PREFERENCES`

**Methods**
* `public Boolean get_password_strength(String $password)`
* `public mixed hash(string $input, string $algorithm, int $output_type)`
* `public string pref_hash_algo(int $bits, bool $inclusive, $result_bits)`
* `public string random_string(int $length, int $output_type, bool $secure)`
* `private mixed _conv_rate($output_type)`
* `private mixed _convert_bin($input, $output_type)`
* `private string _random_bits(int $bits, bool $secure, int $output_type)`





Constants
----------


### OUTPUT_BASE64

```
const OUTPUT_BASE64 = 2
```





### OUTPUT_BINARY

```
const OUTPUT_BINARY = 0
```





### OUTPUT_DECIMAL

```
const OUTPUT_DECIMAL = 3
```





### OUTPUT_HEX

```
const OUTPUT_HEX = 1
```





### PASSWORD_STRENGTH_ACCEPTABLE

```
const PASSWORD_STRENGTH_ACCEPTABLE = 3
```





### PASSWORD_STRENGTH_STRONG

```
const PASSWORD_STRENGTH_STRONG = 4
```





### PASSWORD_STRENGTH_VERY_WEAK

```
const PASSWORD_STRENGTH_VERY_WEAK = 1
```





### PASSWORD_STRENGTH_WEAK

```
const PASSWORD_STRENGTH_WEAK = 2
```





Properties
----------


### $HASH_DEFAULT

```
public mixed $HASH_DEFAULT = 'sha256'
```





* Visibility: **public**
* This property is **static**.


### $HASH_PREFERENCES

```
public mixed $HASH_PREFERENCES = array('128' => array('ripemd128', 'snefru'), '160' => array('ripemd160', 'sha1'), '224' => array('sha224'), '256' => array('sha256'), '384' => array('sha384'), '512' => array('sha512', 'whirlpool'))
```





* Visibility: **public**
* This property is **static**.


Methods
-------


### get_password_strength

```
Boolean core\Security::get_password_strength(String $password)
```

Checks the password supplied is strong enough.



* Visibility: **public**

#### Arguments

* $password **String** - The password to get the strength of.



### hash

```
mixed core\Security::hash(string $input, string $algorithm, int $output_type)
```

Generates a hash using php's hash() function.



* Visibility: **public**

#### Arguments

* $input **string** - The input string to hash.
* $algorithm **string** - The algorithm to use for hashing.
* $output_type **int** - The output type for the generated bits.



### pref_hash_algo

```
string core\Security::pref_hash_algo(int $bits, bool $inclusive, $result_bits)
```

Gets the prefered hashing algorithm for a certain amount of bits worth of entropy.

<p>When setting inclusive = false that means:
 The prefered algorithm that is used to it's optimum with the given entropy.
 For instance: given 230 bits of entropy the best 224 bits algorithm is picked.</p>

<p>When setting inclusive = true that means:
 The prefered algorithm that is able to contain the full entropy available.
 For instance: given 230 bits of entropy the best 256 bits algorithm is picked.</p>

* Visibility: **public**

#### Arguments

* $bits **int** - Amount of bits of entropy.
* $inclusive **bool** - Whether or not to use the full entropy.
* $result_bits **mixed**



### random_string

```
string core\Security::random_string(int $length, int $output_type, bool $secure)
```

Generates a random string.



* Visibility: **public**

#### Arguments

* $length **int** - Length of the random string to get in characters.
* $output_type **int** - The output type for the generated bits.
* $secure **bool** - Use a cryptographically secure method of getting these random bits.



### _conv_rate

```
mixed core\Security::_conv_rate($output_type)
```

Get the conversion rate in characters from bytes.



* Visibility: **private**

#### Arguments

* $output_type **mixed**



### _convert_bin

```
mixed core\Security::_convert_bin($input, $output_type)
```

Converts binary strings to other notations.



* Visibility: **private**

#### Arguments

* $input **mixed**
* $output_type **mixed**



### _random_bits

```
string core\Security::_random_bits(int $bits, bool $secure, int $output_type)
```

Generate pseudo random bits using the best available method.



* Visibility: **private**

#### Arguments

* $bits **int** - Amount of random bits to generate.
* $secure **bool** - Use a cryptographically secure method of getting these random bits.
* $output_type **int** - The output type for the generated bits.


