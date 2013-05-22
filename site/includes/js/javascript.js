//Make trim() available for IE8-.
if (!String.prototype.trim) {
  String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};
}

//Only if jQuery is present.
if(window.$) (function($){
  
  var i18n = {
    hasLoaded: false,
    baseUrl: null,
    locale: null,
    components: {
      "/": null //Always load root
    },
    translations: {} //Per component. Root is called '/'.
  };
  
  var i18nLoad = function(){
    
    jQuery(function($){
      
      for(var name in i18n.components){
        
        if(i18n.components[name] !== null)
          continue;
        
        var isRoot = name === '/';
        
        $.ajax(i18n.baseUrl + (isRoot ?
          'site/i18n/'+i18n.locale :
          'site/components/'+name+'/i18n/'+i18n.locale
        ) + '.json').done(function(translations){
          i18n.translations[name] = translations;
          i18n.components[name] = true;
        });
        
        i18n.components[name] = false;
        
      }
      
      i18n.hasLoaded = true;
      
    });
    
    return window;
    
  };
  
  //Do an initial load when jQuery is ready.
  jQuery(function($){
    if(i18n.locale && i18n.baseUrl)
      i18nLoad();
  });
  
  window.i18nSetup = function(locale, baseUrl){
    
    if(i18n.locale !== null)
      throw('Locale has already been set.');
    
    if(locale.toString().length < 5)
      throw('Locale needs to be a string of at least 5 characters. Example: en-GB');
    
    if(i18n.baseUrl !== null)
      throw('Base URL has already been set.');
    
    i18n.locale = locale.toString();
    i18n.baseUrl = baseUrl.toString();
    
    return window;
    
  };
  
  //This function includes a component to be translated.
  window.includeTranslations = function(component){
    
    //Already tried this one.
    if(i18n.components.hasOwnProperty(component) && i18n.components[component] !== null)
      return window;
    
    //Queue it.
    i18n.components[component] = null;
    
    if(i18n.hasLoaded){
      i18nLoad();
    }
    
    return window;
    
  };
  
  window.transf = function(){
    
    if(i18n.hasLoaded !== true)
      window.console &&
      window.console.log &&
      window.console.log('Tried to translate before loading completed.');
    
    var args = [];
    for(var i in arguments)
      args[i] = arguments[i];
    
    var component = args.shift() || '/'
      , phrase = args.shift();
    
    if(component == undefined || phrase == undefined)
      throw('Not enough arguments. transf(component, phrase[, paramN, ...])');
    
    var available = i18n.hasLoaded && i18n.translations[component] && i18n.translations[component][phrase]
      , fallback = i18n.hasLoaded && !(available || component === '/')
    ;
    
    //Fallback is kind of special.
    if(fallback){
      args.unshift('/', phrase);
      return window.transf.apply(this, args);
    }
    
    //Get a translated version of the format.
    var format = available && i18n.translations[component][phrase] || phrase;
    
    //Do a pattern replace.
    return format.replace(/\{\d+\}/g, function(capture){ return args[capture.match(/\d+/)]; });
    
  };
  
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
