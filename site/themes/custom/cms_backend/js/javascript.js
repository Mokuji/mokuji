$(function(){

  //logo
  (function($){

    $('#page-topbar #logo a').click(function(e){

      e.preventDefault();

      $.ajax({
        url : $(this).attr('href'),
        data : {
          section: 'cms/app'
        }
      }).done(function(data){
        $("#page-main-right").html(data);
      });

    });

  })($);

  //menu dropdown
  (function($){

    $('#menu_dropdown').data('open', false).bind({
      'open' : function(){
        $(this).data('open', true).find('dd').children().show();
      },
      'close' : function(){
        $(this).data('open', false).find('dd').children().hide();
        $(this).find('input').blur();
      },
      'mouseleave' : function(){
        $(this).trigger('close');
      }
    })

    .find('dt a').click(function(e){

      e.preventDefault();

      if($(this).closest('dl').data('open') == false){
        $(this).closest('dl').trigger('open');
      }

      else{
        $(this).closest('dl').trigger('close');
      }

    });

    $('#menu_dropdown .new_menu form').submit(function(e){

      var name = $(this).find('input').val(), that = this;

      e.preventDefault();

      $.ajax({
        data:{
          ajax_action: 'cms/new_menu',
          menu_name: name
        },
        success: function(d){
          $(that)
            .closest('ul')
              .append('<li><span><a href="#'+d+'">'+name+'</a></span></li>')
              .append($('#menu_dropdown .new_menu'))
              .end()
            .find('input')
              .val('')
              .blur();
        }
      });

    });

    $('#menu_dropdown dd a').live('click', function(e){

      e.preventDefault();

      $(this).closest('dl').find('dt a').attr('href', $(this).attr('href')).html("<span>"+$(this).html()+"</span>").end().trigger('close');

      $.ajax({
        data:{
          ajax_action:'cms/select_menu',
          menu_id:$(this).attr('href').split('#')[1]
        },
        success:function(d){
          $('#page-main-left ._menu').replaceWith(d);
        }
      });

    });

  })($);

  //menu items
  $(function(){

    $('#page-main-left .menu-items-list a').on('click', function(e){

      e.preventDefault();

      $.ajax({
        url : $(this).attr('href'),
        data : {
          section: 'cms/app'
        }
      }).done(function(data){
        $("#page-main-right").html(data);
      });

    });

  });

  //config menu
  (function($){

    $('#widget_bar a').click(function(e){

      e.preventDefault();

      $.ajax({
        url : $(this).attr('href'),
        data : {
          section: 'cms/config_app'
        }
      }).done(function(data){
        $("#page-main-right").html(data);
      });

    });

  })($);

  //draggable sidebar
  $(function(){
    var i = 0;
    $('#widget-slider').mousedown(function(e){
      e.preventDefault();
      $(document).mousemove(function(e){
        if(e.pageX > 105 && e.pageX < 600){
          $("body").removeClass("cursor_disabled").addClass("cursor_resizing");
          $('#page-main-left').css("width", e.pageX+25);
          $('#page-main-right').css("padding-left",e.pageX+25);
        }
        else{
          $("body").removeClass("cursor_resizing").addClass("cursor_disabled");
        }
      });
    });
    $(document).mouseup(function(e){
      $("body").removeClass("cursor_resizing").removeClass("cursor_disabled");
      $(document).unbind('mousemove');
    });
  });

});
