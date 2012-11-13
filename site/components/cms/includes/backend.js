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
      
      'click on btn_newMenuItem': function(e){
        e.preventDefault();
        app.Item.loadItemContents('0');
        app.Page.clear();
      },
      
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
    menuItemTmpl: '#menu-item-list-item-tmpl',
    
    elements: {
      'el_items': 'li',
      'btn_delete': '.icon-delete',
      'item': 'a.menu-item'
    },
    
    events: {
      
      'sortupdate': function(){
        this.updateData();
        app.MenuToolbar.makeSavable();
      },
      
      'click on btn_delete': function(e){
        e.preventDefault();
        this.deleteItem($(e.target).closest('li').id())
      },
      
      'click on item': function(e){
        e.preventDefault();
        app.Item.loadItemContents($(e.target).attr('data-menu-item'));
        app.Page.loadPageContents($(e.target).attr('data-page'));
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
    
    //Method: Inserts or updates a new menu item.
    updateItem: function(data){
      
      data.site_id = app.options.site_id;
      
      var element = this.view.find('li[data-id='+data.id+']');
      
      //Insert
      if(element.size() == 0){
        this.view.prepend($(this.menuItemTmpl).tmpl(data));
      }
      
      //Update
      else{
        data.depth = element.attr('class').match(/depth_(\d+)/)[1];
        var subitems = element.children('ul');
        data.subitems = subitems.length ? subitems[0].outerHTML : '';
        element.replaceWith($(this.menuItemTmpl).tmpl(data));
      }
      
      this.configureSortable();
      this.refreshElements();
      this.updateData();
      
    },
    
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
  
  var LanguageTabController = Controller.sub({
    
    namespace: 'content',
    
    events:{
      'click': function(e){
        e.preventDefault();
        this.activate();
      }
    },
    
    init: function(){
      this.previous();
      this.data = {
        id: this.view.attr('data-id'),
        code: this.view.attr('data-code'),
        shortcode: this.view.attr('data-shortcode'),
        title: this.view.attr('data-title')
      };
    },
    
    activate: function(){
      this.view.addClass('selected');
    },
    
    deactivate: function(){
      this.view.removeClass('selected');
    },
    
    getLanguageData: function(){
      return this.data;
    }
    
  });
  
  var LanguageTabManager = Manager.sub({
    
    el: '#page-languages',
    namespace: 'content',
    currentLanguage: null,
    
    elements: {
      languages: '.language'
    },
    
    init: function(){
      
      this.previous();
      
      this.data = {
        id: this.view.attr('data-id'),
        inLanguageName: this.view.attr('data-iln')
      };
      
      var theTabs = [];
      this.languages.each(function(){
        theTabs.push(new LanguageTabController({el: this}));
      });
      this.add(theTabs);
      if(this.state.controllers.length > 0){
        this.devault = 0;
        this.activate();
      }
      var man = this;
      this.state.subscribe('change', function(){
        if(!man.state.active() || man.currentLanguage == man.state.active()) return;
        man.currentLanguage = man.state.active();
        man.publish('languageChange', [man.state.active().getLanguageData(), man.data]);
      });
      
    },
    
    currentLanguageData: function(){
      if(!this.currentLanguage)
          this.currentLanguage = this.state.active();
      return this.currentLanguage.getLanguageData();
    }
    
  });
  LanguageTabManager.include(PubSub);
  
  var PageTabController = root.PageTabController = Controller.sub({
    
    namespace: 'tab-body',
    
    init: function(){
      this.previous();
      this.view.hide();
      this.tabView = $('<a class="tab" href="#">');
      this.tabView.html(this.title);
    },
    
    activate: function(){
      this.previous();
      this.tabView.addClass('selected');
    },
    
    deactivate: function(){
      this.previous();
      this.tabView.removeClass('selected');
    }
    
  });
  
  var PageConfigTabController = PageTabController.sub({
    
    el: '<div>',
    template: '#edit_page_config_tmpl',
    form: '#page-config',
    
    elements: {
      radio_access_levels: '.fieldset-rights input'
    },
    
    events: {
      
      'click on radio_access_levels': function(e){
        $('.fieldset-rights .fieldset-groups').toggle($(e.target).is('.members'));
      }
      
    },
    
    render: function(data){
      
      this.view
        .html($(this.template).tmpl(data))
        .find(this.form)
        .restForm();
      
    },
    
    save: function(){
      
      this.view
        .find(this.form)
        .trigger('submit');
      
    }
    
  });
  
  var PageTabManager = Manager.sub({
    
    el: "#page-tabs",
    namespace: 'content',
    container: '#page-tab-body',
    
    elements:{
      tabs: '.tab'
    },
    
    events: {
      'click on tabs': function(e){
        e.preventDefault();
        var i = $(e.target).attr('data-index');
        this.state.controllers[i].activate();
      }
    },
    
    init: function(){
      
      this.previous();
      
      this.configTab = new PageConfigTabController({title:'Config'});
      
    },
    
    finalizeTabs: function(data){
      if(!this.hasControllers()){
        var contentTab = new PageTabController({el:'<div>', title:'Content'});
        contentTab.view.append($(this.container).contents());
        $(this.container)
          .append(contentTab.view)
          .append(this.configTab.view);
        this.add([contentTab]);
      }
      this.add([this.configTab]);
      this.configTab.render(data);
      this.state.controllers[0].activate();
      this.renderTabs();
    },
    
    hasControllers: function(){
      return this.state.controllers.length > 0;
    },
    
    renderTabs: function(){
      
      //Get all tabs away from here.
      this.view.find('.tab').remove();
      
      //Create new tabs for each controller.
      var $tab;
      for(var i = 0; i < this.state.controllers.length; i++){
        $tab = this.state.controllers[i].tabView
          .toggleClass('first', i == 0)
          .removeClass('last')
          .attr('data-index', i)
          .appendTo(this.view);
      }
      $tab && $tab.addClass('last');
      
      this.refreshElements();
      
    }
    
  });
  
  //The page controller for editing page contents and settings.
  var PageController = Controller.sub({
    
    el: '#page_app',
    namespace: 'content',
    isEmpty: true,
    
    elements: {
      btn_detach: '.title-bar #detach-page',
      btn_save_page: '#save-buttons #save-page',
      select_pageLink: '#new-page-wrap #page-link',
      pageTypes: '#new-page-wrap .pagetypes-list li a'
    },
    
    events: {
      
      'click on btn_detach': function(e){
        e.preventDefault();
        this.detach();
      },
      
      'click on btn_save_page': function(e){
        e.preventDefault();
        this.save();
      },
      
      'click on pageTypes': function(e)
      {
        
        e.preventDefault();
        this.isEmpty = false;
        var self = this;
        
        var item_id = app.Item.data.item.id;
        
        request(GET,'cms/new_page/'+$(e.target).id()+(item_id ? '/'+item_id : ''))
          .done(function(data){
            
            if(item_id){
              app.Item.linkPage(data.page.id);
              app.MenuItems.updateItem(data.item);
              delete data.item;
            }
            
            self.processPageData(data);
            
          });
        
      },
      
      'change on select_pageLink': function(e){
        
        var pid = $(e.target).val();
        this.loadPageContents(pid);
        
        if(app.Item.data.item.id > 0)
        {
          
          request(GET, 'cms/link_page', {
            menu_id: app.Item.data.item.id,
            page_id: pid
          }).done(function(item){
            app.Item.linkPage(item.page_id);
            app.MenuItems.updateItem(item);
          });
          
        }
        
      }
      
    },
    
    init: function(){
      this.previous();
    },
    
    detach: function(){
      
      var self = this;
      
      request(GET, 'cms/detach_page', {
        page_id: self.data.page.id,
        menu_id: app.Item.data.item.id
      }).done(function(item){
        self.btn_detach.remove();
        app.Item.clear();
        app.MenuItems.updateItem(item);
      });
      
    },
    
    clear: function(){
      
      this.unsubscribe();
      this.view.html('');
      this.Tabs = null;
      this.Languages = null;
      this.refreshElements();
      this.isEmpty = true;
      
    },
    
    save: function(){
      
      if(!this.data.page.id) return;
      
      //Save page config first.
      this.Tabs.configTab.save();
      
      //Then page info.
      //TODO
      //this.Tabs.infoTab.save();
      
      //Let anyone else save in the way they wish.
      this.publish('save', this.data.page.id);
      
    },
    
    loadNewPage: function(){
      
      var self = this;
      
      this.isEmpty = false;
      this.unsubscribe();
      
      return $.ajax('?section=cms/new_page')
      
      //Add a done callback.
      .done(function(data){
        self.data = {};
        self.view.html(data);
        self.Tabs = null;
        self.Languages = null;
        self.refreshElements();
      });
      
    },
    
    loadPageContents: function(pid){
      
      //Reference to this.
      var self = this;
      
      if(!pid) return this.loadNewPage();
      
      this.isEmpty = false;
      this.unsubscribe();
      
      return $.ajax('?rest=cms/page_info/'+pid)
      
      //Add a done callback.
      .done(this.processPageData);
      
    },
    
    processPageData: function(data){
      var self = app.Page;
      self.data = data;
      self.data.menu_id = app.Item.data.item.id;
      self.view.html($('#edit_page_tmpl').tmpl(data));
      self.Tabs = new PageTabManager;
      self.Languages = new LanguageTabManager;
      self.view.find('#page-tab-body')
        .html(data.content)
        .append(self.Tabs.configTab.view);
      self.Tabs.finalizeTabs(data);
      self.view.find('#edit_page').addClass('has-tabs');
      self.refreshElements();
      self.Tabs.renderTabs();
    }
    
  });
  PageController.include(PubSub);

  var ItemController = Controller.sub({
    
    el: '#menu_app',
    namespace: 'content',
    formEl: '#form-menu-item',
    
    elements: {
      btn_save: '.footer #save-menu-item',
      btn_toggle_settings: '.title-bar #toggle-menu-item-settings',
      config: '#form-menu-item #menu-item-config'
    },
    
    events: {
      
      'click on btn_save': function(e){
        e.preventDefault();
        this.save();
      },
      
      'click on btn_toggle_settings': function(e){
        e.preventDefault();
        this.config.toggle();
      }
      
    },
    
    clear: function(){
      this.view.html('');
      this.refreshElements();
    },
    
    linkPage: function(page_id){
      this.view.find('#edit-menu-item').addClass('has-page');
    },
    
    loadItemContents: function(menu){
      
      //Reference to this.
      var self = this;
      
      //Preset data, for the greedy page that wants to know quickly.
      this.data = {
        item: {
          id: menu
        }
      };
      
      if(menu === false){
        return this.clear();
      }
      
      return $.ajax('?rest=cms/menu_item_info/'+(menu?menu:'0'))
      
      //Add a done callback.
      .done(function(data){
        self.data = data;
        self.view.html($('#edit_menu_tmpl').tmpl($.extend({current_menu: app.options.menu_id}, data)));
        self.refreshElements();
        self.view.find(self.formEl).restForm({success: function(item){
          self.view.find('.title-bar .title').text(item.title);
          app.MenuItems.updateItem(item);
          if(app.Page.isEmpty)
            app.Page.loadNewPage();
        }});
      });
      
    },
    
    save: function(){
      this.view.find(this.formEl).trigger('submit');
    }
    
  });
  
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
      
      this.Page = new PageController;
      this.Item = new ItemController;
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

/*
  NO MORE!!!!
  I CAN'T TAKE IT!!!
  AAAAAAAAH!
  
  //New menu item
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
*/

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
