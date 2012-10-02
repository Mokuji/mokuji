;(function($, exports){
  
  var StateMachine = new Class;
  
  StateMachine.include(PubSub);
  
  StateMachine.include({
    
    controllers: [],
    activeController: -1,
    
    init: function(){
      this.add.apply(this, arguments);
    },
    
    add: function(){
      
      var sm = this;
      
      $.each(arguments, this.proxy(function(k, controller){
        
        //validate
        assert(controller instanceof Controller || controller instanceof Manager, "Only Controller's or Manager's may be added to the StateMachine.");
        
        //wrap the activate function in a StateMachine function
        controller.activate = (function(activator){return function(){
          
          for(var i=0; i < sm.controllers.length; i++){
            if(sm.controllers[i] !== this){
              sm.controllers[i].deactivate();
            }
          }
          
          activator.apply(this, arguments);
          
          sm.activeController = sm.controllers.indexOf(this);
          sm.publish('change', this);
          
        }})(controller.activate);
        
        //wrap the deactivate function in a StateMachine function
        controller.deactivate = (function(deactivator){return function(){
          
          deactivator.apply(this, arguments);
          
          if(this.isActive()){
            sm.activeController = -1;
          }
          
          sm.publish('change', this);
          
        }})(controller.deactivate);
        
        //make isActive function
        controller.isActive = function(){
          return sm.controllers[sm.activeController] === this;
        };
        
        //make a toggle function for convenience
        controller.toggle = function(){
          this.isActive() ? this.deactivate() : this.activate();
        }
        
        //keep a reference to this
        controller.manager = this;
        
        this.controllers.push(controller);
        
      }));
      
      //return the latest index
      return this.controllers.length-1;
      
    },
    
    active: function(){
      return this.controllers[this.activeController] || false;
    }
    
  });
  
  //a manager controls controllers (instead of methods it has controllers)
  var Manager = Controller.sub({
    
    state: new StateMachine(),
    devault: -1,
    controllers: {},
    
    activate: function(){
      if(this.devault >= 0) this.state.controllers[this.controllers[this.devault]].activate();
    },
    
    deactivate: function(){
      var active = this.state.active();
      active && active.deactivate();
    },
    
    init: function(){
      this.previous();
      for(var i in this){
        if(this[i] instanceof Controller){
          this.add(this[i]);
        }
      }
    },
    
    add: function(){
      
      var map;
      
      if( $.isArray(arguments[0]) ){
        map = arguments[0];
      }else{
        map = $.makeArray(arguments);
      }
      
      for(var i = 0; i < map.length; i++){
        var index = this.state.add(map[i]);
        this.controllers[i] = index;
      }
      
    },
    
    //overwrites the bindEvents function with a function that binds all events to the activation of controllers
    bindEvents: function(){
      
      var events = {};
      
      for(var i in this.events){
        events[i] = $.isFunction(this.events[i]) ? this.events[i] : (function(controller, controllers){
          
          var name, method, match = controller.match(/^(?:(show|activate|hide|deactivate|toggle) +)?(\w+)$/);
          match.shift();
          
          if(match[0]){
            method = (match[0] == 'show' && 'activate') || (match[0] == 'hide' && 'deactivate') || match[0];
          }else{
            method = 'activate';
          }
          
          
          name = match[1];

          return function(){
            controllers[name][method]();
          };
          
        })(this.events[i], this);
      }
      
      this.events = events;
      this.previous();
      
    }
    
  });
  
  exports.StateMachine = StateMachine;
  exports.Manager = Manager;

})(jQuery, window);