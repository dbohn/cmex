define([
    'underscore',
    'backbone',
    'models/File'
    ],
    function(_, Backbone, File) {
        var Directory = Backbone.Collection.extend({
            model: File
        });

        return Directory;
    });