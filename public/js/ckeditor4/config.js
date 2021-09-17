/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.extraPlugins = 'button,panelbutton,colorbutton';
	
	config.font_names =
	'細明體,MingLiU;' + 
	'新細明體,PMingLiU;' +
	'標楷體,DFKai-sb;' +
	'微軟正黑體,Microsoft JhengHei;' +
    'Arial/Arial, Helvetica, sans-serif;'  +
    'Times New Roman/Times New Roman, Times, serif;' +
	'Verdana;' +
	'serif;' +
	'sans-serif;' +
	'cursive;' +
	'fantasy;' +
	'monospace;' 
	;

	config.font_names = '細明體;新細明體;標楷體;微軟正黑體;Arial;Times New Roman;Verdana;serif;sans-serif;cursive;fantasy;monospace;';

	// Brazil colors only.
	config.colorButton_colors = '00923E,F8C100,28166F';

	config.colorButton_colors = 'FontColor1/FF9900,FontColor2/0066CC,FontColor3/F00';

	// CKEditor color palette available before version 4.6.2.
	config.colorButton_colors =
		'000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,' +
		'B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,' +
		'F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,' +
		'FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,' +
		'FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF';
};
