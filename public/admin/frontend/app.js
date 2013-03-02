define([
    'jquery',
    'underscore',
    'backbone',
    'toolbar'
    ], function($, _, Backbone, ToolbarView){
        var initialize = function(){
// Pass in our Router module and call it's initialize function
            $(function() {
                //Toolbar.initialize();
                //toolbar.render();
                var tools = new ToolbarView();

                tools.render();

                $('body').append(tools.el);
            });
        }
        return {
            initialize: initialize
        };
    }
);