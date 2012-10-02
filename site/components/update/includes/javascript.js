;jQuery(function($){
  
  //Put a notifier on top of the update-summary toolbar icon.
  var li = $('#configbar li.update-summary');
  if(li.size() > 0){
    
    $.ajax('?rest=update/update_count')
      .done(function(res){
        
        //Only if there are updates.
        if(res.update_count > 0){
          
          //Wrapper div
          var wrapper = $('<div class="counter-wrapper"><div class="counter">'+res.update_count+'</div></div>')
            .prependTo(li);
          
          //<a> element
          wrapper.next()
            .appendTo(wrapper);
          
          //Counter div
          var up = '-18px'
            , down = '-8px'
            , speed = 120
            , easing = 'swing';
          wrapper.find('.counter')
            .click(function(e){
              e.stopImmediatePropagation();
              $(e.target).parent().find('a').trigger('click');
              return false;
            })
            .delay(speed)
            .animate({top:up}, speed, easing)
            .animate({top:down}, speed, easing)
            .animate({top:up}, speed, easing)
            .animate({top:down}, speed, easing);
          
        }
        
      });
    
  }
  
});
