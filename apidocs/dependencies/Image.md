# dependencies\Image
[API index](../API-index.md)






* Class name: Image
* Namespace: dependencies
* Parent class: [dependencies\File](../dependencies/File.md)




## Class index

**Properties**
* [`private mixed $allow_growth`](#property-allow_growth)
* [`private mixed $allow_shrink`](#property-allow_shrink)
* [`private mixed $image`](#property-image)
* [`private mixed $jpeg_quality`](#property-jpeg_quality)
* [`private mixed $logging`](#property-logging)
* [`private mixed $original`](#property-original)
* [`private mixed $sharpen_after_resize`](#property-sharpen_after_resize)
* [`private mixed $use_cache`](#property-use_cache)

**Methods**
* [`public mixed __construct($file)`](#method-__construct)
* [`public mixed __destruct()`](#method-__destruct)
* [`public mixed allow_growth($set)`](#method-allow_growth)
* [`public mixed allow_shrink($set)`](#method-allow_shrink)
* [`public mixed create($width, $height, $color, $type)`](#method-create)
* [`public mixed crop($x, $y, $width, $height)`](#method-crop)
* [`public mixed fill($width, $height)`](#method-fill)
* [`public mixed fit($width, $height)`](#method-fit)
* [`public mixed from_file($source)`](#method-from_file)
* [`public mixed get_height()`](#method-get_height)
* [`public mixed get_width()`](#method-get_width)
* [`public mixed jpeg_quality($set)`](#method-jpeg_quality)
* [`public mixed output($options)`](#method-output)
* [`public mixed resize($width, $height)`](#method-resize)
* [`public mixed save($save)`](#method-save)
* [`public mixed sharpening($set)`](#method-sharpening)
* [`public mixed text($text, $color, $font, $x, $y, $line_spacing)`](#method-text)
* [`public mixed use_cache($set)`](#method-use_cache)
* [`private mixed cache_dir($subfolder)`](#method-cache_dir)
* [`private mixed color($color)`](#method-color)
* [`private mixed info($source)`](#method-info)
* [`private mixed prepare_sourcefile()`](#method-prepare_sourcefile)
* [`private mixed sharpen($image, $intOrig, $intFinal)`](#method-sharpen)


## Inheritance index

**Properties**
* [`protected mixed $cache_time`](#property-cache_time)
* [`protected mixed $dir`](#property-dir)
* [`protected mixed $file`](#property-file)
* [`protected mixed $info`](#property-info)
* [`protected mixed $source`](#property-source)

**Methods**
* [`public mixed cache_time($set)`](#method-cache_time)
* [`public mixed download($options)`](#method-download)
* [`public mixed get_filesize()`](#method-get_filesize)
* [`protected mixed create_output_headers()`](#method-create_output_headers)



# Properties


## Property `$cache_time`
In class: [dependencies\Image](#top)

```
protected mixed $cache_time = 604800
```





* Visibility: **protected**
* This property is defined by [dependencies\File](../dependencies/File.md)


## Property `$dir`
In class: [dependencies\Image](#top)

```
protected mixed $dir = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](../dependencies/File.md)


## Property `$file`
In class: [dependencies\Image](#top)

```
protected mixed $file = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](../dependencies/File.md)


## Property `$info`
In class: [dependencies\Image](#top)

```
protected mixed $info = array()
```





* Visibility: **protected**
* This property is defined by [dependencies\File](../dependencies/File.md)


## Property `$source`
In class: [dependencies\Image](#top)

```
protected mixed $source = ''
```





* Visibility: **protected**
* This property is defined by [dependencies\File](../dependencies/File.md)


## Property `$allow_growth`
In class: [dependencies\Image](#top)

```
private mixed $allow_growth = false
```





* Visibility: **private**


## Property `$allow_shrink`
In class: [dependencies\Image](#top)

```
private mixed $allow_shrink = true
```





* Visibility: **private**


## Property `$image`
In class: [dependencies\Image](#top)

```
private mixed $image
```





* Visibility: **private**


## Property `$jpeg_quality`
In class: [dependencies\Image](#top)

```
private mixed $jpeg_quality = 100
```





* Visibility: **private**


## Property `$logging`
In class: [dependencies\Image](#top)

```
private mixed $logging = false
```





* Visibility: **private**


## Property `$original`
In class: [dependencies\Image](#top)

```
private mixed $original = null
```





* Visibility: **private**


## Property `$sharpen_after_resize`
In class: [dependencies\Image](#top)

```
private mixed $sharpen_after_resize = true
```





* Visibility: **private**


## Property `$use_cache`
In class: [dependencies\Image](#top)

```
private mixed $use_cache = false
```





* Visibility: **private**


# Methods


## Method `__construct`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::__construct($file)
```





* Visibility: **public**

#### Arguments

* $file **mixed**



## Method `__destruct`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::__destruct()
```





* Visibility: **public**



## Method `allow_growth`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::allow_growth($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `allow_shrink`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::allow_shrink($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `cache_time`
In class: [dependencies\Image](#top)

```
mixed dependencies\File::cache_time($set)
```





* Visibility: **public**
* This method is defined by [dependencies\File](../dependencies/File.md)

#### Arguments

* $set **mixed**



## Method `create`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::create($width, $height, $color, $type)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**
* $color **mixed**
* $type **mixed**



## Method `crop`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::crop($x, $y, $width, $height)
```





* Visibility: **public**

#### Arguments

* $x **mixed**
* $y **mixed**
* $width **mixed**
* $height **mixed**



## Method `download`
In class: [dependencies\Image](#top)

```
mixed dependencies\File::download($options)
```





* Visibility: **public**
* This method is defined by [dependencies\File](../dependencies/File.md)

#### Arguments

* $options **mixed**



## Method `fill`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::fill($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



## Method `fit`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::fit($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



## Method `from_file`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::from_file($source)
```





* Visibility: **public**

#### Arguments

* $source **mixed**



## Method `get_filesize`
In class: [dependencies\Image](#top)

```
mixed dependencies\File::get_filesize()
```





* Visibility: **public**
* This method is defined by [dependencies\File](../dependencies/File.md)



## Method `get_height`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::get_height()
```





* Visibility: **public**



## Method `get_width`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::get_width()
```





* Visibility: **public**



## Method `jpeg_quality`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::jpeg_quality($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `output`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::output($options)
```





* Visibility: **public**

#### Arguments

* $options **mixed**



## Method `resize`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::resize($width, $height)
```





* Visibility: **public**

#### Arguments

* $width **mixed**
* $height **mixed**



## Method `save`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::save($save)
```





* Visibility: **public**

#### Arguments

* $save **mixed**



## Method `sharpening`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::sharpening($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `text`
In class: [dependencies\Image](#top)

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



## Method `use_cache`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::use_cache($set)
```





* Visibility: **public**

#### Arguments

* $set **mixed**



## Method `create_output_headers`
In class: [dependencies\Image](#top)

```
mixed dependencies\File::create_output_headers()
```





* Visibility: **protected**
* This method is defined by [dependencies\File](../dependencies/File.md)



## Method `cache_dir`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::cache_dir($subfolder)
```





* Visibility: **private**

#### Arguments

* $subfolder **mixed**



## Method `color`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::color($color)
```





* Visibility: **private**

#### Arguments

* $color **mixed**



## Method `info`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::info($source)
```





* Visibility: **private**

#### Arguments

* $source **mixed**



## Method `prepare_sourcefile`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::prepare_sourcefile()
```





* Visibility: **private**



## Method `sharpen`
In class: [dependencies\Image](#top)

```
mixed dependencies\Image::sharpen($image, $intOrig, $intFinal)
```





* Visibility: **private**

#### Arguments

* $image **mixed**
* $intOrig **mixed**
* $intFinal **mixed**


