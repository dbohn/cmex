/*require.config({
	paths: {
		'jquery': 'http://code.jquery.com/jquery-1.8.3',
		'jquery-ui': 'http://code.jquery.com/ui/1.9.2/jquery-ui',
		'aloha': 'http://cdn.aloha-editor.org/latest/lib/aloha',
		'modernizr': 'http://modernizr.com/downloads/modernizr-latest'
	},
	shim: {
		'jquery-ui': {
			deps: ['jquery']
		},
		'backbone-min': {
			deps: ['underscore-min']
		},
		'create': {
			deps: ['jquery-ui', 'modernizr', 'backbone-min', 'vie']
		}
	}
});

require([
	'jquery', 
	'underscore-min', 
	'backbone-min', 
	'aloha',
	'create'], 
	function($, _, Backbone, Aloha) {
	$(function() {
		$('body').midgardCreate({
			url: function() { return '/some/backend/url'; },
			editor: 'aloha',
			workflows: {
				url: function(model) {
					return '/some/backend/workflows/fetch/url/' + model.id;
				}
			}
		});
	});
});*/

$(function() {
	$('body').midgardCreate({
			url: function() { return '/some/backend/url'; },
			editor: 'aloha',
			workflows: {
				url: function(model) {
					return '/some/backend/workflows/fetch/url/' + model.id;
				}
			}
		});
});