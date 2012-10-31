;jQuery(function($){
  
  //Init notifications.
  var lastNotification = null;
  var fadeOld = function(){
    if(!lastNotification) return;
    
    lastNotification.fadeOut(function(){
      $(this).remove();
      lastNotification = null;
    });
  };

  //Clicking notifications away.
  $('body').on('click', '.notification', function(){
    $(this).fadeOut(function(){
      $(this).remove();
    });
  });
  
  //Notify
  $.notify = function(type, message){
    
    fadeOld();
    lastNotification = $('<div>')
      .addClass('static notification')
      .addClass(type)
      .text(message)
      .hide()
      .appendTo($('body'))
      .fadeIn();
    
  };

  //Flash
  $.flash = function(type, message){
    fadeOld();
    $('<div>')
      .addClass('flash notification')
      .addClass(type)
      .text(message)
      .hide()
      .appendTo($('body'))
      .fadeIn(function(){
        
        $(this)
          .delay(1500)
          .fadeOut(function(){
            $(this).remove();
          });
        
      });
    
  };
  
});

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
  
  var MenuToolbarController = Controller.sub({
    
    //The element and name-space.
    el: '#page-main-left .menu-items-toolbar',
    namespace: 'menu',
    
    //The sub-elements in the controllers HTML structure.
    elements: {
      'btn_newMenuItem': '#btn-new-menu-item',
      'btn_refreshMenuItems': '#btn-refresh-menu-items',
      'btn_saveMenuItems': '#btn-save-menu-items',
      'btn_selectMenu': '#btn-select-menu',
      'el_message': '#user-message'
    },
    
    //Bind events to the sub-elements.
    events: {
      
      'click on btn_saveMenuItems': function(e){
        var self = this;
        e.preventDefault();
        this.showMessage('Saving...');
        app.MenuItems.save().done(function(data, status, xhr){
          self.showComplete();
        });
      },
      
      'click on btn_refreshMenuItems': function(e){
        var self = this;
        e.preventDefault();
        this.showMessage('Re'+($(e.target).hasClass('revert') ? 'vert' : 'fresh')+'ing...');
        app.MenuItems.reload().done(function(data, status, xhr){
          self.makeSelectable();
        });
      },
      
      'change on btn_selectMenu': function(e){
        var self = this;
        e.preventDefault();
        this.showMessage('Loading...');
        app.options.menu_id = $(e.target).val();
        app.MenuItems.reload().done(function(data, status, xhr){
          self.makeSelectable();
        });
      },
      
    },
    
    //Store timeouts.
    timeout: false,
    
    //Configure the toolbar in such a way that the save button is visible.
    makeSavable: function(){
      this.btn_refreshMenuItems.addClass('revert');
      this.btn_saveMenuItems.show();
      this.el_message.hide();
      this.btn_selectMenu.hide();
      this.timeout && this.timeout.clear();
    },
    
    //Configure the toolbar is such a way that the select menu drop-down is visible.
    makeSelectable: function(){
      this.btn_refreshMenuItems.removeClass('revert');
      this.btn_saveMenuItems.hide();
      this.el_message.hide();
      this.btn_selectMenu.show();
      this.timeout && this.timeout.clear();
    },
    
    //Configure the toolbar to indicate that it's doing something.
    showMessage: function(msg){
      this.btn_saveMenuItems.hide();
      this.btn_selectMenu.hide();
      this.el_message.text(msg).show();
    },
    
    //Configure the toolbar to indicate that it's done doing something.
    showComplete: function(func){
      var self = this;
      self.btn_saveMenuItems.hide();
      self.btn_selectMenu.hide();
      self.el_message.text('Successful.').show();
      this.timeout = $.after(2000).done(function(){
        self[func ? func : 'makeSelectable']();
      });
    }
    
  });
  
  //The controller for the menu.
  var MenuItemsController = Controller.sub({
    
    el: '#page-main-left > .content > .menu-items-list',
    namespace: 'menu',
    
    elements: {
      'el_items': 'li',
      'btn_delete': '.icon-delete'
    },
    
    events: {
      
      'sortupdate': function(){
        this.updateData();
        app.MenuToolbar.makeSavable();
      },
      
      'click on btn_delete': function(e){
        e.preventDefault();
        this.deleteItem($(e.target).closest('li').id())
      }
      
    },
    
    //Method: Initiate.
    init: function(){
      
      //Call the parent initiator.
      this.previous();
      
      //Configure the nestedSortable plug-in.
      this.configureSortable();
      
    },
    
    //Property: Storage for data.
    data: {},
    
    //Method: Updates the data using the HTML. (I know, wrong way around..)
    updateData: function(){
      
      this.data = this.view.nestedSortable('toArray', {
        startDepthCount: 0,
        attribute: 'rel',
        expression: (/()([0-9]+)/),
        omitRoot: true
      });
      
    },
    
    //Method: Save the data to the server.
    save: function(){
      
      return request(PUT, 'menu/menu_items', this.data);
      
    },
    
    //Method: Delete the item from the list and the server.
    deleteItem: function(id){
      
      var $item = this.el_items.filter('[data-id='+id+']');
      
      $item.hide();
      
      return (request(DELETE, 'menu/menu_item/'+id)
        
        .done(function(){
          $item.remove();
        })
        
        .fail(function(){
          console.dir(arguments);
          $item.show();
        })
        
      );
      
    },
    
    //Method: Reloads the menu items from the server.
    reload: function(){
      
      //Reference to this.
      var self = this;
      
      //Do the Ajax call and create the Deferred.
      return $.ajax('?section=cms/menu_items', {
        data:{options: {menu_id: app.options.menu_id, site_id: app.options.site_id}}
      })
      
      //Add a done callback.
      .done(function(data){
        var $view = $(data);
        self.view.replaceWith($view);
        self.view = $view;
        self.configureSortable();
        self.refreshElements();
        self.bindEvents();
        self.updateData();
      });
      
    },
    
    //Method: Configure the nestedSortable jQuery plug-in on this view.
    configureSortable: function(){
      
      this.view.nestedSortable({
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
      
      this.MenuItems = new MenuItemsController;
      this.MenuToolbar = new MenuToolbarController;
      this.Main = new MainManager;
      
      this.App = new PageAppManager;
      this.Settings = new SettingsController;
      // this.Main.add([this.Settings, this.App]);
      
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
