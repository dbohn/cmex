define [
    'jquery'
    'underscore'
    'backbone'
    'PageCollection'
    'Page'
    'SlidingPanel'
    'text!templates/pageman.html'
    'text!templates/pagelist.html'
    'dependencies/backbone-forms/backbone-forms.min'
], ($, _, Backbone, PageCollection, Page, SlidingPanel, pagemantemplate, pagelist) ->
    class PageManView extends SlidingPanel
        id: 'cmex-admin-pageman'
        currentPage: null
        form: null
        events:
            'click .cmex-admin-page-list a': 'logClick'
        initialize: (options) ->
            init = _.bind SlidingPanel.prototype.initialize, @
            init(options)

            if options.toolbar?
                @listenTo options.toolbar, 'clickToolbarPageButton', @render

            @collection = new PageCollection()
            @currentPage = new Page(options.page)

        logClick: (ev) ->
            ev.preventDefault()
            id = $(ev.currentTarget).attr 'data-id'
            @currentPage = new Page {id: id}
            @currentPage.fetch {success: _.bind @updatePageForm, @}
            @$el.find('.cmex-admin-page-list li.active').removeClass 'active'
            $(ev.currentTarget).parent().addClass 'active'

        updatePageList: (resp) ->
            pl = @$el.find '.cmex-admin-page-list'
            pl.html(_.template pagelist, {pages: resp})
            @$el.find(".cmex-admin-page-list a[data-id=#{@currentPage.get('id')}]").parent().addClass 'active'

        updatePageForm: ->
            @form = new Backbone.Form {model: @currentPage}
            @form.render()
            @$el.find('.cmex-admin-property-column').html('').append(@form.el)

        buildUI: ->
            @$el.html pagemantemplate
            @updatePageForm()
            @collection.fetch {success: _.bind @updatePageList, @}