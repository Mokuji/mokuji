;(function($){
  
  $.fn.restForm = function(callbacks){
    
    callbacks = $.extend({
      beforeSubmit: function(){},
      success: function(){},
      error: function(){}
    }, callbacks);
    
    var hasFeedback = (window.app && app.Feedback);
    
    function clearFormMessages(form){
      $(form).find('.validation-error').remove();
      $(form).find('.restform-error-message').remove();
      $(form).find('.invalid').removeClass('invalid');
    }
    
    $(this).submit(function(e){
      
      e.preventDefault();
      
      //Only supported in Firefox.
      var $usedButton = false;
      if(e.originalEvent && e.originalEvent.explicitOriginalTarget)
        $usedButton = $(e.originalEvent.explicitOriginalTarget);
      
      var form = this;
      
      var data = $(form).formToObject($usedButton ? $usedButton.attr('name') : null);
      
      //Tell the world we're loading things.
      if(hasFeedback) app.Feedback.working('Saving data');
      
      //Pre-process data.
      callbacks.beforeSubmit.apply(this, [data, form]);
      
      $.rest($(form).attr('method'), form.action, data)
        
        .done(function(){
          
          //Remove old notifications.
          clearFormMessages(form);
          
          //Tell the world it worked!
          if(hasFeedback) app.Feedback.success('Done');
          
          //Run the success callback.
          callbacks.success.apply(this, [arguments[0], form]);
          
        })
        
        .error(function(xhr, state, message){
          
          //Remove old notifications.
          clearFormMessages(form);
          
          //Tell the world it didn't work :(
          if(hasFeedback) app.Feedback.error(message);
          
          //Add the generic error message.
          var $error = $('<div>', {
            'class': 'restform-error-message',
            'text': message
          });
          $(form).prepend($error);
          
          //If we have JSON information about specific field errors, show them.
          if(xhr.responseText)
          {
            
            try{
              
              //Parse JSON.
              var errorMeta = JSON.parse(xhr.responseText)
                , focusedBefore = false;
              
              //Highlight and comment each field.
              for(var name in errorMeta){
                
                //Find the element to add errors to.
                $errorEl = $(form).find('[name="'+name+'"]')
                  .eq(0); //Only one please.
                
                //Focus the first element.
                if(!focusedBefore && !$errorEl.is('[type=hidden]')){
                  $errorEl.focus();
                  focusedBefore = true;
                }
                
                //Go one level up for radio's or checkboxes.
                if($errorEl.is('[type=radio],[type=checkbox]'))
                  $errorEl = $errorEl.parent();
                
                //Add classes and a notification.
                $errorEl
                  .addClass('invalid')
                  .after(
                    $('<span>').addClass('validation-error').text(errorMeta[name])
                  );
              }
              
            }
            catch(ex){
              $(form).append($('<div class="restform-error-message" />').html(xhr.responseText));
            }
            
          }
          
          callbacks.error.apply(this, [xhr, state, message, form]);
          
        });
      
      return false;
      
    });
    
    return this;
    
  };
  
})(jQuery);
