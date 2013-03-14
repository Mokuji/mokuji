(function($, exports){
  
  //Create a new page type controller called TimelineController.
  var TimelineController = PageType.sub({
    
    //Is this a dirty timeline preview?
    dirty: false,
    
    //Cache timelines and filters.
    timelines: {},
    filters: {},
    
    //Force a language?
    force_language: false,
    
    //Define the tabs to be created.
    tabs: {
      'Entries': 'entriesTab',
      'Composition': 'compositionTab'
    },
    
    //Define the elements for jsFramework to keep track of.
    elements: {
      'titleForm': '#timeline-title-form',
      'compositionForm': '#timeline-composition-form',
      'compositionFormInput': '#timeline-composition-form :input',
      'timelinePreview': '#timeline-preview',
      'paginationWrapper': '.pagination-wrapper',
      'editingPage': '.pagination-wrapper .page-2',
      'btn_edit_item': '.edit-item',
      'btn_entry_cancel': '#timeline-entry-form .cancel',
      'sel_force_language': '#timeline-composition-form select[name=force_language]'
    },
    
    events: {
      
      'click on btn_edit_item': function(e){
        e.preventDefault();
        this.editEntry($(e.target).attr('data-entry'));
      },
      
      'click on btn_entry_cancel': function(e){
        e.preventDefault();
        this.returnToPosts();
      },
      
      'change on compositionFormInput': function(e){
        this.dirty = true;
        this.filters = this.compositionForm.formToObject();
      },
      
      'change on sel_force_language': function(e){
        var value = $(e.target).val();
        this.force_language = value > 0 ? value : false;
        this.editingPage.find(':input[name=force_language]').val(value);
      }
      
    },
    
    //Return to posts.
    returnToPosts: function(){
      
      var self = this;
      
      self.paginationWrapper.animate({left:'0%'}, 300, function(){
        self.editingPage.empty();
        self.refreshElements();
      });
      
    },
    
    //Edit entry.
    editEntry: function(id){
      
      var self = this;
      
      self.paginationWrapper.animate({left:'-100%'}, 300);
      
      self.editingPage.html('<p class="loading">Loading...</p>');
      
      $.rest('GET', '?rest=timeline/entry/'+id).done(function(data){
        
        self.editingPage.empty();
        
        var form = self.definition.templates.entryEdit.tmpl({
          data: data,
          page_id: self.page,
          timelines: self.timelines,
          force_timeline: self.filters && self.filters.timeline_id ? self.filters.timeline_id : false,
          force_language: self.force_language,
          languages: app.Page.Languages.data.languages
        }).appendTo(self.editingPage);
        
        form.restForm({
          success: function(entry){
            self.loadEntries();
            self.returnToPosts();
          }
        });
        
        //Create unique id for the text editors.
        form.find('textarea.editor').each(function(){
          var $that = $(this);
          $that.attr('id', $that.attr('id')+Math.floor((Math.random()*100000)+1));
          tx_editor.init({selector:'#'+$that.attr('id')});
        });
        
        //Refresh elements.
        self.refreshElements();
        
        //Make sure the first tab (which has the previews) applies multilingual clauses.
        app.Page.Tabs.state.controllers[0].setMultilanguageSection(
          self.force_language > 0 ? self.force_language :
          app.Page.Languages.currentLanguageData().id
        );
        
      });
      
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
        
        //Refresh elements.
        self.refreshElements();
        
        //Make sure the first tab (which has the previews) applies multilingual clauses.
        app.Page.Tabs.state.controllers[0].setMultilanguageSection(
          self.force_language > 0 ? self.force_language :
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
      return this.definition.templates.entry.tmpl({
        data: data,
        force_language: self.force_language,
        languages: app.Page.Languages.data.languages
      });
      
    },
    
    //Refresh the composition form.
    refreshComposition: function(data){
      
      //Template the composition template and replace HTML.
      this.compositionForm.replaceWith(
        this.definition.templates.compositionTab.tmpl({
          data: data,
          languages: app.Page.Languages.data.languages
        })
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
        self.timelines = d.timelines;
        self.force_language = d.page.force_language ? d.page.force_language : false,
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
      self.filters = self.compositionForm.formToObject();
      
      //Make filters a REST form.
      self.compositionForm.restForm({
        beforeSubmit: function(data){
          $.extend(true, data, self.titleForm.formToObject());
        },
        success:function(data){
          self.filters = data.page;
          self.refreshComposition(data);
        }
      });
      
      //When switching tabs, see if we need to reload entries.
      app.Page.Tabs.subscribe('tabChanged', function(e, tab){
        
        //Reload if we need to.
        if(tab.title === 'Entries'){
          
          //Fresh diapers are applied here.
          if(self.dirty)
            self.loadEntries();
          
          //Force disable language tabs if it's set.
          app.Page.setMultilingual(self.force_language === false);
          
        }
        
        
      });
      
      //Force language please.
      app.Page.setMultilingual(self.force_language === false);
      
      //Load preview entries.
      self.loadEntries();
      
    },
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(e, pageId){
      
      //Save the filters (which chains into titles).
      this.compositionForm.trigger('submit');
      
    },
    
    afterSave: function(data){
    }
    
  });

  //Export the namespaced class.
  TimelineController.exportTo(exports, 'cmsBackend.timeline.TimelineController');
  
})(jQuery, window);
