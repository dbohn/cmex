define([
    'jquery',
    'underscore',
    'backbone',
    'collections/Directory',
    'views/DirectoryView'
    ], function($, _, Backbone, Directory, DirectoryView) {
        var AppRouter = Backbone.Router.extend({
            routes: {
                '*path': 'showPath'
            }
        });

        var initialize = function() {
            var app_router = new AppRouter;

            app_router.on('route:showPath', function(path) {
                //var testfile = new FileView();
                //testfile.render();
                if(path == "") {
                    path = "local/";
                }
                var dircol = new Directory([{filename: 'Test1'}, {filename: 'Test2'}]);
                var dirview = new DirectoryView({collection: dircol});
                //dirview.render();
                console.log("Overview: ", path);
            });

            Backbone.history.start();
        };

        return {
            initialize: initialize
        }
    }
);