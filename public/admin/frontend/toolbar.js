define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/toolbar.html'
    ], function($, _, Backbone, toolbartemplate){
        var ToolbarView = Backbone.View.extend({
            tagName: 'div',

            id: 'cmex-admin-toolbar-container',

            'events': {
                'click a.cmex-admin-toolbar-toggle': 'toggle'
            },

            render: function() {
                var data = {
                    name : "Benutzer",
                    title : cmexPage.title
                }
                this.$el.append(_.template(toolbartemplate, data));
            },

            toggle: function(event) {
                this.$el.toggleClass('cmex-admin-toolbar-hidden');
                event.preventDefault();
            }
        });
        return ToolbarView;
    }
);