;(function($){
  
  //////////
  // GUID //
  //////////
  function guid(){
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
  }
  
  ///////////
  // Model //
  ///////////
  
  /**
   * Construct an EditableModel.
   *
   * @param {string} name The name of the model. Used to find the server resource.
   * @param {mixed} id The local identifier of the model. Generates one if omitted.
   * @param {boolean} fresh Whether this model is not yet present on the server.
   */
  function EditableModel(name, id, fresh){
    this.name = name;
    this.fresh = fresh||false;
    this.id = id || guid();
    this.data = {};
  }
  
  //Model members.
  EditableModel.prototype = {
    
    name: null,
    id: null,
    fresh: true,
    data: null,
    
    get: function(key){
      return this.data[key];
    },
    
    set: function(key, value){
      this.data[key] = value;
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
    
  };
  
  /////////////////
  // Controllers //
  /////////////////
  
  /**
   * Construct an EditableController.
   *
   * @param {EditableModel} model The model this controller will work with.
   * @param {HTMLElement} element The HTML element to work with.
   */
  function EditableController(model, element){
    this.model = model;
    this.element = element;
    this.fields = {};
  }
  
  EditableController.prototype = {
    
    model: null,
    element: null,
    fields: null,
    
    /**
     * Set up the controller.
     *
     * @return {this} Chaining enabled.
     */
    setup: function(){
      
      if($(this.element).is('[data-template]')){
        return this.setupTemplate();
      }
      
      else{
        return this.setupFields();
      }
      
    },
    
    /**
     * Set up the different fields inside this editable.
     *
     * @return {this} Chaining enabled.
     */
    setupFields: function(){
      
      var self = this;
      
      $(this.element).find('[data-field]').each(function(){
        
        //Create the Field instance.
        var field = new Field(this);
        
        //Create the data extractor.
        field.setExtractor(function(){
          switch(this.getType()){
            case 'line': return $(this.element).text();
            case 'text': return $(this.element).html();
            default: return $(this.element).attr('data-value');
          }
        });
        
        //Create the data inserter.
        field.setInserter(function(value){
          switch(this.getType()){
            case 'line': return $(this.element).text(value);
            case 'text': return $(this.element).html(value);
            default: return $(this.element).attr('data-value', value);
          }
        });
        
        //Create the FieldController.
        var controller = new FieldController(self, field);
        
        //Store it as one of our fields.
        self.fields[$(this).attr('data-field')] = controller;
        
        //Store the data in the model.
        self.model.set(field.getKey(), field.getData());
        
        //Create the template.
        switch(field.getType()){
          case 'line': controller.setTemplate(new LineTemplate); break;
          case 'text': $(field.getElement()).prop('contenteditable', true); break;
          default: console.log('WARNING: No template for type: ' + field.getType());
        }
        
        //Create the change handler.
        field.subscribe('change', function(){
          self.model.set(field.getKey(), field.getData());
          self.setChanged();
        });
        
      });
      
      return this;
      
    },
    
    setChanged: function(){
      console.log('changed');
      console.dir(this.model);
    }
    
  };
  
  /**
   * Construct a FieldController.
   *
   * @param {EditableController} controller The parent controller.
   * @param {Field} field The instance of Field.
   */
  function FieldController(controller, field){
    
    //Set up properties.
    this.controller = controller;
    this.namespace = controller.model.name;
    this.field = field;
    var self = this;
    
    //Bind events.
    field.subscribe('focus', function(){
      self.replace();
    });
    
  }
  
  FieldController.prototype = {
    
    controller: null,
    field: null,
    template: null,
    
    /**
     * Set the template.
     *
     * @param {Template} template
     *
     * @return {this} Chaining enabled.
     */
    setTemplate: function(template){
      
      this.template = template;
      var self = this;
      
      template.subscribe('blur', function(){
        self.restore();
      });
      
      return this;
      
    },
    
    //Replace the element with its editable template.
    replace: function(){
      
      //No template? Abort.
      if(this.template == null){
        return this;
      }
      
      //Reference this.
      var self = this;
      
      //Replace the field element with the template element.
      return this.template.getElement().done(function(element){
        $(self.field.getElement()).replaceWith(element);
        self.template.setData(self.field.getData());
        self.template.placed();
      });
      
    },
    
    //Restore the element to its original form.
    restore: function(){
      
      //No template? Abort.
      if(this.template == null){
        return this;
      }
      
      //Reference this.
      var self = this;
      
      //Replace the template element with the field element.
      return this.template.getElement().done(function(element){
        $(element).replaceWith(self.field.getElement());
        self.field.setData(self.template.getData());
        self.field.placed();
      });
      
    }
    
  };
  
  //////////////////////
  // Element Wrappers //
  //////////////////////
  
  //Construct an Element.
  function Element(element){
    this.element = element;
  }
  
  //Implement the PubSub trait.
  Element.prototype = $.extend({}, PubSub, {
    
    element: null,
    extractor: function(){return $(this.element).attr('data-value')},
    inserter: function(v){return $(this.element).attr('data-value', v)},
    
    getElement: function(){
      return this.element;
    },
    
    setExtractor: function(extractor){
      this.extractor = $.proxy(extractor, this);
    },
    
    setInserter: function(inserter){
      this.inserter = $.proxy(inserter, this);
    },
    
    getData: function(){
      return this.extractor();
    },
    
    setData: function(value){
      this.publish('change');
      return this.inserter(value);
    },
    
    placed: function(){}
    
  });
  
  //Field extends Element.
  Field = function(){
    Element.apply(this, arguments);
    this.bindDetector();
  }
  
  Field.prototype = $.extend(Object.create(Element.prototype), {
    
    getType: function(){
      return $(this.element).attr('data-type');
    },
    
    getKey: function(){
      return $(this.element).attr('data-field');
    },
    
    //Get the ID of the element. Creates one automatically if the element doesn't have one.
    id: function(){
      
      //Define in the local scope.
      var id;
      
      //Return the ID of the element.
      if(id = $(this.element).attr('id')){
        return id;
      }
      
      //Create our own unique ID first.
      id = guid();
      
      //Set the ID.
      $(this.element).attr('id', id);
      
      //Return the ID.
      return id;
      
    },
    
    placed: function(){
      this.bindDetector();
    },
    
    bindDetector: function(){
      
      var self = this;
      
      $(this.element)
      
      .on('click', function(){
        self.publish('focus');
      })
      
      .on('blur', function(){
        self.publish('change');
      });
      
    }
    
  });
  
  ///////////////
  // Templates //
  ///////////////
  
  //Template extends Element.
  function Template(){
    Element.apply(this, arguments);
  }
  
  Template.prototype = $.extend(Object.create(Element.prototype), {
    
    getElement: function(){
      return $.Deferred().resolve(this.element).promise();
    }
    
  });
  
  //InputTemplate extends Template, but does not use its constructor.
  function InputTemplate(){
    this.element = $('<input>');
  }
  
  InputTemplate.prototype = $.extend(Object.create(Template.prototype), {
    
    element: null,
    
    extractor: function(){
      return $(this.element).val();
    },
    
    inserter: function(value){
      return $(this.element).val(value)
    },
    
    placed: function(){
      $(this.element).focus();
      this.bindDetector();
    },
    
    bindDetector: function(){
      var self = this;
      $(this.element).on('blur', function(){
        self.publish('blur');
      });
    }
    
  });
  
  function LineTemplate(){
    this.element = $('<input>', {type:'text'});
  }
  
  LineTemplate.prototype = $.extend(Object.create(InputTemplate.prototype), {});
  
  //A template for externally loaded templates.
  function TemplateTemplate(){
    
  }
  
  ////////////////
  // Initialize //
  ////////////////
  $(function(){
    
    $('[data-model]').each(function(){
      
      //Get the name and ID.
      var name = $(this).data('model');
      var id = $(this).id();
      
      //Create the model.
      var model = new EditableModel(name, id, false);
      
      //Create the controller.
      var controller = new EditableController(model, this);
      
      //Set up the controller.
      controller.setup();
      
    });
    
  });
  
  
})(jQuery);
