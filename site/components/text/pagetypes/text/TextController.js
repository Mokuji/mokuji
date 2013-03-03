(function($, exports){
  
  //Create a new page type controller called TextController.
  var TextController = PageType.sub({
    
    //Is this a new page?
    fresh: true,
    
    //Define the tabs to be created.
    tabs: {
      'Content': 'contentTab'
    },
    
    //Define the elements for jsFramework to keep track of.
    elements: {
      'contentForm': '#text-contentTab-form'
    },
    
    //Retrieve input data (from the server probably).
    getData: function(pageId){
      
      var self = this
        , D = $.Deferred()
        , P = D.promise();
      
      //Retrieve input data from the server based on the page ID
      $.rest('GET', '?rest=text/items', {
        pid: pageId
      })
      
      //In case of success, this is no longer fresh.
      .done(function(d){
        self.fresh = false;
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
      
      //Turn the form on the content tab into a REST form.
      this.contentForm.restForm({success: this.proxy(this.afterSave)});
      
      //Create unique id for the text editors.
      this.contentForm.find('textarea.editor').each(function(){
        var that = $(this);
        that.attr('id', that.attr('id')+Math.floor((Math.random()*100000)+1));
        tx_editor.init({selector:'#'+that.attr('id')});
      });

      //Hide description field by default, init click event handler.
      this.contentForm
        .find('.toggle-wrapper.description .trigger').on('click', function(e){
          e.preventDefault();
          $(this).closest('.toggle-wrapper').toggleClass('open');
        });

    },
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(pageId){
      
      return this.contentForm.trigger('submit');
      
    },
    
    afterSave: function(data){
      this.contentForm.find('[name=id]').val(data.id);
    }
    
  });
  
  //Export the namespaced class.
  TextController.exportTo(exports, 'cmsBackend.text.TextController');
  
})(jQuery, window);
