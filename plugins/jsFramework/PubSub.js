;(function($, exports){
  
  var PubSub = {
    pubsub:   $({}),
    subscribe: function(){
      this.pubsub.bind.apply(this.pubsub, arguments);
    },
    unsubscribe: function(){
      this.pubsub.unbind.apply(this.pubsub, arguments);
    },
    publish: function(){
      this.pubsub.trigger.apply(this.pubsub, arguments);
    }
  };
  
  exports.PubSub = PubSub;
  
})(jQuery, window);
