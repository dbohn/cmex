define([
    'jquery',
    'underscore',
    'backbone',
    'toolbar',
    'pageman'
    ], function($, _, Backbone, ToolbarView, PageMan){
        var initialize = function(){
            $(function() {
                //Toolbar.initialize();
                //toolbar.render();
                var tools = new ToolbarView();

                tools.render();

                $('body').append(tools.el);

                var pageman = new PageMan({toolbar: tools});

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