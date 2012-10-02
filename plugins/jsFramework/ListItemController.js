;(function($, exports){
  
  /* ---------- ListItemController ---------- */
  exports.ListItemController = Controller.sub({
    
    template: null,
    data: {},
    parentList: null,
    index: 0,
    active: false,
    selected: false,
    
    //Init
    init: function(data){
      if(!this.template) throw "Template required.";
      if(!this.parentList) throw "Parent list required.";
      this.render(data);
      this.previous(void 0);
      this.data = data;
    },
    
    //Render
    render: function(data){
      var replaced, el = $(this.template).tmpl(data);
      this.view && this.view.replaceWith(el) && (replaced = true);
      this.view = el;
      this.refreshElements();
      replaced && this.bindEvents();
      
      return this;
      
    },
    
    //Activate only this item.
    activate: function(e){
      
      //Activate this if it wasn't already.
      if(!this.active)
      {
        
        //Deactivate all others in the list.
        this.parentList.each(function(item){
          item.deactivate();
        });
        
        //Set ourselves to active once everyone was deactivated.
        this.active = true;
        this.parentList.activeItem = this;
        this.view.addClass('active');
        
      }
      
      return this;
      
    },
    
    //Deactivate this item.
    deactivate: function(e){
      this.active = false;
      this.view.removeClass('active');
      
      return this;
      
    },
    
    //Turn selected on or off.
    toggleSelected: function(e){
      
      if(this.selected)
        this.setSelected(false);
      else
        this.setSelected(true);
      
      return this;
      
    },
    
    //Set whether this item should be selected.
    setSelected: function(value){
      
      if(value === true && !this.selected){
        this.selected = true;
        this.parentList.selectedItems[this.index] = this;
        this.view.addClass('selected');
      }
      else if(this.selected && !value){
        this.selected = false;
        delete this.parentList.selectedItems[this.index];
        this.view.removeClass('selected');
      }
      
      return this;
      
    }
    
  });
  
  exports.ListItemController.extend({
    
    //Create a new instance of this node and add it to it's parent list.
    create: function(data){
      
      var
        data = $.extend({}, data);
        node = new this(data);
      
      node.parentList.addItem(node);
      
      return node;
      
    }
    
  }); //ListItemController
  
})(jQuery, window);
