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
     * Fetch the resource from the server.
     *
     * @return {jQuery.Deferred.Promise} The promise object handling the AJAX callbacks.
     */
    fetch: function(){
      return request(GET, this.name);
    },
    
    /**
     * Stores the resource on the server.
     *
     * @return {jQuery.Deferred.Promise} The promise object handling the AJAX callbacks.
     */
    save: function(){
      return request((this.fresh ? POST : PUT), this.name, this.getData()).done(this.proxy(function(data){
        this.data = data;
        this.fresh = false;
      }));
    },
    
    /**
     * Returns the given function in a wrapper that will execute the function in the context of this object.
     *
     * @param {function} func The function to be wrapped.
     *
     * @return {function} The wrapped function.
     */
    proxy: function(func){
      $.proxy(func, this);
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
  
  .statics({
    
    inputs: {
      
      line: function(el){
        return $('<input>', {
          type: "text",
          value: "<%= "+$(el).data('field')+" %>",
          'data-type': "line",
          'data-field': $(el).data('field')
        }).get(0); 
      },
      
      text: function(el){
        $(el).prop('contenteditable', true).html('<%= '+$(el).data('field')+' %>');
        return el;
      }
      
    },
    
    extract: {
      
      line: function(el){
        return $(el).val();
      },
      
      text: function(el){
        return $(el).html();
      }
      
    },
    
    extractor: function(el){
      
      var data = {};
      
      $('[data-field]', el).each(function(){
        data[$(this).data('field')] = EditableController.extract[$(this).data('type')||'text'](this);
      });
      
      return data;
      
    }
    
  })
  
  /**
   * Construct an EditableController.
   *
   * @param {EditableModel} model The model this controller will work with.
   * @param {HTMLElement} element The HTML element to work with.
   */
  .construct(function(editable, model, element){
    
    //Define variables.
    var template
      , controller = this;
    
    //Set properties.
    this.model = model;
    this.editable = editable;
    this.element = new Element(element);
    
    //Set initial data in the model.
    this.model.setAll(parseFormData($(element).data('data')));
    this.model.setAll(this.element.extract());
    
    //Make sure the editable class gets assigned.
    $(element).addClass('editable');
    
    //Get the template from the data-template property.
    if($(element).is('[data-template]')){
      template = new Template($(element).data('template'));
    }
    
    //Generate a custom template based on fields.
    else{
      
      //This will be the wrapper for the template.
      var wrapper = $(element).clone();
      
      //Replace editable elements.
      $('[data-field]', wrapper).each(function(){
        var el = EditableController.inputs[$(this).data('type')||'text'](this);
        el==this || $(this).replaceWith(el);
      });
      
      //Create the template.
      template = new Template(wrapper.get(0), EditableController.extractor);
      
    }
    
    //Store the template.
    this.template = template;
    
    //Bind events.
    $('body').on('click', '#' + this.element.id() , function(e){
      controller.editing() || controller.replace();
    });
    
    $('body').on('keyup', function(e){
      e.which == 27 && controller.editing() && controller.restore();
    })
    
  })
  
  //Define members for the EditableController class.
  .members({
    
    model: null,
    element: null,
    template: null,
    save_btn: null,
    _editing: false,
    
    replace: function(){
      this.template.replace(this.element.getElement(), this.model.getData());
      $(this.template.getElement()).addClass('editing');
      CKEDITOR.inlineAll();
      this.setEditing();
    },
    
    restore: function(){
      this.model.setAll(this.template.extract());
      this.element.replace(this.template.getElement(), this.model.getData());
      $(this.element.getElement()).removeClass('editing');
      this.setEditing(false);
      this.setChanged();
    },
    
    setEditing: function(e){
      this._editing = (e==undefined?true:e);
      return this;
    },
    
    editing: function(){
      return !! this._editing;
    },
    
    setChanged: function(){
      
      var self = this;
      
      $(this.save_btn).remove();
      
      this.save_btn = $('<button>', {
        text: 'Save'
      });
      
      this.save_btn.appendTo(this.element.getElement());
      
      this.save_btn.on('click', function(){
        self.save_btn.remove();
        self.model.save();
      });
      
    }
    
  })
  
  //Finalize the EditableController class.
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
     * @param {[type]} data Optional new data to inject.
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
      if(id = $(this.element).attr('id')){
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
     * @param {HTMLElement} element The DOM-element to replace.
     * @param {object} data The data to inject into the template.
     *
     * @chainable
     */
    replace: function(element, data){
      var el = this.getElement(data);
      $(element).replaceWith(el);
      this.publish('placed', el);
      return this;
    },
    
    /**
     * Extract data from the DOM using the static extractors on the defined fields.
     *
     * @return {object} The extracted data.
     */
    extract: function(){
      
      var data = {};
      
      $('[data-field]', this.element).each(function(){
        data[$(this).data('field')] = Element.extract[$(this).data('type') || 'text'](this);
      });
      
      return data;
      
    },
    
    /**
     * Injects data into the DOM using the static injectors on the defined fields.
     *
     * @chainable
     */
    inject: function(data){
      
      $('[data-field]', this.element).each(function(){
        Element.inject[$(this).data('type') || 'text'](this, data[$(this).data('field')]);
      });
      
      return this;

    },
    
    /**
     * Detach the element from the DOM.
     *
     * @chainable
     */
    detach: function(){
      $(this.getElement()).detach();
      this.publish('removed');
      return this;
    }
    
  })
  
  .finalize();
  
  
  
  //////////////
  // Template //
  //////////////
  
  /**
   * Template class
   *
   * This class wraps information required to acquire a template and allows others to
   * retrieve the DOMElement. It also keeps the extractor for the template.
   */
  var Template = (new Class).extend(Element)
  
  /**
   * Construct a Template.
   *
   * @param {HTMLElement|string} element Where to find the element. Can be either of the following:
   *                                     - HTMLElement: The already abstracted template.
   *                                     - "#<ID>": An ID pointing to the template in the DOM.
   *                                     - "<component>/<template>": The template resource on the server.
   *                                     
   * @param {function} extractor The function that can extract the data from the template.
   *
   * @return {Template}
   */
  .construct(function(element, extractor){
    
    this.extractor = extractor;
    this.input = element;
    
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
     * Returns the already existing element, or one with new data if data is given.
     *
     * @param {[type]} data [description]
     *
     * @return {[type]} [description]
     */
    getElement: function(data){
      return (!data && this.element) || (this.setElement(this.getEJS().render(data||{})));
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
  
  
  
  //////////////
  // Editable //
  //////////////
  
  /**
   * The main class and API.
   */
  var Editable = (new Class)
  
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
    
    //Set properties.
    this.templates = [];
    this.controllers = {};
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
