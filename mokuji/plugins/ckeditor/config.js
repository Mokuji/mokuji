/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{

  //Define changes to default configuration here
  config.language = 'nl';
  config.allowedContent = true;
  config.plugins += ',autologin,youtube';
  config.filebrowserBrowseUrl = '../mokuji/plugins/elfinder/cke-elfinder.html';
  
};
