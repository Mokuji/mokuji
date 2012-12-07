;(function($, exports){
  
  /* -- Private -- */
  
  var pageTypeCache = {};
  
  function loadPageType(baseUrl, component, pageType, deferred){
    
    var pageTypeFolder = baseUrl + 'site/components/' + component + '/pagetypes/' + pageType + '/';
    
    //First get the json descriptor file.
    $.ajax({
      url: pageTypeFolder + 'definition.json',
      dataType: 'json',
      error: function(){ deferred.reject('Unable to load definition file.'); }
    })
    
    //When definition is in.
    .done(function(definition){
      
      //Get each javascript file to load, as well as each template file.
      //Don't do the callback before this is finished.
      
      var resources = [];
      
      //All JavaScript resources.
      for(var i = 0; i < definition.javascript.length; i++)
        resources.push($.getScript(pageTypeFolder + definition.javascript[i]));
      
      //All template resources.
      for(var key in definition.templates)
      {
        
        resources.push(
          $.ajax({
            url: '?pagetypetemplate=' + encodeURIComponent(component+'/'+pageType+'/'+definition.templates[key]),
            context: key
          }).done(function(data){
            //Store it in the definition as jQuery objects, ready for templating.
            definition.templates[this] = $('<script type="text/x-jquery-tmpl">').html(data);
          })
        );
        
      }
      
      //When all that is done.
      $.when.apply(null, resources).then(function(){
        
        //Resolve the namespaced controller.
        var target = window
          , namespaceParts = definition.controller.split('.');
        
        for(var i = 0; i < namespaceParts.length; i++)
        {
          
          if(!target[namespaceParts[i]])
            deferred.reject('Controller was not found.');
          
          target = target[namespaceParts[i]];
          
        }
        
        //And set it in the definition.
        definition.controller = target;
        
        //Store this in the cache.
        pageTypeCache[component+'/'+pageType] = definition;
        
        //Resolve the deferred.
        deferred.resolve(definition);
        
      });
      
    });
    
  }
  
  
  /* -- Public -- */
  
  var PageType = Controller.sub({
    
    el: '<div>',
    namespace: 'pagetype',
    
    init: function(definition, page){
      
      var self = this;
      
      //Call parent constructor.
      self.previous(null);
      
      //Add our view to it.
      page.view.find('#page-tab-body').append(this.view);
      
      //Define tabs, without content so far.
      var tabs = {};
      for(var key in self.tabs){
        tabs[key] = new PageTabController({el:'<div>', title:key});
        page.Tabs.add(tabs[key]);
        self.view.append(tabs[key].view);
      }
      
      //Get the data.
      $.when(self.getData(page.data.page.id))
      .then(function(data){
        
        //Merge data with static data.
        var fullData = {
          data: data['0'],
          languages: page.Languages.data.languages,
          templates: definition.templates
        };
        
        //Add the tab contents.
        for(var key in self.tabs){
          
          tabs[key].view.append(
            definition.templates[self.tabs[key]].tmpl(fullData)
          );
          
        }
        
        //Bind the save function.
        page.subscribe('save', self.proxy(self.save));
        
        //Bind language switching on multilingual sections.
        var setLanguage = function(e, language){
          for(var key in self.tabs)
            tabs[key].setMultilanguageSection(language.id);
        };
        page.Languages.subscribe('languageChange', setLanguage);
        
        //Set it to the current language.
        setLanguage(null, page.Languages.currentLanguageData());
        
        //Call afterRender at the next tick.
        setTimeout(self.proxy(function(){
          this.refreshElements();
          this.afterRender();
        }), 0);
        
      });
      
    }
    
  });
  
  PageType.extend({
    
    //Exports this class to a namespaced location without having to define each property manually if it doesn't exist.
    exportTo: function(target, name){
      
      var name_parts = name.split('.');
      for(var i = 0; i < name_parts.length-1; i++){
        if(!target[name_parts[i]])
          target[name_parts[i]] = {};
        target = target[name_parts[i]];
      }
      target[name_parts[name_parts.length-1]] = this;
      
      return this;
      
    },
    
    //Gets the Page Type and loads it if it hasn't been loaded yet.
    getPageType: function(baseUrl, pageTypeName){
      
      //Create deferred.
      var deferred = $.Deferred();
      
      //Split name.
      var nameParts = pageTypeName.split('/');
      
      //Check if the format is correct.
      if(nameParts.length != 2 || !nameParts[0].trim().length || !nameParts[1].trim().length)
        deferred.reject('Invalid PageType name, format is: <component>/<pageType>');
      
      //Store parts.
      var component = nameParts[0]
        , pageType = nameParts[1];
      
      //See if it needs to be loaded.
      if(!pageTypeCache[pageTypeName])
        loadPageType(baseUrl, component, pageType, deferred);
      
      //Otherwise resolve it from cache.
      else
        deferred.resolve(pageTypeCache[pageTypeName]);
      
      //Give the promise.
      return deferred.promise();
      
    }
    
  });
  
  exports.PageType = PageType;

})(jQuery, window);
