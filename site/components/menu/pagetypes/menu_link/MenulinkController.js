(function($, exports){
  
  //Create a new page type controller called MenulinkController.
  var MenulinkController = PageType.sub({
    
    //Define the tabs to be created.
    tabs: {'Content': 'contentTab'},
    
    //Define the elements for jsFramework to keep track of.
    elements: {
      'linkerForm': '#menu_linker'
    },
    
    //Retrieve input data (from the server probably).
    getData: function(pageId){
      
      var D = $.Deferred()
        , P = D.promise();
      
      var items = {};
      
      app.MenuItems.el_items.each(function(i){
        var $item = app.MenuItems.el_items.eq(i);
        items[$item.attr('data-id')] = ('&nbsp;&nbsp;'.repeat(parseInt($item.attr('data-depth'), 10) - 1)) +
          $item.find('a.menu-item').text();
      });
      
      $.rest('GET', '?rest=menu/link/'+pageId).done(function(link){
        link.items = items;
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
      
      this.linkerForm.ajaxSubmit({
        data: {page_id:pageId}
      });
      
    },
    
    afterSave: function(data){
      // this.linkerForm.find('[name=id]').val(data.id);
    }
    
  });
  
  //Export the namespaced class.
  MenulinkController.exportTo(exports, 'cmsBackend.menu.MenulinkController');
  
})(jQuery, window);
