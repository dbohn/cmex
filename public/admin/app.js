$(function() {
	jQuery('body').prop({
		"xmlns:sioc": "http://rdfs.org/sioc/ns#",
		"xmlns:dcterms": "http://purl.org/dc/terms/"
	});

	jQuery('body').midgardCreate('configureEditor', 'contact', 'ValueEditor');
	jQuery('body').midgardCreate('setEditorForType', 'Text', 'title');
	jQuery('body').midgardCreate({
		url: function() {
			return 'javascript:false;';
		},
		collectionWidgets: {
			'default': 'midgardCollectionAdd',
			'skos:related': null
		},
		stanbolUrl: 'http://dev.iks-project.eu:8081'
	});
});