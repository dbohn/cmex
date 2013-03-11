define([
    'underscore',
    'backbone',
    'Page'
    ],
    function(_, Backbone, Page) {
        var PageCollection = Backbone.Collection.extend({
            url: 'admin/frontend/pages',
            model: Page
        });

        return PageCollection;
    });