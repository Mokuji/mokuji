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
  
});
