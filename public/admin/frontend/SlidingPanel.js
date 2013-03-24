define([
    'jquery',
    'underscore',
    'backbone',
    ], function($, _, Backbone) {
        //console.log(col.models);
        var SlidingPanel = Backbone.View.extend({
            tagName: 'div',

            className: 'cmex-admin-sliding-panel',

            toolbar: null,

            created: false,

            visible: false,

            initialize: function(options) {
                if(options.toolbar !== null) {
                    //this.listenTo(options.toolbar, 'clickToolbarPageButton', this.render);
                    this.listenTo(options.toolbar, 'clickToolbarShow', this.toolbarshow);
                    this.listenTo(options.toolbar, 'clickToolbarHide', this.toolbarhide);
                }
            },

            buildUI: function() {
                this.$el.html("Sliding Panel");
            },

            render: function() {
                if(this.created === false) {

                    this.buildUI();

                    if($.type(this.$el.parent().prop('tagName')) === "undefined") {
                        $('body').append(this.$el);
                    }

                    this.created = true;
                    this.visible = true;
                } else {
                    this.visible = !this.visible;
                    this.$el.toggleClass('cmex-admin-sliding-panel-hidden');
                }
            },

            toolbarshow: function() {
                if(this.visible) {
                    this.$el.removeClass('cmex-admin-sliding-panel-hidden');
                }
            },

            toolbarhide: function() {
                if(this.visible) {
                    this.$el.addClass('cmex-admin-sliding-panel-hidden');
                }
            }
        });

        return SlidingPanel;
    });