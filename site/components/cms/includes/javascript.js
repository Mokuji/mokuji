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
    
    el: '#page-main-left > .content',
    namespace: 'menu',
    
    elements: {
      'el_toolbar': '#menu-items-toolbar > ul',
      'btn_newMenuItem': '#btn-new-menu-item',
      'btn_refreshMenuItems': '#btn-refresh-menu-items',
      'btn_saveMenuItems': '#btn-save-menu-items',
      'btn_selectMenu': '#btn-select-menu',
      'el_menuItemContainer': '.menu-items-list',
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
      self.btn_saveMenuItems.hide();
      self.el_message.text('Saving...').show();
      
      return request(PUT, 'menu/menu_items', this.data)
      
      .done(function(){
        self.makeSelectable();
        self.btn_selectMenu.hide();
        self.el_message.text('Successful').show();
        $.after(2000).done(function(){
          self.btn_selectMenu.show();
          self.el_message.hide();
        });
      })
      
      .fail(function(){
        
      });
      
    }
    
  });
  
  //The state-machine for the main content.
  var MainManager = Manager.sub({
    
    el: '#page-main-right',
    namespace: 'main'
    
  });
  
  //The controller for the page-application.
  var PageAppManager = Manager.sub({
    
    el: '#app',
    namespace: 'main'
    
  });
  
  var PageController = Controller.sub({});
  var ItemController = Controller.sub({});
  
  //The controller for the settings interface.
  var SettingsController = Controller.sub({
    
    el: '<div>',
    namespace: 'main'
    
  });
  
  var app;
  root.Cms = new Class(null, {
    
    options: {
      
    },
    
    init: function(o){
      
      app = this;
      this.options = _(o).defaults(this.options);
      
      this.Menu = new MenuController;
      this.Main = new MainManager;
      
      this.App = new PageAppManager;
      this.Settings = new SettingsController;
      this.Main.add([this.Settings, this.App]);
      
      // this.Page = new PageController;
      // this.Item = new ItemController;
      // this.App.add([this.Page, this.Item]);
      
    }
    
  });
  
})(this, jQuery, _);

$(function(){
  
  /* =Select site
  -------------------------------------------------------------- */
  $("#btn-select-site").on('change', function(e){
    
    $.ajax({
      url: '?section=cms/menu_item_list&site_id='+$(e.target).val()
    }).done(function(d){
      $("#page-main-left .menu-item-list").html(d);
    });
    
  });
  
  /* =Select menu
  -------------------------------------------------------------- */
  $("#btn-select-menu").on('change', function(e){
    
    $.ajax({
      url: '?section=cms/menu_items&menu_id='+$(e.target).val()
    }).done(function(d){
      $("#page-main-left .menu-item-list").html(d);
    });
    
  });
  
  /* =New menu item
  -------------------------------------------------------------- */
  $("#btn-new-menu-item").on('click', function(e){

    e.preventDefault();

    $.ajax({
      url: $(this).attr('href')
    }).done(function(d){
      $("#page-main-right").html(d);
    });

  });

  /* =Revert/refresh menu
  -------------------------------------------------------------- */
  $("#btn-refresh-menu-items").on('click', function(e){

    e.preventDefault();

    $.ajax({
      url: $(this).attr('href')
    }).done(function(d){
      $("#page-main-left .menu-item-list").html(d);
    });

  });

  /* =Delete menu item
  -------------------------------------------------------------- */
  $(".menu-items-list .icon-delete").on("click", function(){

    if(confirm("Weet u zeker dat u dit menu-item wilt verwijderen?")){

      var _this = $(this);

      $.ajax({
        url: $(this).attr("href")
      }).done(function(){
        $(_this).closest("li").slideUp();
      });

    }

  });

  //menu items
  $(function(){

    $('#page-main-left .menu-items-list a').on('click', function(e){

      e.preventDefault();

      $.ajax({
        url : $(this).attr('href'),
        data : {
          section: 'cms/app'
        }
      }).done(function(data){
        $("#page-main-right").html(data);
      });

    });

  });

  //config menu
  (function($){

    $('#widget_bar a').click(function(e){

      e.preventDefault();

      $.ajax({
        url : $(this).attr('href'),
        data : {
          section: 'cms/config_app'
        }
      }).done(function(data){
        $("#page-main-right").html(data);
      });

    });

  })($);
  
});
