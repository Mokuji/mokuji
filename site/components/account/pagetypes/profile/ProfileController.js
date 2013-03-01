(function($, exports){
  
  //Create a new page type controller called ProfileController.
  var ProfileController = PageType.sub({
    
    //Is this a new page?
    fresh: true,
    
    //Define the tabs to be created.
    tabs: {
      'Content': 'contentTab'
    },
    
    //Define the elements for jsFramework to keep track of.
    elements: {},
    
    //Retrieve input data (from the server probably).
    getData: function(pageId){
      
      var self = this
        , D = $.Deferred()
        , P = D.promise();
      
      //We do nothing here.
      D.resolve({page_id: pageId});
      
      return P;
      
    },
    
    // //When rendering of the tab templates has been done, do some final things.
    // afterRender: function(){
      
    //   //Turn the form on the content tab into a REST form.
    //   this.contentForm.restForm({success: this.proxy(this.afterSave)});
      
    //   //TODO: do things like initialize WYSIWYG editor.
    //   //Create unique id for the text editors.
    //   this.contentForm.find('textarea.editor').each(function(){
    //     var that = $(this);
    //     that.attr('id', that.attr('id')+Math.floor((Math.random()*100000)+1));
    //     tx_editor.init({selector:'#'+that.attr('id')});
    //   });
      
    // },
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(pageId){
      
      // return this.contentForm.trigger('submit');
      
    },
    
    // afterSave: function(data){
    //   this.contentForm.find('[name=id]').val(data.id);
    // }
    
  });
  
  //Export the namespaced class.
  ProfileController.exportTo(exports, 'cmsBackend.account.ProfileController');
  
})(jQuery, window);
