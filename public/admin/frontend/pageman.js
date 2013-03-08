define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/pageman.html'
    ], function($, _, Backbone, pagemantemplate) {
        var PageManView = Backbone.View.extend({
            tagName: 'div',

            id: 'cmex-admin-pageman',

            toolbar: null,

            created: false,

            visible: false,

            initialize: function(options) {
                if(options.toolbar !== null) {
                    this.listenTo(options.toolbar, 'clickToolbarPageButton', this.render);
                    this.listenTo(options.toolbar, 'clickToolbarShow', this.toolbarshow);
                    this.listenTo(options.toolbar, 'clickToolbarHide', this.toolbarhide);
                }
            },

            render: function() {
                if(this.created === false) {
                    this.$el.html(pagemantemplate);
                    $('body').append(this.$el);
                    this.created = true;
                    this.visible = true;
                } else {
                    //console.log('Toggle');
                    this.visible = !this.visible;
                    this.$el.toggleClass('cmex-admin-pageman-hidden');
                }
            },

            toolbarshow: function() {
                console.log('show');
                if(this.visible) {
                    this.$el.removeClass('cmex-admin-pageman-hidden');
                }
            },

            toolbarhide: function() {
                if(this.visible) {
                    this.$el.addClass('cmex-admin-pageman-hidden');
                }
            }
        });

        return PageManView;
    });