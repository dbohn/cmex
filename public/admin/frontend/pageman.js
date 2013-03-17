define([
    'jquery',
    'underscore',
    'backbone',
    'PageCollection',
    'Page',
    'text!templates/pageman.html',
    'text!templates/pagelist.html',
    'dependencies/backbone-forms/backbone-forms.min'
    ], function($, _, Backbone, PageCollection, Page, pagemantemplate, pagelist) {
        //console.log(col.models);
        var PageManView = Backbone.View.extend({
            tagName: 'div',

            id: 'cmex-admin-pageman',

            toolbar: null,

            created: false,

            visible: false,

            currentPage: null,

            form: null,

            'events': {
                'click .cmex-admin-page-list a': 'logClick'
            },

            initialize: function(options) {

                this.collection = new PageCollection();
                
                if(options.toolbar !== null) {
                    this.listenTo(options.toolbar, 'clickToolbarPageButton', this.render);
                    this.listenTo(options.toolbar, 'clickToolbarShow', this.toolbarshow);
                    this.listenTo(options.toolbar, 'clickToolbarHide', this.toolbarhide);
                }

                this.currentPage = new Page(options.page);
                console.log(this.currentPage.url());
                //this.currentPage = options.page.id;
            },

            logClick: function(ev) {
                ev.preventDefault();
                // $(ev.currentTarget).text('Aua');
                var id = $(ev.currentTarget).attr('data-id');
                //console.log($(ev.currentTarget).attr('data-id'));

                this.currentPage = new Page({id: id});

                this.currentPage.fetch({
                    success: _.bind(this.updatePageForm, this)
                });
            },

            updatePageList: function(resp) {
                //console.log(this.collection.get(this.options.page.id))
                var pl = this.$el.find('.cmex-admin-page-list');

                pl.html(_.template(pagelist, {pages: resp}));
            },

            updatePageForm: function() {
                this.form = new Backbone.Form({model: this.currentPage}).render();
                this.$el.find('.cmex-admin-property-column').html('').append(this.form.el);
            },

            render: function() {
                if(this.created === false) {
                    this.$el.html(pagemantemplate);

                    //var curpage = new Page(this.options.page);
                    $('body').append(this.$el);

                    this.updatePageForm();
                    
                    this.collection.fetch({
                        success: _.bind(this.updatePageList, this)
                    });
                    this.created = true;
                    this.visible = true;
                } else {
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