;(function($, exports){
  
  var PubSub = {
    subscribe: function(){
      if(!this.pubsub) this.pubsub = $({});
      this.pubsub.bind.apply(this.pubsub, arguments);
    },
    unsubscribe: function(){
      if(!this.pubsub) this.pubsub = $({});
      this.pubsub.unbind.apply(this.pubsub, arguments);
    },
    publish: function(){
      if(!this.pubsub) this.pubsub = $({});
      this.pubsub.trigger.apply(this.pubsub, arguments);
    }
  };
  
  exports.PubSub = PubSub;
  
})(jQuery, window);
