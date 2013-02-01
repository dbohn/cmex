require.config({
	paths: {
		'jquery': 'http://code.jquery.com/jquery-1.8.3',
		'jquery-ui': 'http://code.jquery.com/ui/1.9.2/jquery-ui'
	},
	shim: {
		'jquery-ui': {
			deps: ['jquery']
		},
		'create': {
			deps: ['jquery-ui', 'vie']
		}
	}
});

require(['jquery', 'create'], function($) {
	$(function() {
		$('.configbutton').each(function(el) {
			$(this).position({
				of: $('#'+$(this).attr('rel')),
				my: 'left bottom',
				at: 'left top',
				offset: '-2px',
				collision: 'flipfit flipfit'
			}).hover(function() {
				$('#' + $(this).attr('rel')).addClass('highlightFrame');
			}, function() {
				$('#' + $(this).attr('rel')).removeClass('highlightFrame');
			});
		});
	});
})