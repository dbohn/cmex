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
                this.$el.append(_.template(toolbartemplate, {name : "Benutzer"}));
            },

            toggle: function(event) {
                this.$el.toggleClass('cmex-admin-toolbar-hidden');
                event.preventDefault();
            }
        });
        return ToolbarView;
    }
);