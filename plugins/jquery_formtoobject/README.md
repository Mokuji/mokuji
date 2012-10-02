jQuery.formToObject
===================

Converts forms into javascript objects in the same way PHP would interpret it's POST data.
* Serializes forms to objects in the same way PHP would do when given get/post data.
* Is intended to be as close to the W3C standards as possible.
* Reference used: http://dev.w3.org/html5/spec/single-page.html#constructing-the-form-data-set

Written by Beanow for Tuxion. Licenced with MIT licence.

Why create this plugin?
-----------------------

When trying to serialize form data into a JSON object using jQuery.serializeArray or other plugins for this purpose, most of the time you get jokes like these.

```html
<form method="post">
  <input type="hidden" name="field[0]" value="value1" />
  <input type="hidden" name="field[1]" value="value2" />
</form>
```

Resulting into this.

```javascript
{
  "field[0]": "value1",
  "field[1]": "value2"
}
```

This is normal behaviour for a browser, because that's how POST data would normally look like.
However, PHP interprets this POST data and turns it into this.

```
Array(
  [field] => Array(
    [0] => value1,
    [1] => value2
  )
)
```

If PHP were to interpret the previous example however (using json_decode() for instance) it would become this.

```
stdClass Object(
  [field[0]] => value1
  [field[1]] => value2
)
```

And that's a problem you'll run into with many AJAX/REST implementations with which you want to send JSON data from a form.
This plugin is meant to solve that once and for all.
Meaning the result from this plugin will be this.

```javascript
{
  "field": {
    "0": "value1",
    "1": "value2"
  }
}
```
