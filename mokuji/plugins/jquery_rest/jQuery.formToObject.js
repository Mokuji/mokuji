/**
 * Serializes forms to objects in the same way PHP would do when given get/post data.
 * This is intended to be as close to the W3C standards as possible.
 * Reference: http://dev.w3.org/html5/spec/single-page.html#constructing-the-form-data-set
 *
 * @author Beanow
 * @company Tuxion
 * @email beanow@project-virality.com
 * @licence: MIT
 * @link: https://github.com/Tuxion/jQuery.formToObject
 */

(function($){
  
  $.fn.formToObject = function(submitter){
    
    var finalData = {}
      , splitName = /\]\[|\[|\]/g
      , isNumber = /^[0-9]+$/
      , submitter = submitter ? submitter.toString() : null;
    
    //Gets the proper value of the field.
    var getFieldValue = function(field){
      
      //For files: {name: [ {"name": filename, "type":mimetype, "size":filelength}, ... ] }
      //Support for file bodies is not across all browsers, so it's left out.
      if($(field).is('[type=file]')){
        
        var files = $(field)[0].files
          , output = [];
        
        for(var i = 0; i < files.length; i++){
          output.push({
            name: files[i].name,
            type: files[i].type,
            size: files[i].size
          });
        }
        
        return output;
          
      }
      
      //Everything else simply uses .val()
      return $(field).val();
      
    };
    
    //Check for a name="isindex" instance.
    //Returns [value]
    if($(this).find(':input:enabled, :input[type=hidden]').eq(0).is('[type=text][name=isindex]')){
      return [$(this).find(':input:enabled').eq(0).val()];
    }
    
    //Go over each input in the form.
    //Note: hidden fields are filtered by :enabled in jQuery versions before 1.8.
    $(this).find(':input:enabled, :input[type=hidden]').each(function(){
      
      //Get a reference to the field.
      var field = $(this);
      
      //Since this function does not perform a submit, we don't look for the submitter button/submit/image.
      //Except when it's explicitly given as the function parameter.
      if(
        field.is('[type=button], [type=submit], [type=image]') &&
        (submitter ? field.is(':not([name="'+submitter+'"])') : true)
      ) return true;
      
      //Checkboxes or radios that are not checked are not included.
      if(field.is('[type=checkbox]:not(:checked), [type=radio]:not(:checked)')) return true;
      
      //A non-empty name attribute is required.
      if(!field.attr('name') || field.attr('name') == '') return true;
      
      //Check if this is a name="_charset_" instance.
      //Inserts {"_charset_": characterSet}
      if(field.is('[type=hidden][name=_charset_]')){
        $.extend(finalData, {"_charset_": document.characterSet ? document.characterSet : document.charset});
        return true;
      }
      
      //Parse the fields name.
      var target = finalData
        , nameParts = field.attr('name').split(splitName);
      
      //Since we end the last array with ']' we will have an excess empty value at the end of the array.
      //Check on empty string, because Internet Explorer (8) filters semi-empty array nodes.
      if(nameParts.length > 1 && nameParts[nameParts.length-1] == '') nameParts.pop();
      
      //Go through each name part.
      for(var i = 0; i < nameParts.length; i++){
        
        //Is this the last or first instance?
        var isLast = (nameParts.length == i+1)
          , isFirst = (i == 0);
        
        //Empty strings need special treatment. They should behave like array autoincrements.
        if(nameParts[i] == ''){
          
          //If it is the first instance, it's an error to have an empty string and the field should be ignored.
          if(isFirst) return true;
          
          //Find the highest number.
          var maxNum = -1;
          for(var key in target){
            
            if(isNumber.test(key) && parseInt(key, 10) > maxNum)
              maxNum = parseInt(key, 10);
            
          }
          
          //Perform the autoincrement! :D
          maxNum++;
          
          //Set the value and store where we are.
          target = (target[maxNum] = isLast ? getFieldValue(field) : {});
          
        }
        
        //Non-empty name parts should be treated as keys.
        else{
          
          //Set the value and store where we are.
          target = (target[nameParts[i]] = isLast ? getFieldValue(field) : target[nameParts[i]] || {});
          
        }
        
      }
      
    });
    
    return finalData;
    
  };
  
})(jQuery);
