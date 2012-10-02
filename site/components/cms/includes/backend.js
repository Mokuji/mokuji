;jQuery(function($){
  
  //Init notifications.
  var lastNotification = null;
  var fadeOld = function(){
    if(!lastNotification) return;
    
    lastNotification.fadeOut(function(){
      $(this).remove();
      lastNotification = null;
    });
  };

  //Clicking notifications away.
  $('body').on('click', '.notification', function(){
    $(this).fadeOut(function(){
      $(this).remove();
    });
  });

  //Notify
  $.notify = function(type, message){
    
    fadeOld();
    lastNotification = $('<div>')
      .addClass('static notification')
      .addClass(type)
      .text(message)
      .hide()
      .appendTo($('body'))
      .fadeIn();
    
  };

  //Flash
  $.flash = function(type, message){
    fadeOld();
    $('<div>')
      .addClass('flash notification')
      .addClass(type)
      .text(message)
      .hide()
      .appendTo($('body'))
      .fadeIn(function(){
        
        $(this)
          .delay(1500)
          .fadeOut(function(){
            $(this).remove();
          });
        
      });
    
  };

  //REST
  $.rest = function(type, path, data){
    
    return $.ajax({
      url: path,
      type: type,
      data: JSON.stringify(data),
      dataType: 'json',
      processData: false
    });
    
  };

  //REST form
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
  
});
