;(function($){
  
  $.fn.restForm = function(callbacks){
    
    callbacks = $.extend({
      success: function(){},
      error: function(){}
    }, callbacks);
    
    $(this).submit(function(e){
      
      e.preventDefault();
      
      var form = this;
      
      var data = $(form).formToObject();
      
      $.rest($(form).attr('method'), form.action, data)
        .done(function(){
          $(form).find('.validation-error').remove();
          callbacks.success.apply(this, arguments);
        })
        .error(function(xhr, state, message){
          $(form).find('.validation-error').remove();
          var errorMeta = JSON.parse(xhr.responseText);
          for(var name in errorMeta){
            $(form).find('[name='+name+']')
              .focus()
              .parent().append(
                $('<span>').addClass('validation-error').text(errorMeta[name])
              );
          }
          callbacks.error.apply(this, arguments);
        });
      
      return false;
      
    });
    
    return this;
    
  };
  
})(jQuery);
