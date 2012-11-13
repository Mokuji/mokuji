(function($, exports){
  
  var _ref, ComTextBackend = new Class;
  
  ComTextBackend.include({
    
    defaults: {
      item: {
        id: -1
      },
      pid: -1,
      ajax: {
        url: ((_ref = window.location.href.split('#')[0]) && (_ref + ( /\?/.test( _ref ) ? '&' : '?' ) + 'section=text/json')),
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json',
        processData: true,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }
    },
    Options: null,
    
    init: function(options){
      
      this.Options = new Class;
      this.Options.extend(this.defaults);
      this.Options.extend(options);
      
      $(this.proxy(function(){
        this.placeItems();
      }));
      
    },
    
    placeItems: function(options){
      
      var app = this;
      
      app.Items = new Controller('#com-text-backend', {
      
        namespace: 'items',
        
        elements: {
          'col': '.col',
          'new': '.btn-new-text'
        },
        
        events: {
        },
        
        init: function(){
          this.loadItems().done(this.proxy(function(data){
            this.data = data;
            this.render(data);
          })).fail(app.ajaxError);
        },
        
        loadItems: function(){
          return app.ajax({
            model: 'items',
            pid: app.Options.pid
          });
        },

        placeItem: function(data){

          var tmpl = data;
          var item = $("#tmpl-text-item").tmpl(tmpl, {
            dataInfo: function(item, language_id, column){
              if(item['info'] != undefined){
                if(item['info'][language_id] != undefined){
                  return item['info'][language_id][column];
                }
              }
            },  
            dataArrayIndex: function(item){
/*
              console.log(item['info']);
              if(item['info'] != undefined){
                console.log(item['info'][1]);
              }
              return $.inArray(item, tmpl);
*/
            }
          });
          
          //append item
          this.view.html(item);

          //Create unique id for the text editor: description.
          item.find('textarea.description').each(function(){
            var that = $(this);
            $(that).attr('id', $(this).attr('id')+Math.floor((Math.random()*1000)+1));
            setTimeout(function(){tx_editor.init({selector:'#'+$(that).attr('id')});}, 5);
          });

          //Create unique id for the text editor: description.
          item.find('textarea.text').each(function(){
            var that = $(this);
            $(that).attr('id', $(this).attr('id')+Math.floor((Math.random()*1000)+1));
            setTimeout(function(){tx_editor.init({selector:'#'+$(that).attr('id')});}, 5);
          });
          
          return this;
        },
                
        render: function(data){

          this.view.empty();

          if(this.data.length == undefined){
            this.placeItem(null);
          }
          for(var i in this.data){
            this.placeItem(data[i]);
          }

          this.refreshElements();
          $(".idTabs").idTabs();

        }
        
      });
      
    },
    
    ajax: function(){
      
      var options = $.extend({}, this.Options.ajax);
      
      if(arguments.length == 1){
        $.extend(options, {
          data: (arguments[0])
        });
      }
      
      else if(arguments.length == 2){
        $.extend(options, {
          type: arguments[0],
          data: (arguments[0].toUpperCase() == 'GET' ? arguments[1] : JSON.stringify(arguments[1])),
          processData: (arguments[0].toUpperCase() != 'GET')
        });
      }
      
      else if(arguments.length == 3){
        var data = $.extend({model: arguments[1]}, arguments[2]);
        $.extend(options, {
          type: arguments[0],
          data: (arguments[0].toUpperCase() == 'GET' ? data : JSON.stringify(data)),
          processData: (arguments[0].toUpperCase() != 'GET')
        });
      }
      
      return $.ajax(options);
      
    },
    
    ajaxError: function(ajax){
      if(ajax.status<400){
        alert('Invalid server response');
      }else{
        alert(ajax.statusText);
      }
    }
    
  });

  ComTextBackend.hoi = function(o){
    alert('hoi');
  }
  
  exports.ComTextBackend = ComTextBackend;

})(jQuery, window);
