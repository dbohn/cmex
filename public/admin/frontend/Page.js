define([
    'underscore',
    'backbone',
    ],
    function(_, Backbone) {
        var Page = Backbone.Model.extend({
            //url: 'admin/frontend/pages'
        });

        return Page;
    });