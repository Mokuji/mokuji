;(function($, exports){
  
  var Controller = new Class;
  
  //Controller.extend({
    
    //routes: {},
    //hash: window.location.hash,
    
    // /**
    // * route();          initiate routing based on what the url is right now
    // * route('/path');   take the user to the given route
    // */
    //route: function(){
      
      //for(i in this.routes){
        
        
        
      // }
      
    // },
    
    //add_route: function(route, destination){
      //this.routes[route] = destination;
    // },
    
    // //eg: "users/?id"
    // //eg: "users/?/edit"
    //parse_route: function(route){
      
      //var segments = route.split('/'), output = [];
      
      //for(var i=0, l=segments.length; i < l; i++){
        
        //var segment = {};
        
        //if(/^[a-zA-Z_-]+$/.test(segments[i])){
          //segment.type = 'section';
          //segment.name = segments[i];
        // }
        //else if(/^\?[a-zA-Z_-]+$/.test(segments[i])){
          //segment.type = 'parameter';
          //segment.name = segments[i].substr(1);
        // }
        //else if(/^\?$/.test(segments[i])){
          //segment.type = 'parameter';
          //segment.name = undefined;
        // }
        
        //output.push(segment);
        
      // }
      
      //return output;
      
    // }
    
  // });
  
  Controller.extend({
    
    subclassed: function(child){
    
      if(child.fn.elements) child.fn.elements = $.extend({}, this.fn.elements, child.fn.elements);
      if(child.fn.events) child.fn.events = $.extend({}, this.fn.events, child.fn.events);
    
    }
    
  });
  
  Controller.include({
    
    view: null,
    namespace: null,
    eventMatcher: /^(\w+(?:(?: or |\/)\w+)*)\s*(?:on\s+)?(.*)$/,
    eventSplitter: / or |\//,
    elements: {},
    events: {},
    
    //default action for activate
    activate: function(){
      this.view.show();
    },
    
    //default action for deactivate
    deactivate: function(){
      this.view.hide();
    },
    
    //initiating controllers
    init: function(){
      
      if( ! $.domReady) throw('Can not create Controller instances before DOM is ready.');
      
      //handle arguments
      var init, el, namespace, map, args = $.makeArray(arguments);
      
      if(args.length == 1){
        if( $.isPlainObject(args[0]) ){
          map = args[0];
        }else{
          el = args[0];
        }
      }
      
      else if(args.length == 2){
        if( $.isPlainObject(args[1]) ){
          el = args[0];
          map = args[1];
        }else{
          el = args[0];
          namespace = args[1];
        }
      }
      
      else if(args.length == 3){
        el = args[0];
        namespace = args[1];
        map = args[2];
      }
      
      el = el || (map && map.el) || this.view || this.el || false;
      namespace = namespace || (map && map.namespace) || this.namespace || false;
      map = map || {};

      if(el === false || namespace === false){
        console.log(el, namespace);
        throw "Invalid arguments. Element and namespace required.";
      }
      //eof handle arguments

      this.view = $(el);
      this.namespace = namespace;
      
      if(map){
        for(var i in map){
          switch(i){
            case 'elements': case 'events': $.extend(this[i], map[i]); break;
            case 'init': init = map[i]; break;
            default: //this[i] = map[i];
              var obj = {};
              obj[i] = map[i];
              Class.inherit(this, obj);
              break;
          }
        }
        map.el && delete map.el;
      }
      
      
      this.refreshElements();
      this.bindEvents();
      
      $.isFunction(init) && init.call(this);
      
    },
    
    //refresh elements
    refreshElements: function(){
      for(var key in this.elements) this[key] = $(this.elements[key], this.view);
    },
    
    //bind events (to a new namespace)
    bindEvents: function(namespace){
      
      this.view.contents().off('.'+this.namespace);
      
      if(namespace) this.namespace = namespace;
      
      if(!this.namespace) throw "Namespace required.";
      
      for(var key in this.events){
        
        var func, method = this.events[key];
        
        if($.isFunction(method)){
          func = this.proxy(method);
        }
        
        else if($.isArray(method)){
          
          method = method.copy();
          var methodName = method.shift();
          var methodArgs = method;
          
          func = this.proxy(function(){
            var func = this.proxy(this[methodName]);
            if( ! $.isFunction(func) ) throw "Function "+methodName+" is not a function.";
            func.apply(this, methodArgs);
          });
          
        }
        
        else{
          func = this.proxy(this[method]);
        }
        
        if( ! $.isFunction(func) ) throw "Function "+method+" is not a function.";
        
        var events = key.split(' and ');
        
        for(var i = 0; i < events.length; i++){
          
          var
            match = events[i].match(this.eventMatcher),
            event = match[1],
            selector = this.elements[match[2]] || match[2];
          
          event = $.map(event.split(' or '), this.proxy(function(val){
            return val + '.' + this.namespace;
          })).join(' ');
          
          if(selector){
            this.view.on(event, selector, func);
          }else{
            this.view.on(event, func);
          }
          
        }
        
      }
      
      return this;
      
    }//,
    
    // //bind routes to methods
    //bindRoutes: function(){
      //for(i in this.routes){
        //Controller.addRoute(i, this.routes[i]);
      // }
    // }
    
  });
  
  exports.Controller = Controller;

})(jQuery, window);
