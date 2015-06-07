(function() {
	tinymce.PluginManager.add('uasc_mce_button', function( editor, url ) {
		editor.addButton( 'uasc_mce_button', {
			icon: 'uasc-mce-icon',
            tooltip: 'User Access Shortcodes FREE',
			type: 'menubutton',
			menu: [
				{
				    text: 'Guests only',
				    onclick: function() {
				    	editor.insertContent('[UAS_guest]<br/>This content can only be seen by guests.<br/>[/UAS_guest]');
				    },
                },
                {
				    text: 'Logged in users only',
				    onclick: function() {
				        editor.insertContent('[UAS_loggedin]<br/>This content can only be seen by logged in users.<br/>[/UAS_loggedin]');
				    },
                },
			]
		});
	});
})();