(function($){
  
  //hash handling
  (function(){
  
    $(window).hashchange(function(){
      
      //remove "pretty" hash slash
      var hashdata = {}, key = null, hash = (window.location.hash.substr(0, 2) === '#/' ? window.location.hash.substr(2) : window.location.hash.substr(1));
      
      //parse hash
      $.each(hash.split('/'), function(k, v){
        
        if(key === null){
          key = v;
        }
        
        else{
          hashdata[key] = v;
          key = null;
        }
        
      });
      
      window.location.hashdata = hashdata;
    
    }).hashchange();
    
    window.location.setHash = function(){
      
      var hash = '#', val, set=false, hashObject;
      
      if(arguments.length == 2){
        hashObject = {key: arguments[1], val: arguments[0]};
      }
      
      else if(arguments.length == 1){
        hashObject = arguments[0];
      }
      
      else{
        return;
      }
      
      var newHashObject = $.extend({}, location.hashdata, hashObject);
      
      for(key in hashObject){
        val = hashObject[key];
        if(val === undefined || val === null || val.toString().length <= 0){
          delete newHashObject[key];
          delete hashObject[key];
        }
      }
      
      
      for(key in newHashObject){
        hash += '/'+key+'/'+newHashObject[key];
      }
      
      this.hash = hash;
      
    }
    
    window.location.unsetHash = function(key){
      
      var hash = '#';
      
      for(k in this.hashdata){
        if(k !== key){
          hash += '/'+k+'/'+this.hashdata[k];
        }
      }
      
      this.hash = hash;
    }
    
  })();
  
  //extend javascript String object with some handy methods
  $.extend(String.prototype, {
    
    toInt : function(){
      return parseInt(this);
    },
    
    toInteger : this.toInt,
    
    toFloat : function(){
      return parseFloat(this);
    },
    
    repeat : function(i){
      return new Array(parseInt(i)+1).join(this);
    },
    
    regex : function(regex){
      return regex.exec(this);
    }
    
  });
  
  //extend javascript Array object with some handy methods
  $.extend(Array.prototype, {
    
    indexOf : Array.prototype.indexOf || function(node){
      return $.inArray(node, this);
    },
    
    copy: function(){

      //>>TODO Lelijke oplossing. Krijgt nog steeds HTMLDocument objecten binnen van jQuery.
      var getObjectClass = function(obj) {
        if (obj && obj.constructor && obj.constructor.toString) {
          var arr = obj.constructor.toString().match(/function\s*(\w+)/);

          if (arr && arr.length == 2) {
            return arr[1];
          }
        }

        return undefined;
      }

      if(getObjectClass(this) == "Array")
        return this.slice(0);
    }
    
  });
  
  //set up jQuery ajax
  $.ajaxSetup({
    url: window.location.href.toString(),
    target: 'body'
  });

})(jQuery);
