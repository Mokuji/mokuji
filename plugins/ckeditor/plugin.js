 var tx_editor = (function(TxEditor){

  var //private properties
    defaults = {
      selector: '.editor',
      config: {
        skin: 'tx',
//        path_ckfinder: '/plugins/ckfinder/',
//        path_ckfinder_uploads: '/files/explorer/',
        // toolbar_Full:
        // [
        //   { name: 'document',   items : [ 'Source','-','Preview','Print','-','Templates' ] },
        //   { name: 'clipboard',  items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        //   { name: 'editing',    items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        //   { name: 'forms',    items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        //   '/',
        //   { name: 'basicstyles',  items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        //   { name: 'paragraph',  items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        //   { name: 'links',    items : [ 'Link','Unlink','Anchor' ] },
        //   { name: 'insert',   items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        //   '/',
        //   { name: 'styles',   items : [ 'Styles','Format','Font','FontSize' ] },
        //   { name: 'colors',   items : [ 'TextColor','BGColor' ] },
        //   { name: 'tools',    items : [ 'Maximize', 'ShowBlocks','-','About' ] }
        // ],
        toolbar:
        [
          { name: 'basicstyles',  items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
          { name: 'paragraph',  items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
          { name: 'colors',   items : [ 'TextColor','BGColor' ] },
          { name: 'styles',   items : [ 'Format' ] },
          { name: 'insert',   items : [ '-', 'Image', 'MediaEmbed' ] },
          { name: 'links',    items : [ 'Link','Unlink' ] },
          { name: 'clipboard',  items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
          { name: 'document',   items : [ 'Find','Replace','-','Source','-','Maximize' ] }
        ]
      }
    }

  //public properties
  $.extend(TxEditor, {
    options: null
  });

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
