/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles' ] },
		'/',
		{ name: 'cleanup', groups: [ 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		// { name: 'about', groups: [ 'about' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'mode', groups: [ 'mode' ] }
	];

	config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Templates,Scayt,Form,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Language,BidiRtl,BidiLtr,Flash,PageBreak,ShowBlocks';
};
