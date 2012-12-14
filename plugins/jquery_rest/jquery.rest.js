;(function($){
  
  $.rest = function(type, path, data){
    
    type = type.toLowerCase();
    
    return $.ajax({
      url: path,
      type: type,
      data: (type == 'get' ? data : JSON.stringify(data)),
      dataType: 'json',
      contentType: 'application/json',
      processData: (type == 'get'),
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    
  };
  
})(jQuery);
