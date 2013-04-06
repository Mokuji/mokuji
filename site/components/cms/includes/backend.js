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

;(function(root, $, _, undefined){
  
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
  
  //The overall feedback object.
  var FeedbackController = Controller.sub({
    
    el: '#application-notifications',
    namespace: 'notifications',
    speed: 150,
    notesDelay: 3000,
    
    isVisible: false,
    bufferMessages: false,
    lastSuccess: null,
    errors: [],
    
    init: function(){
      this.previous();
      this.view.hide();
    },
    
    working: function(message){
      if(!this.bufferMessages)
        this.transitionTo('working', message, false);
      return this;
    },
    
    success: function(message)
    {
      
      if(this.bufferMessages){
        this.lastSuccess = message;
      }
      
      else this.transitionTo('success', message, true);
      
      return this;
      
    },
    
    error: function(message){
      
      if(this.bufferMessages){
        this.errors.push(message);
      }
      
      else this.transitionTo('error', message, true);
      
      return this;
      
    },
    
    startBuffer: function(){
      this.bufferMessages = true;
      return this;
    },
    
    stopBuffer: function()
    {
      
      //Stop buffering.
      this.bufferMessages = false;
      
      //If there were errors, display that.
      if(this.errors.length > 0){
        this.error(this.errors.join('<br>\n'));
      }
      
      //Otherwise bring the latest happy news!
      else{
        this.success(this.lastSuccess);
      }
      
      //Clear the buffer.
      this.lastSuccess = null;
      this.errors = [];
      
      return this;
      
    },
    
    transitionTo: function(className, message, fadeOut){
      
      //First fade the old message out.
      if(this.isVisible)
      {
        
        this.view.stop(true, true).fadeOut(this.speed, function(){
          $(this)
            .text(message)
            .attr('class', className);
        });
        
      }
      
      //The message is already gone.
      else{
        
        this.view
          .text(message)
          .attr('class', className);
        
      }
      
      //Fade in.
      this.isVisible = true;
      this.view.fadeIn(this.speed);
      
      //If it should, queue a fade out.
      if(fadeOut){
        var that = this;
        this.view
          .animate({opacity:1}, this.notesDelay)
          .fadeOut(this.speed, function(){
            that.isVisible = false;
          });
      }
      
      return this;
      
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
      'el_message': '#user-message',
      'btn_selectSite': '#btn-select-site'
    },
    
    //Bind events to the sub-elements.
    events: {
      
      'change on btn_selectSite': function(e){
        $.rest('PUT', '?rest=cms/active_site/'+$(e.target).val()).done(function(res){
          if(res.success == true){
            app.options.site_id = res.site_id;
            app.MenuItems.reload();
          }
        });
      },
      
      'click on btn_newMenuItem': function(e){
        e.preventDefault();
        app.App.activate();
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
      'btn_collapse': '.icon-collapse',
      'btn_expand': '.icon-expand',
      'item': 'a.menu-item'
    },
    
    events: {
      
      'sortupdate': function(){
        this.updateData();
        this.checkHasSub();
        app.MenuToolbar.makeSavable();
      },
      
      'click on btn_delete': function(e){
        e.preventDefault();
        this.deleteItem($(e.target).closest('li').id())
      },
      
      'click on item': function(e){
        e.preventDefault();
        app.App.activate();
        app.Item.loadItemContents($(e.target).attr('data-menu-item'));
        app.Page.loadPageContents($(e.target).attr('data-page'));
      },
      
      'click on btn_collapse': function(e){
        this.collapse($(e.target).closest('li'));
      },
      
      'click on btn_expand': function(e){
        this.expand($(e.target).closest('li'));
      }
      
    },
    
    //Method: Initiate.
    init: function(){
      
      //Call the parent initiator.
      this.previous();
      
      //Configure the nestedSortable plug-in.
      this.configureSortable();
      this.updateData();
      
      //Set the height of the container.
      this.autoHeight();
      
      //Bind the recalculating of height to the window resize.
      $(window).on('resize', _(this.proxy(this.autoHeight)).debounce(120));
      
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
        data.depth = element.attr('data-depth');
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
      
      return this;
      
    },
    
    //Method: Save the data to the server.
    save: function(){
      
      return request(PUT, 'menu/menu_items', this.data);
      
    },
    
    //Method: Delete the menu item from the list and the server.
    deleteItem: function(id){
      
      var $item = this.el_items.filter('[data-id='+id+']');
      
      $item.slideUp();
      
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
      
    },
    
    //Collapse a menu item and its sub-items.
    collapse: function(item){
      
      $(item).find('.icon-toggle:eq(0)').removeClass('icon-collapse').addClass('icon-expand');
      $(item).addClass('collapsed');
      
      return this;
      
    },
    
    //Un-collapse.
    expand: function(item){
      
      $(item).find('.icon-toggle:eq(0)').removeClass('icon-expand').addClass('icon-collapse');
      $(item).removeClass('collapsed');
      
      return this;
      
    },
    
    //Add the has-sub class to items that have sub-menu items.
    checkHasSub: function(){
      
      var self = this;
      
      $.after(0).done(function(){
        self.el_items.filter(':has(ul)').addClass('has-sub');
        self.el_items.not(':has(>ul:has(li))').find('>ul').remove();
        self.el_items.filter(':not(:has(>ul))').removeClass('has-sub');
      });
      
      return self;
      
    },
    
    autoHeight: function(){
      this.view.height(
        + this.view.closest('.content').height()
        - this.view.siblings('.menu-items-toolbar').height()
        - 15 //Margin
      );
    }
    
  });
  
  //Controller for the config bar in the menu.
  var ConfigBarController = Controller.sub({
    
    el: '#page-main-left #configbar',
    namespace: 'menu',
    itemTemplate: '#configbar_item_tmpl',
    
    elements: {
      buttons: 'li a'
    },
    
    events: {
      
      'click on buttons': function(e){
        e.preventDefault();
        this.loadConfigItem($(e.target).attr('data-view'));
      }
      
    },
    
    loadConfigItem: function(view){
      app.Settings.loadView(view);
      app.Settings.activate();
    },
    
    init: function(){
      
      this.previous();
      var that = this;
      
      request(GET, 'cms/configbar_items').done(function(items){
        
        for(var i in items){
          that.view.append($(that.itemTemplate).tmpl(items[i]));
        }
        
        that.refreshElements();
        
      });
      
    }
    
  });
  
  //The state-machine for the main content.
  var MainManager = Manager.sub({
    
    el: '#page-main-right',
    namespace: 'main'
    
  });
  
  //The controller for the page-application.
  var PageAppController = Controller.sub({
    
    el: '#app',
    namespace: 'main'
    
  });
  
  var LanguageTabController = Controller.sub({
    
    namespace: 'content',
    
    events:{
      'click': function(e){
        e.preventDefault();
        //Clicking should do nothing when not multilingual.
        if(this.tabManager.isMultilingual())
          this.activate();
      }
    },
    
    init: function(data, tabManager){
      this.previous(data);
      this.tabManager = tabManager;
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
    multilingual: false,
    
    elements: {
      languages: '.language'
    },
    
    init: function(){
      
      this.previous();
      
      this.data = {
        id: this.view.attr('data-id'),
        inLanguageName: this.view.attr('data-iln'),
        languages: {} //Container to set later.
      };
      
      var theTabs = []
        , self = this;
      
      this.languages.each(function(){
        var ltc = new LanguageTabController({el: this}, self);
        theTabs.push(ltc);
        var data = ltc.getLanguageData();
        self.data.languages[data.id] = data;
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
    
    isMultilingual: function(){
      return this.multilingual;
    },
    
    setMultilingual: function(value){
      this.multilingual = !!value;
      this.view.toggleClass('multilingual-content', !!value);
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
      this.tabView = $('<a href="#">');
      this.tabView.addClass("tab icon-warning-sign "+this.title.toLowerCase());
      this.tabView.html("<span>"+this.title+"</span>");
    },
    
    activate: function(){
      this.previous();
      this.tabView.addClass('selected');
      app.Page.setMultilingual(this.isMultilingual());
    },
    
    deactivate: function(){
      this.previous();
      this.tabView.removeClass('selected');
    },
    
    isMultilingual: function(){
      return this.view.find('.multilingual-section[data-language-id]').size() > 0;
    },
    
    setMultilanguageSection: function(language){
      
      this.view.find('.multilingual-section[data-language-id]').each(function(){
        $this = $(this);
        $this.toggle($this.attr('data-language-id') == language);
      });
      
    }
    
  });
  
  var PageFindabilityTabController = PageTabController.sub({
    
    el: '<div>',
    template: '#edit_page_findability_tmpl',
    form: '#page-findability',
    
    elements: {
      urlKeys: '.page-key',
      pageTitle: '.page-title',
      pageDescription: '.page-description',
      pageKeywords: '.page-keywords'
    },
    
    events: {
      
      'keyup on urlKeys': function(e){
        
        var $target = $(e.target)
          , val = $target.val();
          
        if(val.length == 0)
          val = $target.attr('placeholder');
        
        $target.closest('.ctrlHolder').find('.key-section').text(val);
        
      },
      
      'keyup on pageTitle': function(e){
        this.updateDefault(e.target, 'title');
      },
      
      'keyup on pageDescription': function(e){
        this.updateDefault(e.target, 'description');
      },
      
      'keyup on pageKeywords': function(e){
        this.updateDefault(e.target, 'keywords');
      }
      
    },
    
    render: function(data){
      
      this.view
        .html($(this.template).tmpl(data))
        .find(this.form)
        .restForm();
      
      this.refreshElements();
      this.pageTitle.trigger('keyup');
      this.pageDescription.trigger('keyup');
      this.pageKeywords.trigger('keyup');
      
    },
    
    save: function(){
      
      this.view
        .find(this.form)
        .trigger('submit');
      
    },
    
    recommendTitle: function(title, languageId){
      if(languageId === 'ALL'){
        this.view.find('.page-title-recommendation').val(title);
        this.view.find('.page-title')
          .attr('placeholder', title)
          .trigger('keyup');
      }else{
        $langSection = this.view.find('.multilingual-section[data-language-id='+languageId+']');
        $langSection.find('.page-title-recommendation').val(title);
        $langSection.find('.page-title')
          .attr('placeholder', title)
          .trigger('keyup');
      }
    },
    
    updateDefault: function(which, what){
      var $which = $(which)
        , $targets = $which.closest('.multilingual-section').find('.defaults-to-'+what);
      $targets.attr('placeholder', $which.val() ? $which.val() : $which.attr('placeholder'));
    }
    
  });
  
  var PageConfigTabController = PageTabController.sub({
    
    el: '<div>',
    template: '#edit_page_config_tmpl',
    form: '#page-config',
    
    elements: {
      radio_access_levels: '.fieldset-rights input[name=access_level]'
    },
    
    events: {
      
      'click on radio_access_levels': function(e){
        $('.fieldset-rights .fieldset-groups').toggle($(e.target).is('.members'));
      },
      
      'saveComplete': function(){
        $('#checkbox-set-as-homepage').filter(':checked[value=1]').prop('disabled', true).val(0);
      }
      
    },
    
    render: function(data){
      
      var v = this.view;
      
      v
      .html($(this.template).tmpl(data))
      .find(this.form)
      .restForm({
        success: function(){v.trigger('saveComplete')}
      });
      
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
        this.publish('tabChanged', this.state.controllers[i]);
      }
    },
    
    init: function(){
      
      this.previous();
      
      this.findabilityTab = new PageFindabilityTabController({title:'Findability'});
      this.configTab = new PageConfigTabController({title:'Config'});
      
    },
    
    finalizeTabs: function(data)
    {
      
      //Set the language information.
      data.languages = app.Page.Languages.data.languages;
      
      //When we have no tabs from the content.
      if(!this.hasControllers()){
        
        //Create one big tab called content. (Basically legacy support).
        var contentTab = new PageTabController({el:'<div>', title:'Content'});
        contentTab.view.append($(this.container).contents());
        $(this.container)
          .append(contentTab.view);
        this.add([contentTab]);
        
      }
      
      //Add the findability and config tabs to every page.
      $(this.container)
        .append(this.findabilityTab.view)
        .append(this.configTab.view);
      this.add([this.findabilityTab, this.configTab]);
      this.findabilityTab.render(data);
      this.configTab.render(data);
      this.renderTabs();
      
      //Bind language switching on multilingual sections.
      var self = this;
      var setLanguage = function(e, language){
        self.findabilityTab.setMultilanguageSection(language.id);
      };
      app.Page.Languages.subscribe('languageChange', setLanguage);
      
      //Set it to the current language.
      setLanguage(null, app.Page.Languages.currentLanguageData());
      
      //Activate the first tab.
      this.state.controllers[0].activate();
      
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
      
    },
    
    getActiveTab: function(){
      return this.state.active();
    }
    
  });
  PageTabManager.include(PubSub);
  
  //The page controller for editing page contents and settings.
  var PageController = Controller.sub({
    
    el: '#page_app',
    namespace: 'content',
    isEmpty: true,
    
    elements: {
      btn_detach: '#detach-page',
      btn_save_page: '#save-page',
      select_pageLink: '#page-link',
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
    
    setMultilingual: function(value){
      
      if(this.Languages){
        this.Languages.setMultilingual(value);
      }
      
    },
    
    detach: function(){
      
      var self = this;
      
      request(GET, 'cms/detach_page', {
        page_id: self.data.page.id,
        menu_id: app.Item.data.item.id
      })
      
      .done(function(item){
        self.clear();
        self.loadNewPage();
        app.Item.loadItemContents(app.Item.data.item.id);
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

      //Show loading message.
      var that = this, btn_text = $(this.btn_save_page).text();
      $(this.btn_save_page).attr('disabled', 'disabled').text(btn_text+'...');
      
      //Start buffering feedback.
      var $eventListener = $('<div>');
      app.Feedback.working($(that.btn_save_page).attr('data-working'));
      app.Feedback.startBuffer();
      
      //Save page config first.
      this.Tabs.configTab.save();
      
      //Then the findability.
      this.Tabs.findabilityTab.save();
      
      //Then the menu item.
      app.Item.save();
      
      //Let anyone else save in the way they wish.
      this.publish('save', this.data.page.id);
      
      //Give update message.
      $eventListener.ajaxStop(function(){
        $(that.btn_save_page).removeAttr('disabled', 'disabled').text(btn_text);
        app.Feedback.success($(that.btn_save_page).attr('data-success'));
        app.Feedback.stopBuffer();
        $eventListener.unbind('ajaxStop');
      });

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
    
    processPageData: function(data)
    {
      
      var self = app.Page;
      
      //Do basic saving of information.
      self.data = data;
      self.data.menu_id = app.Item.data.item.id;
      
      //Set the view.
      self.view.html($('#edit_page_tmpl').tmpl(data));
      
      //Init page tabs and language tabs.
      self.Tabs = new PageTabManager;
      self.Languages = new LanguageTabManager;
      
      //See if we're going multi-language mode.
      self.view.find('#edit_page').toggleClass('has-languages', self.Languages.languages.size() > 1);
      
      //If we're using the page type setup.
      if(data.pagetype)
      {
        
        //Load the pagetype.
        PageType.getPageType(app.options.url_base, data.pagetype)
        .done(function(definition){
          
          //Initialize the controller.
          try{
            var controller = new definition.controller(definition, self);
          }catch(e){ log(e); }
          
          //Finalize.
          self.finalizePageProcessing.call(self, data);
          
        });
        
      }
      
      //When not using the pagetype setup.
      else
      {
        
        //Add raw content to template, if available.
        self.view.find('#page-tab-body')
          .html(data.content);
        
        //Finalize.
        self.finalizePageProcessing.call(self, data);
        
      }
      
    },
    
    finalizePageProcessing: function(data){
      
      //Let the tabs do final stuff with said content if needed.
      this.Tabs.finalizeTabs(data);
      
      //Specify that tabs are present.
      this.view.find('#edit_page').addClass('has-tabs');
      
      //Update references.
      this.refreshElements();
      
      //Show the tabs.
      this.Tabs.renderTabs();
      
    }
    
  });
  PageController.include(PubSub);

  var ItemController = Controller.sub({
    
    el: '#menu_app',
    namespace: 'content',
    formEl: '#form-menu-item',
    
    elements: {
      menu_item_image: '#form-menu-item #menu_item_image',
      menu_item_image_id: '#form-menu-item #l_menu_item_image_id',
      delete_image: '#form-menu-item .delete-menu-item-image',
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
    
    init: function(){
      this.previous();
      var self = this;
      
      //Allow image deletion.
      this.view.on('click', '.delete-menu-item-image', function(e){
        e.preventDefault();
        self.refreshElements();
        $.rest('DELETE', '?rest=menu/menu_item_image/'+self.data.item.id)
          .done(function(){
            self.data.item.image_id = '';
            self.menu_item_image_id.val('');
            self.menu_item_image.attr('src', '').hide();
            self.delete_image.hide();
            self.save();
          });
        
      });
    },
    
    clear: function(){
      
      this.view.html('');
      this.refreshElements();
      
    },
    
    linkPage: function(page_id){
      
      this.view.find('#edit-menu-item').addClass('has-page');
      this.data.page_id = page_id;
      
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
      
      //If no menu ID was given, clear and stop.
      if(menu === false){
        return this.clear();
      }
      
      //Request menu item info from the server.
      return $.ajax('?rest=cms/menu_item_info/'+(menu?menu:'0'))
      
      //Add a done callback.
      .done(function(data){
        
        self.data = data;
        self.view.html($('#edit_menu_tmpl').tmpl($.extend({current_menu: app.options.menu_id}, data)));
        self.refreshElements();
        self.view.find(self.formEl).restForm({success: self.proxy(self.afterSave)});
        
        //Reload plupload, if present.
        if($.fn.txMediaImageUploader)
        {
          
          self.view.find('.image_upload_holder').txMediaImageUploader({
            singleFile: true,
            callbacks: {
              
              serverFileIdReport: function(up, ids, file_id){
                self.data.item.image_id = file_id;
                self.menu_item_image_id.val(file_id);
                self.menu_item_image
                  .attr('src', '?section=media/image&resize=0/150&id='+file_id)
                  .show();
                self.delete_image.show();
                self.save();
                
              }
              
            }
          });
          
        }
        
        //If not there, hide the div that holds the uploader normally.
        else{
          self.view.find('.image_upload_holder').hide();
        }
        
      });
      
    },
    
    save: function(){
      
      this.view.find(this.formEl).trigger('submit');
      
    },
    
    afterSave: function(data){
      
      //Set the new data.
      this.data.item = {
        id      : data.id,
        menu_id : data.menu_id,
        site_id : data.site_id,
        title   : data.title
      };
      
      //Find the form element.
      this.view.find(this.formEl)
      
      //Set its method to PUT.
      .attr('method', 'PUT');
      
      //Update the ID.
      this.view.find('input[name=id]').val(this.data.item.id);
      
      //Set the title in the title bar.
      this.view.find('.title-bar .title').text(data.title);
      
      //Update the item in the left menu.
      app.MenuItems.updateItem(data);
      
      //Load the "new page" interface if no page is linked.
      if(app.Page.isEmpty){
        app.Page.loadNewPage();
      }
      
    }
    
  });
  
  //The controller for the settings interface.
  var SettingsController = Controller.sub({
    
    el: '#config_app',
    namespace: 'main',
    
    loadView: function(viewName){
      
      var view = this.view.find('.inner');
      view.empty();
      request(GET, 'cms/config_app', {view: viewName})
        .done(function(data){
          view.html(data.contents);
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
      
      this.MenuItems = new MenuItemsController;
      this.MenuToolbar = new MenuToolbarController;
      this.Configbar = new ConfigBarController;
      this.Main = new MainManager;
      
      this.App = new PageAppController;
      this.Settings = new SettingsController;
      this.Main.add([this.App, this.Settings]);
      this.App.activate();
      
      this.Page = new PageController;
      this.Item = new ItemController;
      // this.App.add([this.Page, this.Item]);
      
      this.Feedback = new FeedbackController;
      
      //Grab the Home button.
      $('#topbar_menu .website').on('click', function(e){
        e.preventDefault();
        window.location = app.options.url_base +
          (app.Page.data.page ? '?pid=' + app.Page.data.page.id + '&' : '?') +
          (app.Item.data.item ? 'menu=' + app.Item.data.item.id : '');
      });
      
    }
    
  });
  

})(this, jQuery, _);

$(function(){
  
  

  //draggable sidebar
  var i = 0;
  $('#widget-slider').mousedown(function(e){
    e.preventDefault();
    $(document).mousemove(function(e){
      
      if(e.pageX > 225 && e.pageX < 985){
        $("body").removeClass("cursor_disabled").addClass("cursor_resizing");
        $('#page-main-left').css("width", e.pageX+15);
        $('#page-main-right').css("padding-left",e.pageX+15);
        return;
      }
      
      else if(e.pageX <= 225){
        $('#page-main-left').css("width", 240);
        $('#page-main-right').css("padding-left", 240);
      }
      
      else{
        $('#page-main-left').css("width", 1000);
        $('#page-main-right').css("padding-left", 1000);
      }
      
      $("body").removeClass("cursor_resizing").addClass("cursor_disabled");
      
    });
  });
  $(document).mouseup(function(e){
    $("body").removeClass("cursor_resizing").removeClass("cursor_disabled");
    $(document).unbind('mousemove');
  });

});
