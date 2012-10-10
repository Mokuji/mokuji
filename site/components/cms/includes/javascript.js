;(function(root, $, _, undefined){
  
  //Do an ajax request.
  var GET=1, POST=2, PUT=4, DELETE=8;
  function request(){
    
    //Predefine variables.
    var method, model, data;
    
    //Handle arguments.
    switch(arguments.length){
      
      //A get request to the given model name.
      case 1:
        method = GET;
        model = arguments[0];
        data = {};
        break;
      
      //A custom request to the given model name, or a PUT request with the given data.
      case 2:
        if(_(arguments[0]).isNumber()){
          method = arguments[0];
          model = arguments[1];
          data = {};
        }else{
          method = PUT;
          model = arguments[0];
          data = arguments[1];
        }
        break;
      
      //A custom request to given model name with given data.
      case 3:
        method = arguments[0];
        model = arguments[1];
        data = arguments[2];
        break;
      
    }
    
    //Should data be processed by jQuery?
    var process = (method == GET);
    
    //Stringify our JSON?
    if(!process) data = JSON.stringify(data);
    
    //Convert method to string for use in the jQuery ajax API.
    method = (method == GET && 'GET')
          || (method == POST && 'POST')
          || (method == PUT && 'PUT')
          || (method == DELETE && 'DELETE')
          || 'GET';
    
    //Build the url
    var url = 'http://' + window.location.host + window.location.pathname + '?rest=' + model;
    
    //Do it, jQuery!
    return $.ajax({
      url: url,
      type: method,
      data: data,
      dataType: 'json',
      contentType: 'application/json',
      processData: process,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    
  }
  
  //A template helper function.
  function tmpl(id){
    
    return function(){
      var tmpl;
      if(!$.domReady){
        throw "Can not generate templates before DOM is ready.";
      }else{
        tmpl = tmpl || _.template($('#'+id).html());
        return $(tmpl.apply(this, arguments));
      }
    }
    
  }
  
  //A data-id extractor helper function.
  $.fn.id = function(setter){
    
    if(setter){
      return $(this).attr('data-id', setter);
    }
    
    return parseInt( $(this).attr('data-id') , 10 );
    
  };
  
  //Mixin a logging functions into underscore.
  _.mixin({
    
    log: function(object){
      console.log(object);
      return object;
    },
    
    dir: function(object){
      console.dir(object);
      return object;
    }
    
  });
  
  //The controller for the menu.
  var MenuController = Controller.sub({
    
    el: '#page-main-left > .content > .inner',
    namespace: 'menu',
    
    elements: {
      'el_toolbar': '#menu-items-toolbar > ul',
      'btn_newMenuItem': '#btn-new-menu-item',
      'btn_refreshMenuItems': '#btn-refresh-menu-items',
      'btn_saveMenuItems': '#btn-save-menu-items',
      'btn_selectMenu': '#btn-select-menu',
      'el_menuItemContainer': 'ul.menu-items-list',
      'el_menuItems': 'ul.menu-items-list > li',
      'el_message': '#user-message'
    },
    
    events: {
      
      'sortupdate on el_menuItemContainer': function(){
        this.updateData();
        this.makeSavable();
      },
      
      'click on btn_saveMenuItems': function(e){
        e.preventDefault();
        this.save();
      }
      
    },
    
    init: function(){
      
      //Call the parent initiator.
      this.previous();
      
      //Configure the nestedSortable plug-in.
      this.el_menuItemContainer.nestedSortable({
        disableNesting: 'no-nest',
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        listType: 'ul',
        items: 'li',
        maxLevels: 6,
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div'
      });
      
    },
    
    data: {},
    
    updateData: function(){
      this.data = this.el_menuItemContainer.nestedSortable('toArray', {
        startDepthCount: 0,
        attribute: 'rel',
        expression: (/()([0-9]+)/),
        omitRoot: true
      });
    },
    
    makeSavable: function(){
      this.btn_refreshMenuItems.addClass('revert');
      this.btn_saveMenuItems.show();
      this.btn_selectMenu.hide();
    },
    
    makeSelectable: function(){
      this.btn_refreshMenuItems.removeClass('revert');
      this.btn_saveMenuItems.hide();
      this.btn_selectMenu.show();
    },
    
    save: function(){
      
      var self = this;
      
      return request(PUT, 'menu/menu_items', this.data)
      
      .done(function(){
        self.makeSelectable();
        self.btn_selectMenu.hide();
        self.el_message.show();
        $.after(2000).done(function(){
          self.btn_selectMenu.show();
          self.el_message.hide();
        });
      })
      
      .fail(function(){
        
      });
      
    }
    
  });
  
  var app;
  root.Cms = new Class(null, {
    
    options: {
      
    },
    
    init: function(o){
      app = this;
      this.options = _(o).defaults(this.options);
      this.Menu = new MenuController;
    }
    
  });
  
})(this, jQuery, _);

$(function(){

  // Add pdf icons to pdf links.
  $("a[href$='.pdf']").addClass("pdf");
   
  // Add txt icons to document links (doc, rtf, txt).
  $("a[href$='.doc'], a[href$='.txt'], a[href$='.rft']").addClass("txt");

  // Add zip icons to Zip file links (zip, rar).
  $("a[href$='.zip'], a[href$='.rar']").addClass("zip"); 
  
  // Add image icons to Image file links (jpg, png).
  $("a[href$='.jpg'], a[href$='.png']").addClass("img"); 
  
  // Add email icons to email links.
  $("a[href^='mailto:']").addClass("email");

  //Add external link icon to external links.
  $('a[target="_blank"]').addClass("external");  

 });
