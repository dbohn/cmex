define ['jquery', 'underscore', 'backbone', 'text!templates/toolbar.html'], ($, _, Backbone, toolbartemplate) ->
    class ToolbarView extends Backbone.View
        tagName: 'div'
        id: 'cmex-admin-toolbar-container',

        events:
            'click a.cmex-admin-toolbar-toggle': 'toggle'
            'click .cmex-admin-pagebar>p>a': 'togglePageMan'

        render: ->
            data =
                name: 'Benutzer'
                title: @options.page.title
            @$el.append (_.template toolbartemplate, data)

        toggle: (event) ->
            if @$el.hasClass 'cmex-admin-toolbar-hidden'
                @trigger 'clickToolbarShow', event
                @$el.removeClass 'cmex-admin-toolbar-hidden'
            else
                @trigger 'clickToolbarHide', event
                @$el.addClass 'cmex-admin-toolbar-hidden'

            event.preventDefault()

        togglePageMan: (event) ->
            @.trigger 'clickToolbarPageButton', event
            event.preventDefault()