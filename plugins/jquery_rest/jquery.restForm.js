;(function($){
  
  $.fn.restForm = function(callbacks){
    
    callbacks = $.extend({
      success: function(){},
      error: function(){}
    }, callbacks);
    
    function clearFormMessages(form){
      $(form).find('.validation-error').remove();
      $(form).find('.restform-error-message').remove();
      $(form).find('.invalid').removeClass('invalid');
    }
    
    $(this).submit(function(e){
      
      e.preventDefault();
      
      var form = this;
      
      var data = $(form).formToObject();
      
      $.rest($(form).attr('method'), form.action, data)
        
        .done(function(){
          
          //Remove old notifications.
          clearFormMessages(form);
          
          //Run the success callback.
          callbacks.success.apply(this, arguments);
          
        })
        
        .error(function(xhr, state, message){
          
          //Remove old notifications.
          clearFormMessages(form);
          
          //Add the generic error message.
          var $error = $('<div>', {
            'class': 'restform-error-message',
            'text': message
          });
          $(form).prepend($error);
          
          //If we have JSON information about specific field errors, show them.
          if(xhr.responseText)
          {
            
            //Parse JSON.
            var errorMeta = JSON.parse(xhr.responseText);
            
            //Highlight and comment each field.
            for(var name in errorMeta){
              $(form).find('[name='+name+']')
                .focus()
                .addClass('invalid')
                .parent().append(
                  $('<span>').addClass('validation-error').text(errorMeta[name])
                );
            }
            
          }
          
          callbacks.error.apply(this, arguments);
        });
      
      return false;
      
    });
    
    return this;
    
  };
  
})(jQuery);
