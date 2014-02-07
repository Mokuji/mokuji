;(function($, global){
  
  //Global constants.
  global.GET = 1;
  global.POST = 2;
  global.PUT = 4;
  global.DELETE = 8;
  
  /**
   * Does an AJAX request.
   * 
   * @param {integer} method Which method to use. Possible values are `GET`, `POST`, `PUT`
   *                         and `DELETE`. Defaults to `GET` when omitted or faulty.
   * @param {string} model The name of the model to access on the server.
   * @param {object} data The request payload to send to the server.
   *
   * @return {jQuery.Deferred.Promise} The instance of the jQuery Deferred' promise object
   *                                   that handles the callbacks.
   */
  global.request = function(){
    
    //Predefine variables.
    var method, model, data;
    
    //Handle arguments.
    switch(arguments.length){
      
      //A get request to the given model name.
      case 1:
        method = GET;
        model = arguments[0];
        data = {};
        break;
      
      //A custom request to the given model name, or a PUT request with the given data.
      case 2:
        if(_(arguments[0]).isNumber()){
          method = arguments[0];
          model = arguments[1];
          data = {};
        }else{
          method = PUT;
          model = arguments[0];
          data = arguments[1];
        }
        break;
      
      //A custom request to given model name with given data.
      case 3:
        method = arguments[0];
        model = arguments[1];
        data = arguments[2];
        break;
      
    }
    
    _.log(model);
    
    //Should data be processed by jQuery?
    var process = (method == GET);
    
    //Stringify our JSON?
    if(!process) data = JSON.stringify(data);
    
    //Convert method to string for use in the jQuery ajax API.
    method = (method == GET && 'GET')
          || (method == POST && 'POST')
          || (method == PUT && 'PUT')
          || (method == DELETE && 'DELETE')
          || 'GET';
    
    //Build the url
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?rest=' + model;
    
    //Do it, jQuery!
    return $.ajax({
      url: url,
      type: method,
      data: data,
      dataType: 'json',
      contentType: 'application/json',
      processData: process,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    
  }
  
  //A template helper function.
  global.tmpl = function(id){
    
    return function(){
      var tmpl;
      if(!$.domReady){
        throw "Can not generate templates before DOM is ready.";
      }else{
        tmpl = tmpl || _.template($('#'+id).html());
        return $(tmpl.apply(this, arguments));
      }
    }
    
  }
  
  //A data-id extractor helper function.
  $.fn.id = function(setter){
    
    if(setter){
      return $(this).attr('data-id', setter);
    }
    
    return parseInt( $(this).attr('data-id') , 10 );
    
  };
  
  //http://api.jqueryui.com/category/selectors/
  (function(){
    
    function focusable( element, isTabIndexNotNaN ) {
      var map, mapName, img,
        nodeName = element.nodeName.toLowerCase();
      if ( "area" === nodeName ) {
        map = element.parentNode;
        mapName = map.name;
        if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
          return false;
        }
        img = $( "img[usemap=#" + mapName + "]" )[0];
        return !!img && visible( img );
      }
      return ( /input|select|textarea|button|object/.test( nodeName ) ?
        !element.disabled :
        "a" === nodeName ?
          element.href || isTabIndexNotNaN :
          isTabIndexNotNaN) &&
        // the element and all of its ancestors must be visible
        visible( element );
    }

    function visible( element ) {
      return $(element).is(':visible');
    }

    $.extend( $.expr[ ":" ], {
      data: $.expr.createPseudo ?
        $.expr.createPseudo(function( dataName ) {
          return function( elem ) {
            return !!$.data( elem, dataName );
          };
        }) :
        // support: jQuery <1.8
        function( elem, i, match ) {
          return !!$.data( elem, match[ 3 ] );
        },

      focusable: function( element ) {
        return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
      },

      tabbable: function( element ) {
        var tabIndex = $.attr( element, "tabindex" ),
          isTabIndexNaN = isNaN( tabIndex );
        return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
      }
    });
    
  })();

  
  //Mix in logging methods into underscore.
  _.mixin({
    
    log: function(object){
      console.log(object);
      return object;
    },
    
    dir: function(object){
      console.dir(object);
      return object;
    }
    
  });
    
})(jQuery, window);
