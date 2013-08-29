// Register a template definition set named "default".
CKEDITOR.addTemplates( 'default',
{
  // Template definitions.
  templates :
    [
      {
        title: 'Two column, left image',
        image: 'http://lorempixel.com/100/70/abstract/1/',
        description: '',
        html:
          '<h2>Title</h2>' +
          '<table class="two-column container" width="100%"><tr>' + 
          '<td class="span4"><img class="img-circle" alt="" src="http://lorempixel.com/100/100/abstract/Example" /></td>' +
          '<td class="span8"><p>Text</p></td>' +
          '</tr></table>'
      },
      {
        title: 'Two column, right image',
        image: 'http://lorempixel.com/100/70/abstract/2/',
        description: '',
        html:
          '<h2>Title</h2>' +
          '<table class="two-column container" width="100%"><tr>' + 
          '<td class="span8"><p>Text</p></td>' +
          '<td class="span4"><img class="img-circle" alt="" src="http://lorempixel.com/100/100/abstract/Example" /></td>' +
          '</tr></table>'
      }
    ]
});
