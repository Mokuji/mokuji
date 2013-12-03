function assert(value, message){
  if( ! value) throw (message || (value + " does not equal true"));
}

function assertEqual(value1, value2, message){
  if(value1 !== value2) throw (message || (value1 + " does not equal " + value2));
}

function log(){
  if(typeof console == 'undefined') return false;
  console.log.apply(console, arguments);
  return true;
}

function dir(){
  if(typeof console == 'undefined') return false;
  for(i in arguments) console.dir.call(console, arguments[i]);
  return true;
}

function guid(){
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(c){
    var r = Math.random()*16|0;
    return (c == 'x' ? r : (r&0x3|0x8)).toString(16);
  }).toUpperCase();
}

function scalar(value){
  return (/boolean|number|string/).test(typeof value);
}