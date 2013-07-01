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
  }
  
  //Model members.
  EditableModel.prototype = {
    
    name: null,
    id: null,
    fresh: true,
    data: {},
    
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
  
  var EditableController = Controller.sub({
    
    model: null,
    fields: {},
    
    /**
     * Construct an EditableController.
     *
     * @param {EditableModel} model The model this controller will work with.
     * @param {HTMLElement} element The HTML element to work with.
     */
    init: function(model, element){
      this.model = model;
      this.namespace = model.name;
      this.el = element;
      this.previous();
    },
    
    /**
     * Set up the controller.
     *
     * @return {this} Chaining enabled.
     */
    setup: function(){
      
      if($(this.el).is('[data-template]')){
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
      
      $(this.el).find('[data-field]').each(function(){
        
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
        
        //Create the FieldController.
        var controller = new FieldController(self, field);
        
        //Store it as one of our fields.
        self.fields[$(this).attr('data-field')] = controller;
        
        //Create the template.
        switch(field.getType()){
          case 'line':
          case 'text':
            $(field.getElement()).prop('contenteditable', true);
          break;
        }
        
      });
      
      return this;
      
    }
    
  });
  
  //FieldController.
  var FieldController = Controller.sub({
    
    controller: null,
    field: null,
    template: null,
    
    /**
     * Construct a FieldController.
     *
     * @param {EditableController} controller The parent controller.
     * @param {Field} field The instance of Field.
     */
    init: function(controller, field){
      this.controller = controller;
      this.namespace = controller.model.name;
      this.el = field.getElement();
      this.field = field;
      this.previous();
    },
    
    /**
     * Set the template.
     *
     * @param {Template} template
     *
     * @return {this} Chaining enabled.
     */
    setTemplate: function(template){
      this.template = template;
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
      });
      
    },
    
    //Restore the element to the original form.
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
      });
      
    }
    
  });
  
  ///////////
  // Field //
  ///////////
  
  function Field(element){
    this.element = element;
  }
  
  Field.prototype = {
    
    element: null,
    extractor: null,
    
    getElement: function(){
      return this.element;
    },
    
    setExtractor: function(extractor){
      this.extractor = $.proxy(extractor, this);
    },
    
    extractor: function(){
      return $(this.element).attr('data-value');
    },
    
    getType: function(){
      return $(this.element).attr('data-type');
    },
    
    getData: function(){
      return this.extractor();
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
      
    }
    
  };
  
  //////////////
  // Template //
  //////////////
  
  //Template constructor.
  function Template(element){
    this.element = element;
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
