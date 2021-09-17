CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		'/',
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Sourcedialog,About,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,Scayt,Print,Preview,NewPage,Save,Language,BidiRtl,BidiLtr,ImageButton';
  

  config.filebrowserImageUploadUrl = '/management/news/upload_content_image';
  config.allowedContent=true;
 
  config.contentsCss = ['/css/style.css', '/css/editor.css'];
  config.autoGrow_onStartup = true;
  config.autoGrow_bottomSpace = 50;
  config.autoGrow_maxHeight = 500;
  
  config.templates_files = [CKEDITOR.plugins.getPath("templates")+'templates/editor_template.js'];
  //config.enterMode = CKEDITOR.ENTER_BR;
  config.shiftEnterMode = CKEDITOR.ENTER_P;
};
CKEDITOR.on( 'instanceReady', function( ev ){
	with (ev.editor.dataProcessor.writer) {
	  setRules("p",  {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("h1", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("h2", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("h3", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("h4", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("h5", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("div", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("table", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("tr", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("td", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("iframe", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("li", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("ul", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	  setRules("ol", {indent : false, breakBeforeOpen : false, breakAfterOpen : false, breakBeforeClose : false, breakAfterClose : false} );
	}
})
