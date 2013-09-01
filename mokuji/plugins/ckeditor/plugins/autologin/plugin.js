CKEDITOR.plugins.add('autologin', {
  init: function (editor) {
    var b = new CKEDITOR.dialogCommand('autologin');
    editor.addCommand('autologin', b);
    CKEDITOR.dialog.add('autologin', this.path + 'dialogs/autologin.js');
    editor.ui.addButton('Autologin', {
      label: 'Autologin',
      command: 'autologin',
      icon: this.path + 'images/autologin.png'
    });
  }
});
