# dependencies\Image






* Class name: Image
* Namespace: dependencies
* Parent class: [dependencies\File](dependencies-File)




## Class index

**Properties**
* `private mixed $allow_growth`
* `private mixed $allow_shrink`
* `private mixed $image`
* `private mixed $jpeg_quality`
* `private mixed $logging`
* `private mixed $original`
* `private mixed $sharpen_after_resize`
* `private mixed $use_cache`

**Methods**
* `public mixed __construct($file)`
* `public mixed __destruct()`
* `public mixed allow_growth($set)`
* `public mixed allow_shrink($set)`
* `public mixed create($width, $height, $color, $type)`
* `public mixed crop($x, $y, $width, $height)`
* `public mixed fill($width, $height)`
* `public mixed fit($width, $height)`
* `public mixed from_file($source)`
* `public mixed get_height()`
* `public mixed get_width()`
* `public mixed jpeg_quality($set)`
* `public mixed output($options)`
* `public mixed resize($width, $height)`
* `public mixed save($save)`
* `public mixed sharpening($set)`
* `public mixed text($text, $color, $font, $x, $y, $line_spacing)`
* `public mixed use_cache($set)`
* `private mixed cache_dir($subfolder)`
* `private mixed color($color)`
* `private mixed info($source)`
* `private mixed prepare_sourcefile()`
* `private mixed sharpen($image, $intOrig, $intFinal)`


## Inheritance index

**Properties**
* `protected mixed $cache_time`
* `protected mixed $dir`
* `protected mixed $file`
* `protected mixed $info`
* `protected mixed $source`

**Methods**
* `public mixed cache_time($set)`
* `public mixed download($options)`
* `public mixed get_filesize()`
* `protected mixed create_output_headers()`



Properties
----------


### $cache_time

```
protected mixed $cache_time = 604800
```





* Visibility: **protected**
* This property is defined by [dependencies\File](dependencies-File)


### $dir

```
protected mixed $dir = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](dependencies-File)


### $file

```
protected mixed $file = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](dependencies-File)


### $info

```
protected mixed $info = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\File](dependencies-File)


### $source

```
protected mixed $source = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](dependencies-File)


### $allow_growth

```
private mixed $allow_growth = false
```





* Visibility: **private**


### $allow_shrink

```
private mixed $allow_shrink = true
```





* Visibility: **private**


### $image

```
private mixed $image
```





* Visibility: **private**


### $jpeg_quality

```
private mixed $jpeg_quality = 100
```





* Visibility: **private**


### $logging

```
private mixed $logging = false
```





* Visibility: **private**


### $original

```
private mixed $original = null
```





* Visibility: **private**


### $sharpen_after_resize

```
private mixed $sharpen_after_resize = true
```





* Visibility: **private**


### $use_cache

```
private mixed $use_cache = false
```





* Visibility: **private**


Methods
-------


### __construct

```
mixed dependencies\Image::__construct($file)
```





* Visibility: **public**

#### Arguments

* $file **mixed**



### __destruct

```
mixed dependencies\Image::__destruct()
```





* Visibility: **public**



### allow_growth

```
mixed dependencies\Image::allow_growth($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### allow_shrink

```
mixed dependencies\Image::allow_shrink($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### cache_time

```
mixed dependencies\File::cache_time($set)
```





* Visibility: **public**
* This method is defined by [dependencies\File](dependencies-File)

#### Arguments

* $set **mixed**



### create

```
mixed dependencies\Image::create($width, $height, $color, $type)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**
* $color **mixed**
* $type **mixed**



### crop

```
mixed dependencies\Image::crop($x, $y, $width, $height)
```





* Visibility: **public**

#### Arguments

* $x **mixed**
* $y **mixed**
* $width **mixed**
* $height **mixed**



### download

```
mixed dependencies\File::download($options)
```





* Visibility: **public**
* This method is defined by [dependencies\File](dependencies-File)

#### Arguments

* $options **mixed**



### fill

```
mixed dependencies\Image::fill($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



### fit

```
mixed dependencies\Image::fit($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



### from_file

```
mixed dependencies\Image::from_file($source)
```





* Visibility: **public**

#### Arguments

* $source **mixed**



### get_filesize

```
mixed dependencies\File::get_filesize()
```





* Visibility: **public**
* This method is defined by [dependencies\File](dependencies-File)



### get_height

```
mixed dependencies\Image::get_height()
```





* Visibility: **public**



### get_width

```
mixed dependencies\Image::get_width()
```





* Visibility: **public**



### jpeg_quality

```
mixed dependencies\Image::jpeg_quality($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### output

```
mixed dependencies\Image::output($options)
```





* Visibility: **public**

#### Arguments

* $options **mixed**



### resize

```
mixed dependencies\Image::resize($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



### save

```
mixed dependencies\Image::save($save)
```





* Visibility: **public**

#### Arguments

* $save **mixed**



### sharpening

```
mixed dependencies\Image::sharpening($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### text

```
mixed dependencies\Image::text($text, $color, $font, $x, $y, $line_spacing)
```





* Visibility: **public**

#### Arguments

* $text **mixed**
* $color **mixed**
* $font **mixed**
* $x **mixed**
* $y **mixed**
* $line_spacing **mixed**



### use_cache

```
mixed dependencies\Image::use_cache($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



### create_output_headers

```
mixed dependencies\File::create_output_headers()
```





* Visibility: **protected**
* This method is defined by [dependencies\File](dependencies-File)



### cache_dir

```
mixed dependencies\Image::cache_dir($subfolder)
```





* Visibility: **private**

#### Arguments

* $subfolder **mixed**



### color

```
mixed dependencies\Image::color($color)
```





* Visibility: **private**

#### Arguments

* $color **mixed**



### info

```
mixed dependencies\Image::info($source)
```





* Visibility: **private**

#### Arguments

* $source **mixed**



### prepare_sourcefile

```
mixed dependencies\Image::prepare_sourcefile()
```





* Visibility: **private**



### sharpen

```
mixed dependencies\Image::sharpen($image, $intOrig, $intFinal)
```





* Visibility: **private**

#### Arguments

* $image **mixed**
* $intOrig **mixed**
* $intFinal **mixed**


