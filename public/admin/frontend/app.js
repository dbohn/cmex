define([
    'jquery',
    'underscore',
    'backbone',
    'toolbar',
    'pageman',
    'SlidingPanel'
    ], function($, _, Backbone, ToolbarView, PageMan, SlidingPanel){
        var initialize = function(){
            $(function() {
                var tools = new ToolbarView({page: cmexPage});

                tools.render();

                $('body').append(tools.el);

                var pageman = new PageMan({toolbar: tools, page: cmexPage});

                // Scan for chunks

                var chunks = $('[about]');

                var textblocks = chunks.filter('[typeof="text.block"]');
                
                CKEDITOR.disableAutoInline = true;

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