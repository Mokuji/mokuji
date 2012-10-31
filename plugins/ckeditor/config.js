/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	//Define changes to default configuration here
	config.language = 'nl';
	config.plugins += ',autologin,docprops'
  //config.basePath: '/plugins/ckeditor/'
	//config.skin = 'tx';
	//config.uiColor = '#AADC6E';
  config.filebrowserBrowseUrl = '../plugins/elfinder/cke-elfinder.html';
};
