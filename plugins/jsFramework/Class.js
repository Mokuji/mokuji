;(function($, exports){
  
  var Class = function(parent, includes){
    
    //clazz; a contructor function with class
    var clazz = function(){
      
      //make copies of all plain objects to prevent different instances from sharing references to the same object
      for(var i in this){
        if( $.isPlainObject(this[i]) ) this[i] = $.extend(true, {}, this[i]);
      }
      
      //call the init callback
      this.init.apply(this, arguments);
      
    };
    
    //inherit static members from parent
    Class.inherit(clazz, (parent || {}));
    
    //extend static members with the methods needed on every instance of Class
    $.extend(clazz, {
      fn:       clazz.prototype,
      proxy:    function(func){ return $.proxy(func, this); },
      extend:   function(obj){ Class.inherit(this, obj); },
      include:  function(obj){ Class.inherit(this.fn, obj); },
      sub:      function(inc){ return new Class(this, (inc || {})); }
    });
    
    //inherit prototype members from parent and includes
    Class.inherit(clazz.fn, ((parent && parent.fn) || {init:$.noop}), (includes || {}));
    
    //extend class prototype members with methods needed on every instance of Class
    $.extend(clazz.fn, {
      parent: clazz,
      proxy:  clazz.proxy,
      extend: clazz.extend
    });
    
    //add the init function
    $.isFunction(clazz.fn.init) || $.extend(clazz.fn, {init:$.noop});
    
    //call the subclassed callback if this has a parent
    parent && $.isFunction(parent.subclassed) && parent.subclassed.call(parent, clazz);
    
    //return clazz as being an instance of Class
    return clazz;

  };
  
  /** 
  * Class.inherit is extended $.extend functionality that deals with wrapping inherited
  * functions in a "this.previous()"-enabling wrapper and cloning objects.
  */
  Class.inherit = function(){
    
    //handle arguments
    var
      args = $.makeArray(arguments),
      target = args.shift();
    
    //multiple arguments may be passed to Class.inherit, as such: Class.inherit(target[, object[, ...]]);
    for(var i=0; i<args.length; i++){
      
      //a reference to the current argument for easy access
      var object = args[i];
      
      //we can't do anything with scalar arguments, so we'll just skip them
      if(scalar(object)){
        continue;
      }
      
      //itterate the object
      for(var name in object){
        
        //if the current node is a function, and the node in the target having the same name is also a function
        if($.isFunction(target[name]) && $.isFunction(object[name])){
          
          //then we wrap the new function in a "hidden" wrapper that temporarily sets a "previous()" method on the object, refering to the old function
          target[name] = (function(t, o){
            return function(){
              var ret, args = arguments;
              this.previous = function(){
                return t.apply(this, (arguments.length ? arguments : args));
              };
              ret = o.apply(this, args);
              this.previous = null;
              delete this.previous;
              return ret;
            }
          })(target[name], object[name]);          
        
        }
        
        //if the current node is an object, we are going to make a deep copy of it, to prevent subclasses from sharing references to the same object
        else if( $.isPlainObject(object[name]) ){
          target[name] = $.extend(true, {}, object[name]);
        }
        
        //or do nothing special
        else{
          target[name] = object[name];
        }
        
      }
      
    }
    
  };
  
  exports.Class = Class;
  
})(jQuery, window);
