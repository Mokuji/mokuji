$(function(){

  //draggable sidebar
  $(function(){
    var i = 0;
    $('#widget-slider').mousedown(function(e){
      e.preventDefault();
      $(document).mousemove(function(e){
        
        if(e.pageX > 225 && e.pageX < 985){
          $("body").removeClass("cursor_disabled").addClass("cursor_resizing");
          $('#page-main-left').css("width", e.pageX+15);
          $('#page-main-right').css("padding-left",e.pageX+15);
          return;
        }
        
        else if(e.pageX <= 225){
          $('#page-main-left').css("width", 240);
          $('#page-main-right').css("padding-left", 240);
        }
        
        else{
          $('#page-main-left').css("width", 1000);
          $('#page-main-right').css("padding-left", 1000);
        }
        
        $("body").removeClass("cursor_resizing").addClass("cursor_disabled");
        
      });
    });
    $(document).mouseup(function(e){
      $("body").removeClass("cursor_resizing").removeClass("cursor_disabled");
      $(document).unbind('mousemove');
    });
  });

});
