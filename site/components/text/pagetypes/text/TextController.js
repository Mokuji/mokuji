(function($, exports){
  
  //Create a new page type controller called TextController.
  var TextController = PageType.sub({
    
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
      
      //Retrieve input data from the server based on the page ID
      return $.rest('GET', '?rest=text/items', {
        pid: pageId
      });
      
    },
    
    //When rendering of the tab templates has been done, do some final things.
    afterRender: function(){
      
      //Turn the form on the content tab into a REST form.
      this.contentForm.restForm();
      
      //TODO: do things like initialize WYSIWYG editor.
      //Create unique id for the text editors.
      this.contentForm.find('textarea.editor').each(function(){
        var that = $(this);
        that.attr('id', that.attr('id')+Math.floor((Math.random()*100000)+1));
        tx_editor.init({selector:'#'+that.attr('id')});
      });
      
    },
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(pageId){
      
      //Trigger submit on the content form.
      this.contentForm.trigger('submit');
      
      //TODO: use a custom way of submitting the settings tab's data to the server.
      
    }
    
  });
  
  //Export the namespaced class.
  TextController.exportTo(exports, 'cmsBackend.text.TextController');
  
})(jQuery, window);
