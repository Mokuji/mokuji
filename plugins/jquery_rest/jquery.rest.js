;(function($){
  
  $.rest = function(type, path, data){
    
    return $.ajax({
      url: path,
      type: type,
      data: JSON.stringify(data),
      dataType: 'json',
      processData: false
    });
    
  };
  
})(jQuery);
