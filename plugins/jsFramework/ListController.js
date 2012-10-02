;(function($, exports){
  
  /* ---------- ListController ---------- */
  exports.ListController = Controller.sub({
    
    length: 0,
    items: {},
    selectedItems: {},
    //activeItem: undefined
    
    //Select all
    selectAll: function(){
      this.each(function(item){
        item.setSelected(true);
      });
      
      return this;
      
    },
    
    //Select none
    selectNone: function(){
      this.each(function(item){
        item.setSelected(false);
      });
      
      return this;
      
    },
    
    //Add an item to this list.
    addItem: function(item){
      
      //Store item in the list.
      this.items[this.length] = item;
      item.index = this.length;
      
      //Add item to the DOM.
      this.view.append(item.view);
      
      //Increment the list length.
      this.length++;
      
      return this;
      
    },
    
    //Empties this list.
    empty: function(){
      
      var that = this;
      
      this.each(function(item){
        //Remove the DOM elements.
        item.view.remove();
        
        //Delete the controller.
        delete that.items[item.index];
        delete that.selectedItems[item.index];
        delete that.activeItem;
      });
      
      this.length = 0;
      
      return this;
      
    },
    
    //For each item.
    each: function(callback){
      
      for(var index in this.items)
        callback(this.items[index]);
      
      return this;
      
    },
    
    //For each selected item.
    eachSelected: function(callback){
      
      for(var index in this.selectedItems)
        callback(this.selectedItems[index]);
      
      return this;
      
    }
    
  }); //ListController
  
})(jQuery, window);
