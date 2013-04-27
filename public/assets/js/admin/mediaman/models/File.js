define([
    'underscore',
    'backbone'
    ],
    function(_, Backbone) {
        var File = Backbone.Model.extend({
            defaults: {
                filename: 'File.end'
            }
        });

        return File;
    });