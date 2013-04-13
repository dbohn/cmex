define ['jquery', 'underscore', 'backbone'], ($, _, Backbone) ->
    class SlidingPanel extends Backbone.View
        tagName: 'div'
        className: 'cmex-admin-sliding-panel'
        toolbar: null
        created: false
        visible: false
        initialize: (options) ->
            if options.toolbar?
                @listenTo options.toolbar, 'clickToolbarShow', @toolbarshow
                @listenTo options.toolbar, 'clickToolbarHide', @toolbarhide

        buildUI: ->
            @$el.html 'Sliding Panel'

        render: ->
            if @created is false
                @buildUI()

                if $.type(@$el.parent().prop('tagName')) is "undefined"
                    $('body').append @$el

                @created = true
                @visible = true
            else
                @visible = !@visible
                @$el.toggleClass 'cmex-admin-sliding-panel-hidden'

        toolbarshow: ->
            @$el.removeClass 'cmex-admin-sliding-panel-hidden' if @visible

        toolbarhide: ->
            @$el.addClass 'cmex-admin-sliding-panel-hidden' if @visible
