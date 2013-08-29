;(function($, exports){
  
  var Model = new Class;
  
  Model.extend({
    populate: function(records){
      
      if(records instanceof $.Deferred){
        records.done(this.proxy(_populate));
      }else{
        this.proxy(_populate)(records);
      }
      
      function _populate(records){
        var m;
        for(j in records){
          m = this.add(records[j]);
          m.id = j;
          m.save();
        }
      };
      
    },
    add: function(attr){
      return new this(attr);
    },
    create: function(attr, remote_data){
      var object = this.sub();
      object.extend({
        records: {},
        attributes: (attr || [])
      });
      return object;
    },
    find: function(id){
      var find = this.records[id];
      if( ! find) throw('Unknown record: ' + id);
      return find.dup();
    }
  });
  
  Model.extend(PubSub);
  
  Model.include({
    fresh: true,
    attributes: {},
    init: function(){
      this.attr.apply(this, arguments);
    },
    attr: function(){
      if(arguments.length == 0){
        return this.attributes;
      }
      if(scalar(arguments[0])){
        if(this.parent.attributes.indexOf(arguments[0]) < 0) throw('Undefined attribute "'+arguments[0]+'"');
        if(arguments.length == 1) return this.attributes[arguments[0]];
        this.attributes[arguments[0]] = arguments[1];
        return this;
      }
      for(i in arguments[0]) this.attr(i, arguments[0][i]);
    },
    create: function(){
      this.fresh = false;
      this.id = this.id || guid();
      this.parent.records[this.id] = this.dup();
      return this;
    },
    update: function(){
      this.parent.records[this.id] = this.dup();
      return this;
    },
    destroy: function(){
      delete this.parent.records[this.id];
    },
    save: function(){
      this.fresh ? this.create() : this.update(); return this;
    },
    dup: function(){
      return $.extend(true, {}, this);
    }
  });
  
  exports.Model = Model;

})(jQuery, window);