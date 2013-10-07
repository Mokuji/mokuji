 var tx_editor = (function(TxEditor){

  var //private properties
    defaults = {
      selector: '.editor',
      config: {
        skin: 'tx',
        height: '320px',
        toolbar: [
          { "name": "basicstyles",  "items" : [ "Bold","Italic","Underline","Strike","-","RemoveFormat" ] },
          { "name": "paragraph",  "items" : [ "NumberedList","BulletedList","-","Outdent","Indent","-","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock" ] },
          { "name": "colors",   "items" : [ "TextColor","BGColor" ] },
          { "name": "styles",   "items" : [ "Format" ] },
          { "name": "insert",   "items" : [ "-", "Image", "youtube" ] },
          { "name": "links",    "items" : [ "Link","Unlink" ] },
          { "name": "clipboard",  "items" : [ "Cut","Copy","Paste","PasteText","PasteFromWord","-","Undo","Redo" ] },
          { "name": "document",   "items" : [ "Find","Replace","-","Source","-","Maximize" ] }
        ],
        templates_files: [ '../config/ckeditor_templates.js' ],
        basicEntities : false,
        entities : false,
        forceSimpleAmpersand : true
      }
    }

  //public properties
  $.extend(TxEditor, {
    options: null
  });
  
  TxEditor.setDefaultToolbar = function(toolbar){
    defaults.config.toolbar = toolbar;
  }
  
  //public init(o)
  TxEditor.init = function(o){
    
    //create options
    this.options = options = new Options(o);

    //initialize the editor
    $(this.options.selector).ckeditor(this.options.config, function(){
      if(options.config.path_ckfinder)
        CKFinder.setupCKEditor(this, options.config.path_ckfinder);
    });

    return this;
    
  }

  //public destroy()
  TxEditor.destroy = function(){
    $(this.options.selector).ckeditorGet().destroy();
  }

  //private Options Options(o)
  function Options(o){
    $.extend(true, this, defaults, o);
    return this;
  }

  return TxEditor;

})(tx_editor||{});

// The "instanceCreated" event is fired for every editor instance created.
CKEDITOR.on( 'instanceCreated', function( event ) {

  var editor = event.editor,
    element = editor.element;

  // Customize editors for headers and tag list.
  // These editors don't need features like smileys, templates, iframes etc.
  if(element.is('h1', 'h2', 'h3') || element.getAttribute('id') == 'taglist'){

    // Customize the editor configurations on "configLoaded" event,
    // which is fired after the configuration file loading and
    // execution. This makes it possible to change the
    // configurations before the editor initialization takes place.
    editor.on('configLoaded', function(){

      // Remove unnecessary plugins to make the editor simpler.
      editor.config.removePlugins = 'colorbutton,find,flash,font,' +
        'forms,iframe,image,newpage,removeformat,' +
        'smiley,specialchar,stylescombo,templates';

      // Rearrange the layout of the toolbar.
      editor.config.toolbarGroups = [
        { name: 'editing',    groups: [ 'basicstyles', 'links' ] },
        { name: 'undo' },
        { name: 'clipboard',  groups: [ 'selection', 'clipboard' ] },
        { name: 'about' }
      ];
    });
  }

  // var savedData, newData;
  // function saveEditorData(){
  //   setTimeout(function(){

  //     newData = editor.getData();

  //     if(newData !== savedData){
  //       savedData = newData;
  //       //Do AJAX call and save data.
  //     }

  //     saveEditorData();
  //   }, 1500);
  // };

  // // Start observing the data.
  // saveEditorData();

});
