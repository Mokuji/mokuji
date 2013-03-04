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
    
    //When rendering of the tab templates has been done, do some final things.
    afterRender: function(){},
    
    //Saves the data currently present in the different tabs controlled by this controller.
    save: function(pageId){},
    
    afterSave: function(data){}
    
  });
  
  //Export the namespaced class.
  ProfileController.exportTo(exports, 'cmsBackend.account.ProfileController');
  
})(jQuery, window);
