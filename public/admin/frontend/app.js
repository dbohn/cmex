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

                // Scan for chunks

                var chunks = $('[about]');

                var textblocks = chunks.filter('[typeof="text.block"]');

                textblocks.attr('contenteditable', 'true');

                _.each(textblocks, function(block) {
                    CKEDITOR.inline(block);
                });

            });
        }
        return {
            initialize: initialize
        };
    }
);