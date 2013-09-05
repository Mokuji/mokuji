/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
  //Define changes to default configuration here
  config.language = 'nl';
  // config.plugins += ',autologin,docprops'
  // config.plugins += ',autologin,mediaembed'
  config.plugins += ',autologin,youtube';
  config.allowedContent = true;
  //config.basePath: '/plugins/ckeditor/'
  //config.skin = 'tx';
  //config.uiColor = '#AADC6E';
  config.filebrowserBrowseUrl = '../mokuji/plugins/elfinder/cke-elfinder.html';
};
