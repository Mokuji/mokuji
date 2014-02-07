(function($, exports){
  
  //Create a new page type controller called MenulinkController.
  var ExternalUrlController = PageType.sub({
    
    //Define the tabs to be created.
    tabs: {'Content': 'contentTab'},
    
    //Define the elements for jsFramework to keep track of.
    elements: {
      'form': '#external_url_form'
    },
    
    //Retrieve input data (from the server probably).
    getData: function(pageId){
      
      var D = $.Deferred()
        , P = D.promise();
      
      $.rest('GET', '?rest=menu/external_url/'+pageId).done(function(link){
        link.menu_item_id = link.id;
        D.resolve(link);
      }).error(function(){
        D.reject('Can\'t get link information.');
      });
      
      return P;
      
    },
    
    //When rendering of the tab templates has been done, do some final things.
    afterRender: function(){},
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(e, pageId){
      
      this.form.ajaxSubmit({
        data: {page_id:pageId}
      });
      
    },
    
    afterSave: function(data){
      // this.form.find('[name=id]').val(data.id);
    }
    
  });
  
  //Export the namespaced class.
  ExternalUrlController.exportTo(exports, 'cmsBackend.menu.ExternalUrlController');
  
})(jQuery, window);
