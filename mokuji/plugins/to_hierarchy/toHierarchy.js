if(!window.toHierarchy){
  
  window.toHierarchy = function(lft_name, rgt_name, data){
    
    var output = []
      , mom = {
        node: output,
        depth: 0
      };
    
    for(var i in data){
      
      i = parseInt(i, 10);
      var obj = data[i]
        , lft = parseInt(obj[lft_name], 10)
        , rgt = parseInt(obj[rgt_name], 10);
      
      if(!lft || !rgt){
        console.log('Missing hierarchy data for object.', {lft_name:lft_name, rgt_name:rgt_name, object: obj});
        return;
      }
      
      //Make a placeholder for children and add metadata.
      obj._children = [];
      obj._depth = mom.depth;
      
      //Push to mom.
      mom.node.push(obj);
      
      //If this isn't the last node, see if we traverse depth.
      if(data[i+1])
      {
        
        //Enter subnodes
        if(parseInt(data[i+1][lft_name], 10) === lft+1){
          mom = {
            mom: mom,
            depth: mom.depth+1,
            node: obj._children
          };
        }
        
        //Last of subnodes?
        else{
          
          var fall = parseInt(data[i+1][lft_name], 10) - (rgt + 1);
          
          //For each level we fall down, ask mom
          for(var i = 0; i < fall; i++)
            mom = mom.mom;
          
        }
        
      }
      
    }
    
    return output;
    
  };
  
}
