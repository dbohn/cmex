define([
    'jquery',
    'underscore',
    'backbone',
    'PageCollection',
    'text!templates/pageman.html',
    'text!templates/pagelist.html'
    ], function($, _, Backbone, PageCollection, pagemantemplate, pagelist) {
        //console.log(col.models);
        var PageManView = Backbone.View.extend({
            tagName: 'div',

            id: 'cmex-admin-pageman',

            toolbar: null,

            created: false,

            visible: false,

            initialize: function(options) {

                this.collection = new PageCollection();
                
                if(options.toolbar !== null) {
                    this.listenTo(options.toolbar, 'clickToolbarPageButton', this.render);
                    this.listenTo(options.toolbar, 'clickToolbarShow', this.toolbarshow);
                    this.listenTo(options.toolbar, 'clickToolbarHide', this.toolbarhide);
                }
            },

            updatePageList: function(resp) {
                var pl = this.$el.find('.cmex-admin-page-list');

                pl.html(_.template(pagelist, {pages: resp}));
            },

            render: function() {
                if(this.created === false) {
                    this.$el.html(pagemantemplate);
                    $('body').append(this.$el);
                    this.collection.fetch({ success: _.bind(this.updatePageList, this) });
                    this.created = true;
                    this.visible = true;
                } else {
                    //console.log('Toggle');
                    this.visible = !this.visible;
                    this.$el.toggleClass('cmex-admin-pageman-hidden');
                }
            },

            toolbarshow: function() {
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