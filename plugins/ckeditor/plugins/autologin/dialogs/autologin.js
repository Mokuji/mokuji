CKEDITOR.dialog.add('autologin', function(editor){
  
  return {
    title: 'Autologin-link',
    minWidth: 300,
    minHeight: 126,
    contents: [
      {
        id: 'options',
        label: 'Autologin-link',
        elements: [
          {
            id: 'contents',
            label: 'Tekstinhoud van de link',
            type: 'text',
            default: editor.config.autologin.defaultText,
            required: true,
            validate: function(){
              if(!this.getValue()){
                alert('Tekstinhoud moet ingevuld zijn.');
                return false;
              }
              return true;
            }
          },
          {
            id: 'success_url',
            label: 'Doel URL bij succesvol inloggen',
            type: 'text',
            default: editor.config.autologin.successUrl,
            required: true,
            validate: function(){
              if(!this.getValue()){
                alert('Doel URL bij succesvol inloggen moet ingevuld zijn.');
                return false;
              }
              return true;
            }
          },
          {
            id: 'failure_url',
            label: 'Doel URL bij mislukt inloggen',
            type: 'text',
            default: editor.config.autologin.failureUrl,
            required: true,
            validate: function(){
              return true;
            }
          },
        ]
      }
    ],
    onOk: function(){
      editor.insertHtml(
        '<a href="#" '+
          'data-autologin="true"'+
          'data-success_url="'+this.getContentElement('options', 'success_url').getValue()+'" '+
          'data-failure_url="'+this.getContentElement('options', 'failure_url').getValue()+'">'+
            this.getContentElement('options', 'contents').getValue()+
        '</a>');
    }
  };
  
});
