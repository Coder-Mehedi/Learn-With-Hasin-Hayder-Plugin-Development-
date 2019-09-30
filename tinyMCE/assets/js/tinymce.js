;(function() {
	tinyMCE.PluginManager.add('tmcd_plugins', function(editor, url){
		editor.addButton('tmcd_button_one', {
			'text': 'B1',
			onClick: function() {
				editor.insertContent('Hello World')
			}
		});
	})
})();