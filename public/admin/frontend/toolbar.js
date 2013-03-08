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
                'click a.cmex-admin-toolbar-toggle': 'toggle',
                'click .cmex-admin-pagebar>p>a': 'togglePageMan'
            },

            render: function() {
                var data = {
                    name : "Benutzer",
                    title : cmexPage.title
                }
                this.$el.append(_.template(toolbartemplate, data));
            },

            toggle: function(event) {
                if(this.$el.hasClass('cmex-admin-toolbar-hidden')) {
                    this.trigger('clickToolbarShow', event);
                    this.$el.removeClass('cmex-admin-toolbar-hidden');
                } else {
                    this.trigger('clickToolbarHide', event);
                    this.$el.addClass('cmex-admin-toolbar-hidden');
                }
                //this.$el.toggleClass('cmex-admin-toolbar-hidden');
                event.preventDefault();
            },

            togglePageMan: function(event) {
                this.trigger('clickToolbarPageButton', event);
                event.preventDefault();
            }
        });
        return ToolbarView;
    }
);