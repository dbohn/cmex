define([
    'underscore',
    'backbone',
    ],
    function(_, Backbone) {
    	var TemplateModel = Backbone.Model.extend({
    		toString: function() {
    			return this.get('name');
    		}
    	});

    	var TemplateCollection = Backbone.Collection.extend({
    		url: 'admin/frontend/template-list',
    		model: TemplateModel
    	});

        var Page = Backbone.Model.extend({
            urlRoot: 'admin/frontend/page',
            schema: {
            	title: {type: 'Text', title: 'Seitentitel'},
            	identifier: 'Text',
            	template: {type: 'Select', options: new TemplateCollection()}
            }
        });

        return Page;
    });