(function($, global){
  
  ////////////
  // JSLite //
  ////////////
  var Class = JSLite.Class
    , ClassFactory = JSLite.ClassFactory;
  
  
  
  //////////
  // GUID //
  //////////
  function guid(){
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
  }
  
  
  
  //////////////////////
  // Form data parser //
  //////////////////////
  function parseFormData(data){
    
    var decoded = decodeURIComponent((data+'').replace(/\+/g, '%20'))
      , pairs = decoded.split('&')
      , parsed = {};
    
    _.each(pairs, function(pair){
      pair = pair.split('=');
      parsed[pair[0]] = pair[1];
    });
    
    return parsed;
    
  }
  
  ///////////////////
  // Object access //
  ///////////////////
  function access(object, prop, create){
    
    var create = create||false
      , props = prop.split('.');
      
    do{
      prop = props.shift();
      if(!object.hasOwnProperty(prop) && create){
        object[prop] = (props.length ? {} : create);
      }
      object = object[prop];
    }
    
    while(props.length && object);
    
    return object;
    
  }
  
  
  
  ///////////
  // Model //
  ///////////
  
  /**
   * The EditableModel class.
   */
  var EditableModel = (new Class)
  
  /**
   * Construct an EditableModel.
   *
   * @param {string} name The name of the model. Used to find the server resource.
   * @param {mixed} id The local identifier of the model. Generates one if omitted.
   * @param {boolean} fresh Whether this model is not yet present on the server.
   */
  .construct(function(name, id, fresh){
    this.name = name;
    this.fresh = fresh||false;
    this.id = id || guid();
    this.data = {};
    this.serverData = {};
  })
  
  //Define EditableModel members.
  .members({
    
    name: null,
    id: null,
    fresh: true,
    data: null,
    
    /**
     * Get data.
     *
     * @param {string} key The key to look for.
     *
     * @return {mixed} The matched data.
     */
    get: function(key){
      return this.data[key];
    },
    
    /**
     * Set data.
     *
     * @param {string} key The key to store the value under.
     * @param {mixed} value The value to store.
     *
     * @chainable
     */
    set: function(key, value){
      this.data[key] = value;
      return this;
    },
    
    /**
     * Set multiple nodes.
     *
     * @param {object} map A map of keys and values to set.
     *
     * @chainable
     */
    setAll: function(map){
      $.extend(this.data, map);
      return this;
    },
    
    /**
     * Set "initial" data. Assumes given data is equal to that on the server.
     *
     * @param {Object} map Data to set.
     * 
     * @chainable
     */
    setInitial: function(map){
      $.extend(this.data, map);
      $.extend(this.serverData, map);
      return this;
    },
    
    /**
     * Revert local data back to server data.
     *
     * @chainable
     */
    revert: function(){
      $.extend(this.data, this.serverData);
      return this;
    },
    
    isClean: function(){
      return _.isEqual(this.data, this.serverData);
    },
    
    /**
     * Stores the resource on the server.
     *
     * @return {jQuery.Deferred.Promise} The promise object handling the AJAX callbacks.
     */
    save: function(){
      return request((this.fresh ? POST : PUT), this.name, this.getData()).done(this.proxy(function(data){
        this.data = data;
        this.serverData = $.extend({}, data);
        this.fresh = false;
      }));
    },
    
    /**
     * Return the models data.
     *
     * @return {object}
     */
    getData: function(){
      return this.data;
    }
    
  })
  
  //Finalize the EditableModel class.
  .finalize();
  
  
  
  ////////////////
  // Controller //
  ////////////////
  
  /**
   * The EditableController class.
   */
  var EditableController = (new Class)
  
  /**
   * Construct an EditableController.
   *
   * @param {EditableModel} model The model this controller will work with.
   * @param {HTMLElement} element The HTML element to work with.
   */
  .construct(function(editable, model, element){
    
    //Set properties.
    this.model = model;
    this.editable = editable;
    this.element = this.active = new Element(element);
    
    //Set initial data in the model.
    this.model.setInitial(parseFormData($(element).data('data')));
    this.model.setInitial(this.element.extract());
    
    //Make sure the editable class gets assigned.
    $(element).addClass('editable');
    
    //Create a type of Template instance based on whether the "template" data is available.
    var template = ($(element).is('[data-template]')
      ? new EJSTemplate($(element).data('template'))
      : new AutoTemplate(this.element)
    );
    
    //Store the template.
    this.template = template;
    
    //Create tool bars.
    this.toolbars = {
      
      preview: (new Toolbar(this))
        .addButton('Revert', function(){
          this.canDiscard() && this.revertToServer().setMode(null);
        })
        .addButton('Save', function(){
          this.saveToServer().setMode(null);
        })
      ,
      
      editing: (new Toolbar(this))
        .addButton('Revert', function(){
          this.canDiscard() && this.restore().setMode(null);
        })
        .addButton('Preview', function(){
          this.saveToModel().restore().setMode(this.model.isClean() ? null : 'preview');
        })
        .addButton('Save', function(){
          this.saveToModel().restore().saveToServer().setMode(null);
        })
      
    };
    
    //Bind events.
    $('body').on('click', '#' + this.element.id(), this.proxy(function(){
      this.isEditing() || this.replace().setMode('editing');
    }));
    
    $('body').on('keyup', this.proxy(function(e){
      
      //We might want to leave editable mode.
      if(this.isEditing() && this.template.hasFocus() && this.template.isIdle()){
        
        //Why? Because CKEditor sets its own time-out after every key press...
        setTimeout(this.proxy(function(){
          
          //If the escape key is pressed, discard changes if we can.
          //#TEMP: Disabled because of conflicts with CKEDITOR.
          if(false && e.which == 27){
            this.canDiscard() && this.restore().setMode(null);
          }
          
          //If CTRL+ENTER is pressed.
          else if(e.which == 13 && e.ctrlKey){
            
            //Save changes locally and restore.
            this.saveToModel().restore();
            
            //If the SHIFT key was pressed too, save to the server.
            if(e.shiftKey){
              this.saveToServer().setMode(null);
            }
            
            //Otherwise just set the mode.
            else{
              this.setMode(this.model.isClean() ? null : 'preview');
            }
            
          }
            
        }), 50);
        
      }
      
    }));
    
  })
  
  //Define members for the EditableController class.
  .members({
    
    model: null,
    element: null,
    template: null,
    active: null,
    save_btn: null,
    _mode: null,
    
    saveToModel: function(){
      this.model.setAll(this.active.extract());
      return this;
    },
    
    saveToServer: function(){
      this.model.isClean() || this.model.save().fail(this.proxy(function(){
        alert('Failed to save.');
      }));
      return this;
    },
    
    revertToServer: function(){
      this.model.revert();
      this.active.inject(this.model.getData());
      return this;
    },
    
    replace: function(){
      this.hideToolbar();
      this.active = this.template.replace(this.element, this.model.getData()).focus();
      return this;
    },
    
    restore: function(){
      this.hideToolbar();
      this.active = this.element.replace(this.template, this.model.getData());
      return this;
    },
    
    setMode: function(mode){
      var $el = $(this.active.getElement());
      
      if(_.isString(mode)){
        this._mode && $el.removeClass(this._mode.toLowerCase());
        $el.addClass(mode.toLowerCase());
        this._mode = mode.toUpperCase();
        this.showToolbar(mode);
      }
      
      else{
        $el.removeClass(this._mode.toLowerCase());
        this._mode = null;
        this.hideToolbar();
      }
      
      return this;
      
    },
    
    isEditing: function(){
      return this._mode == 'EDITING';
    },
    
    canDiscard: function(){
      return (this.model.isClean() && this.active.isClean())
        || confirm("Are you sure you want to discard the changes?");
    },
    
    showToolbar: function(name){
      this.toolbars[name].showAt(this.active.getElement());
      return this;
    },
    
    hideToolbar: function(){
      _(this.toolbars).invoke('hide');
      return this;
    }
    
  })
  
  //Finalize the EditableController class.
  .finalize();
  
  
  
  //////////////
  // Tool Bar //
  //////////////
  
  var Toolbar = (new Class)
  
  .statics({
    
    blueprints: {
      
      //Define a tool-bar blueprint which the different tool-bar instances will make clones of.
      wrapper: $('<div>', {
        "class": "editable-toolbar",
        "html": $('<div>', {
          "class": "inner"
        })
      }),
      
      //Define a button blueprint
      button: $('<span>', {
        "class": "editable-toolbar-button",
        "text": "Button"
      })
      
    }
    
  })
  
  /**
   * Constructs a new tool bar.
   *
   * @param {EditableController} controller The instance for which the tool bar will function.
   */
  .construct(function(controller){
    this.toolbar = this.getStatic('blueprints').wrapper.clone().get(0);
    this.controller = controller;
    this.buttons = {};
  })
  
  .members({
    
    /**
     * @chainable
     */
    hide: function(){
      $(this.toolbar).detach();
      return this;
    },
    
    showAt: function(element){
      $(this.toolbar).appendTo(element);
      return this;
    },
    
    /**
     * Return the tool-bar HTML element.
     *
     * @return {HTMLElement} The internally created HTMLElement of the tool-bar.
     */
    getElement: function(){
      return this.toolbar;
    },
    
    /**
     * Add a button to the toolbar.
     *
     * @param {string} name The text that will appear on the button and generate the class name.
     * @param {function} action The callback which will be used for the buttons click event.
     * 
     * @return {HTMLElement} The button.
     */
    addButton: function(name, action){
      
      var btn = this.buttons[name] = 
        this.getStatic('blueprints').button.clone()
        .addClass(name.replace(/[\W_]/g, "-").toLowerCase())
        .text(name)
        .on('click', this.proxy(function(e){
          e.preventDefault();
          e.stopPropagation();
          action.apply(this.controller, arguments);
        }))
        .appendTo($(this.toolbar).find('.inner'))
        .get(0);
      
      return this;
      
    },
    
    /**
     * Return a previously added buttons HTML element.
     *
     * @param {string} name The earlier given name of the button.
     *
     * @return {HTMLElement} The internally created HTML element of the button.
     */
    getButton: function(name){
      return this.buttons[name];
    }
    
  })
  
  .finalize();
  
  
  
  /////////////
  // Element //
  /////////////
  
  var Element = (new Class)
  
  .statics({
    
    extract: {
      
      line: function(el){
        return $(el).text();
      },
      
      text: function(el){
        return $(el).html();
      }
      
    },
    
    inject: {
      
      line: function(el, data){
        $(el).text(data);
      },
      
      text: function(el, data){
        $(el).html(data);
      }
      
    }
    
  })
  
  .construct(function(element){
    this.element = element;
  })
  
  .members(PubSub)
  
  .members({
    
    element: null,
    
    /**
     * Returns the element, with optional new data.
     *
     * @param {Object} data Optional new data to inject.
     *
     * @return {HTMLElement}
     */
    getElement: function(data){
      if(data) this.inject(data);
      return this.element;
    },
    
    /**
     * If needed generate and return the element ID.
     *
     * @return {string} The ID of this element.
     */
    id: function(){
      
      //Initiate variables.
      var id;
      
      //Return the ID of the element.
      if(id = $(this.getElement()).attr('id')){
        return id;
      }
      
      //Create our own unique ID first.
      id = guid();
      
      //Set the ID.
      $(this.getElement()).attr('id', id);
      
      //Return the ID.
      return id;
      
    },
    
    /**
     * Replace an object in the DOM with this template rendered using the given data.
     *
     * @param {Element} replace The Element to replace.
     * @param {object} data The data to inject into the new element.
     *
     * @chainable
     */
    replace: function(replace, data){
      var el = this.getElement(data);
      replace.publish('beforeRemove');
      $(replace.getElement()).replaceWith(el);
      replace.publish('afterRemove');
      this.publish('placed', el);
      return this;
    },
    
    /**
     * Extract data from the DOM using the static extractors on the defined fields.
     *
     * @return {object} The extracted data.
     */
    extract: function(){
      
      var data = {}
        , self = this;
      
      $('[data-field]', this.getElement()).each(function(){
        access(data, $(this).data('field'), self.getStatic('extract')[$(this).data('type') || 'text'](this));
      });
      
      return data;
      
    },
    
    /**
     * Injects data into the DOM using the static injectors on the defined fields.
     *
     * @chainable
     */
    inject: function(data){
      
      var self = this;
      
      $('[data-field]', this.getElement()).each(function(){
        self.getStatic('inject')[$(this).data('type') || 'text'](this, access(data, $(this).data('field')));
      });
      
      return this;

    },
    
    /**
     * Detach the element from the DOM.
     *
     * @chainable
     */
    detach: function(){
      this.publish('beforeRemove');
      $(this.getElement()).detach();
      this.publish('afterRemove');
      return this;
    },
    
    isClean: function(){
      return true;
    }
    
  })
  
  .finalize();
  
  
  
  //////////////
  // Template //
  //////////////
  
  /**
   * Generic template class. Mostly used as a parent.
   * @type {Class}
   */
  var Template = (new Class).extend(Element)
  
  .members({
    
    element: null,
    
    /**
     * Returns the already existing element, or one with new data if data is given.
     *
     * @param {Object} data
     *
     * @return {HTMLElement}
     */
    getElement: function(data){
      return (!data && this.element) || (this.setElement(this.generateTemplate(data)));
    },
    
    /**
     * Dummy method which should be implemented by extending template classes.
     *
     * @param {object} data Data to inject during template generation.
     *
     * @return {HTMLElement}
     */
    generateTemplate: function(data){
      return $('<div>', {text: 'Template generator not implemented.'}).get(0);
    },
    
    /**
     * Set the element and return it.
     *
     * @param {HTMLElement} element
     *
     * @return {HTMLElement}
     */
    setElement: function(element){
      element = $(element).get(0);
      $(this.element).replaceWith(element);
      this.element = element;
      return element;
    },
    
    /**
     * Focus on the first focusable element in the template.
     *
     * @chainable
     */
    focus: function(){
      var $el = $(':focusable:eq(0), [contenteditable]', this.getElement()).eq(0).focus();
      setTimeout(function(){
        $el.val($el.val());
      }, 500);
      return this;
    },
    
    /**
     * Returns true if an element within the template has focus.
     *
     * @return {Boolean}
     */
    hasFocus: function(){
      return ($(':focus', this.getElement()).size() > 0);
    },
    
    /**
     * Returns true if the template is currently "idle".
     * 
     * Idle means that currently no actions are being processed, like open pop-ups or
     * invalidated date-fields etcetera. Implementations may vary with different templates
     * but using this method templates can tell third-party classes not to take control.
     *
     * @return {Boolean}
     */
    isIdle: function(){
      return true;
    }
    
  })
  
  .finalize();
  
  
  /**
   * Template class
   *
   * This class wraps information required to acquire a template and allows others to
   * retrieve the DOMElement. It also keeps the extractor for the template.
   * 
   * @type {Class}
   */
  var EJSTemplate = (new Class).extend(Template)
  
  /**
   * Construct a EJSTemplate.
   *
   * @param {HTMLElement|string} element Where to find the element. Can be either of the following:
   *                                     - HTMLElement: The already abstracted template.
   *                                     - "#<ID>": An ID pointing to the template in the DOM.
   *                                     - "<component>/<template>": The template resource on the server.
   *                                     
   * @param {function} extractor The function that can extract the data from the template.
   *
   * @return {EJSTemplate}
   */
  .construct(function(element, extractor){
    
    this.extractor = extractor;
    this.input = element;
    this.settings = {};
    
    if(element instanceof HTMLElement){
      this.settings.element = $('<div>').append(element).get(0);
    }
    
    else if(element.slice(0,1) == '#'){
      this.settings.element = element.slice(1);
    }
    
    else{
      this.settings.url = ("?rest="+element);
    }
    
  })
  
  .members({
    
    input: null,
    extractor: null,
    settings: {},
    ejs: null,
    
    /**
     * Creates, caches and returns the EJS object associated with this template.
     *
     * @return {EJS}
     */
    getEJS: function(){
      return this.ejs || (this.ejs = new EJS(this.settings));
    },
    
    /**
     * Implementation of template generator.
     *
     * Uses EJS to generate the template using the options set in the constructor.
     *
     * @param {object} data
     *
     * @return {HTMLElement}
     */
    generateTemplate: function(data){
      return this.getEJS().render(data||{});
    },
    
    /**
     * Set the extractor that extracts the data back from the template.
     *
     * @param {function} extractor
     *
     * @chainable
     */
    setExtractor: function(extractor){
      this.extractor = extractor;
      return this;
    },
    
    /**
     * Use the installed extractor to extract data from the DOM element.
     *
     * @return {object} The extracted data.
     */
    extract: function(){
      return (typeof this.extractor !== "function" ? {} : (this.extractor(this.getElement()) || {}));
    },
    
    /**
     * {@inheritdoc}
     */
    inject: function(data){
      this.getEJS().update(this.getElement(), data);
      return this;
    }
    
  })
  
  .finalize();
  
  
  /**
   * The AutoTemplate class.
   * 
   * Uses in-line meta data available from the HTML tags of the original element to
   * create a template with its data on the fly.
   */
  var AutoTemplate = (new Class).extend(Template)
  
  .statics({
    
    generators: {
      
      line: function(el, data){
        return $('<input>', {
          type: "text",
          value: data,
          'data-type': "line",
          'data-field': $(el).data('field')
        }).get(0)
        
      },
      
      text: function(el, data){
        $(el).prop('contenteditable', true).html(data);
        try{CKEDITOR.inline(el)}catch(e){}
        return el;
      }
      
    },
    
    extract: {
      
      line: function(el){
        return $(el).val();
      },
      
      text: function(el){
        var ck = _(CKEDITOR.instances).find(function(ck){return ck.element.$ == el});
        ck && ck.destroy();
        return $(el).html();
      }
      
    },
    
    inject: {
      
      line: function(el, data){
        $(el).val(data);
      },
      
      text: function(el, data){
        $(el).html(data);
      }
      
    }
    
  })
  
  /**
   * Constructor.
   *
   * @param {Element} The original Element object.
   */
  .construct(function(element){
    this.originalElement = element;
    this.ckInstances = [];
  })
  
  .members({
    
    element:null,
    originalElement: null,
    
    //CKEDITOR Implementation.
    ckInstances: null,
    
    generateTemplate: function(data){
      
      //A clone of the original element will function as the template.
      var wrapper = $(this.originalElement.getElement()).clone()
        , self = this;
      
      //Replace editable elements.
      $('[data-field]', wrapper).each(function(){
        var type = $(this).data('type')||'text'
          , data = self.originalElement.getStatic('extract')[type](this)
          , el = self.getStatic('generators')[type](this, data);
        el==this || $(this).replaceWith(el);
      });
      
      //When a CKEditor instance is created within this template, push it to our collection.
      var onInstanceReady = function(e){
        var ck = e.editor;
        if($(ck.container.$, wrapper).size() > 0){
          self.ckInstances.push(ck);
        }
      };
      
      //CKEDITOR Implementation.
      CKEDITOR.on('instanceReady', onInstanceReady);
      
      //When this template is removed from the DOM, destroy all CKEditor instances we created.
      self.subscribe('beforeRemove', function(){
        CKEDITOR.removeListener('instanceReady', onInstanceReady);
        _(self.ckInstances).invoke('destroy');
      });
      
      //Return the template.
      return wrapper;
      
    },
    
    isClean: function(){
      return _.isEqual(this.extract(), this.originalElement.extract());
    }
    
  })
  
  .finalize();
  
  //////////////
  // Editable //
  //////////////
  
  /**
   * The main class and API.
   */
  var Editable = (new Class)
  
  .statics({
    
    instances: [],
    
    /**
     * Returns true if there are no unsaved changes in any of the Editable instances.
     *
     * @return {Boolean}
     */
    allClean: function(){
      
      return _(this.instances).every(function(instance){
        
        return _(instance.controllers).every(function(controller){
          
          return controller.model.isClean() && controller.active.isClean();
          
        });
        
      });
      
    }
    
  })
  
  /**
   * Construct the Editable class.
   *
   * @param {object} settings A map of settings that will be used by this instance of the
   *                          application.
   * 
   * @param {HTMLElement} context The node under which to look for editable elements.s
   *
   * @return {Editable}
   */
  .construct(function(settings, context){
    
    //Initiate variables.
    var editable = this;
    
    //Save.
    this._STATIC.instances.push(this);
    
    //Set properties.
    this.templates = [];
    this.controllers = [];
    this.settings = _(settings||{}).defaults({});
    this.context = context||document.body;
    
    //Initialize.
    $('[data-model]', this.context).each(function(){
      
      //Get the name and ID.
      var name = $(this).data('model');
      var id = new Element(this).id();
      
      //Create the model.
      var model = new EditableModel(name, id, false);
      
      //Create the controller.
      var controller = new EditableController(editable, model, this);
      
      //Register the template with the pool, so that third party scripts can add extractors.
      editable.controllers.push(controller);
      editable.registerTemplate(controller.template);
      
    });
    
  })
  
  .members({
    
    findTemplate: function(s){
      return _(this.templates).find(function(t){
        return t.input == s;
      });
    },
    
    /**
     * Register a template to the pool.
     *
     * @param {Template} template The instance of template to register.
     *
     * @chainable
     */
    registerTemplate: function(template){
      this.templates.push(template);
      return this;
    },
    
    registerExtractor: function(template, extractor){
      var t = this.findTemplate(template);
      if(!t) throw {type: 'ZERO_RESULTS', message: 'No template found for extractor.'};
      t.setExtractor(extractor);
      return this;
    }
    
  })
  
  .finalize();
  
  
  
  
  ///////////////////
  // Global events //
  ///////////////////
  
  CKEDITOR.disableAutoInline = true;
  
  $(window).on('beforeunload', function(){
    
    if(Editable.allClean()){
      return void(0);
    }
    
    return "You are about to discard the unsaved changes on the page.";
    
  });
  
  
  
  /////////////
  // Exports //
  /////////////
  
  global.Editable = Editable;
  
  $.fn.makeEditable = function(options){
    return new Editable(options, this);
  }
  
})(jQuery, window);

$(function(){
  window.editable = new Editable;
})
