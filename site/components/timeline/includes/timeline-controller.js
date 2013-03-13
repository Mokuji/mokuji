(function($, exports){
  
  //Create a new page type controller called TimelineController.
  var TimelineController = PageType.sub({
    
    //Is this a dirty timeline preview?
    dirty: false,
    
    //Define the tabs to be created.
    tabs: {
      'Posts': 'postsTab',
      'Filters': 'filtersTab'
    },
    
    //Define the elements for jsFramework to keep track of.
    elements: {
      'filtersForm': '#timeline-filters-form',
      'timelinePreview': '#timeline-preview'
    },
    
    
    //Loads entries for this page.
    loadEntries: function(page){
      
      var self = this;
      
      //Since we're refreshing, remove dirty flag.
      self.dirty = false;
      
      //Pages start at 1.
      if(!page || page <= 0)
        page = 1;
      
      self.timelinePreview.html('<p class="loading">Loading...</p>');
      
      
      //Load a page of entries.
      $.rest('GET', '?rest=timeline/entries/'+page, self.filters)
      
      //When we got them.
      .done(function(entries){
        
        self.timelinePreview.empty();
        
        var hasEntries = false;
        
        $.each(entries, function(i){
          
          hasEntries = true;
          
          self.templateEntry(this)
            .appendTo(self.timelinePreview);
          
        });
        
        if(!hasEntries){
          self.timelinePreview.html('<p class="no-entries">There are no entries yet.</p>');
        }
        
        //Make sure the first tab (which has the previews) applies multilingual clauses.
        app.Page.Tabs.state.controllers[0].setMultilanguageSection(
          app.Page.Languages.currentLanguageData().id
        );
        
      })
      
      .error(function(){
        self.timelinePreview.html('<p class="error">Could not load preview.</p>');
      });
      
    },
    
    //Templates one entry based on entry data.
    templateEntry: function(data){
      
      //Template the entry template.
      return this.definition.templates.entry.tmpl(
        
        //With an extension of the given data (forces languages attribute, regardless of input).
        $.extend({}, data, {languages: app.Page.Languages.data.languages})
        
      );
      
    },
    
    //Retrieve input data (from the server probably).
    getData: function(pageId){
      
      var self = this
        , D = $.Deferred()
        , P = D.promise();
      
      //Retrieve input data from the server based on the page ID
      $.rest('GET', '?rest=timeline/page/'+pageId, {})
      
      //In case of success, this is no longer fresh.
      .done(function(d){
        self.page = d.page.page_id;
        D.resolve(d);
      })
      
      //In case of failure, provide default data.
      .fail(function(){
        D.resolve({
          page_id: pageId
        });
      });
      
      return P;
      
    },
    
    //When rendering of the tab templates has been done, do some final things.
    afterRender: function(){
      
      var self = this;
      
      //Load the filters used.
      self.filters = self.filtersForm.formToObject();
      
      //Make filters a REST form.
      self.filtersForm.restForm({
        success:function(filters){
          self.filters = filters;
        }
      });
      
      //When altering filters, flag the previews as dirty.
      self.filtersForm.on('change', ':input', function(){
        self.dirty = true;
        self.filters = self.filtersForm.formToObject();
      });
      
      //When switching tabs, see if we need to reload entries.
      app.Page.Tabs.subscribe('tabChanged', function(e, tab){
        
        //Reload if we need to.
        if(tab.title === 'Posts' && self.dirty)
          self.loadEntries();
        
      });
      
      //Load preview entries.
      self.loadEntries();
      
    },
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(e, pageId){
      
      //Save the filters.
      this.filtersForm.trigger('submit');
      
    },
    
    afterSave: function(data){
    }
    
  });

  //Export the namespaced class.
  TimelineController.exportTo(exports, 'cmsBackend.timeline.TimelineController');
  
})(jQuery, window);
