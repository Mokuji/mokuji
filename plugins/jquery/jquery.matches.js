/**
 * Function:  gives an alert with the matches of an $('element')-call.
 * Extends:   jQuery functions.
 * Since:     2010-09.
 */
(function($){
  
  $.fn.matches = function(alert){
    if(alert!==true) alert=false;
    var o = $(this), m = o.size()+' Matches';
    if(!alert) console.log(m);
    if(o.size() > 0) m += ":\n\n";
    $.each(o, function(i){
      if(!alert) console.log(this);
      else m = m 
        + (i < 9 ? '0'+(i+1) : (i+1))
        + ' : '
        + $('<div>').append($(this).clone().html('')).html().split('>')[0]+'>'
        + "\n\n";
    });
    if(alert) alert(m);
    return o;
  }
  
})(jQuery);