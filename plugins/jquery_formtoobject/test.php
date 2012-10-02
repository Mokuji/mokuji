<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
  <head>
    <title>Form submit test</title>
    <!-- character encoding -->
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="jQuery.formToObject.js"></script>
    <script type="text/javascript">
      $(function(){
        console.log('result', $('#form').formToObject(), JSON.stringify($('#form').formToObject()));
      });
    </script>
  </head>
  <body>
    <pre><?php print_r($_POST); ?></pre>
    <pre><?php print_r($_FILES); ?></pre>
    <form id="form" method="post" enctype="multipart/form-data" action="#">
      <input type="hidden" name="field[]" value="value1" />
      <input type="hidden" name="field[]" value="value2" />
      <input type="text" name="test[a][b]" value="1" />
      <input type="text" name="test[a][c]" value="2" />
      <input type="text" name="test[d][]" value="3" />
      <input type="text" name="test[d][]" value="4" />
      <textarea name="test2">5</textarea>
      <input type="checkbox" name="test3" value="1" checked />
      <input type="checkbox" name="test3" value="2" checked />
      <input type="radio" name="test4[]" value="1" />
      <input type="radio" name="test4[]" value="2" checked />
      <input type="radio" name="test4[]" value="3" checked />
      <input type="file" name="test5" multiple />
      <p><input type="submit" /></p>
    </form>
  </body>
</html>
