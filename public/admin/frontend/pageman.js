define([
    'jquery',
    'underscore',
    'backbone',
    'PageCollection',
    'Page',
    'SlidingPanel',
    'text!templates/pageman.html',
    'text!templates/pagelist.html',
    'dependencies/backbone-forms/backbone-forms.min'
    ], function($, _, Backbone, PageCollection, Page, SlidingPanel, pagemantemplate, pagelist) {
        //console.log(col.models);

        var PageManView = SlidingPanel.extend({
            id: 'cmex-admin-pageman',

            currentPage: null,

            form: null,

            'events': {
                'click .cmex-admin-page-list a': 'logClick'
            },

            initialize: function(options) {
                // Call parent initalize for registering the events
                init = _.bind(SlidingPanel.prototype.initialize, this);
                init(options);

                if(options.toolbar !== null) {
                    this.listenTo(options.toolbar, 'clickToolbarPageButton', this.render);
                }

                this.collection = new PageCollection();

                this.currentPage = new Page(options.page);
                // console.log(this.currentPage.url());
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

                this.$el.find('.cmex-admin-page-list li.active').removeClass('active');
                $(ev.currentTarget).parent().addClass('active');
            },

            updatePageList: function(resp) {
                //console.log(this.collection.get(this.options.page.id))
                var pl = this.$el.find('.cmex-admin-page-list');

                pl.html(_.template(pagelist, {pages: resp}));

                this.$el.find('.cmex-admin-page-list a[data-id=' + this.currentPage.get('id') + ']').parent().addClass('active');
            },

            updatePageForm: function() {
                // this.currentPage.on("change", function(ev) {
                //     console.log(ev);
                // });
                this.form = new Backbone.Form({model: this.currentPage}).render();
                this.$el.find('.cmex-admin-property-column').html('').append(this.form.el);
            },

            buildUI: function() {
                this.$el.html(pagemantemplate);

                this.updatePageForm();
                
                this.collection.fetch({
                    success: _.bind(this.updatePageList, this)
                });
            }
        });

        return PageManView;
    });