define([
    'jquery',
    'underscore',
    'backbone',
    'collections/Directory',
    'views/DirectoryView'
    ], function($, _, Backbone, Directory, DirectoryView) {
        var AppRouter = Backbone.Router.extend({
            routes: {
                '*overview': 'overview'
            }
        });

        var initialize = function() {
            var app_router = new AppRouter;

            app_router.on('route:overview', function(overview) {
                //var testfile = new FileView();
                //testfile.render();
                var dircol = new Directory([{filename: 'Test1'}, {filename: 'Test2'}]);
                var dirview = new DirectoryView({collection: dircol});
                //dirview.render();
                console.log("Overview: ", overview);
            });

            Backbone.history.start();
        };

        return {
            initialize: initialize
        }
    }
);