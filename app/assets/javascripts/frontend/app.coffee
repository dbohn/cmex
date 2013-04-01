define ['jquery', 'underscore', 'backbone', 'toolbar', 'pageman', 'editors/InlineEditor'], ($, _, Backbone, ToolbarView, PageMan, InlineEditor) ->
    initialize = ->
        $ ->
            tools = new ToolbarView {page: cmexPage}
            tools.render()

            $('body').append tools.el

            pageman = new PageMan {toolbar: tools, page: cmexPage}

            chunks = $ '[about]'
            textblocks = chunks.filter '[typeof="text.html"]'

            _.each textblocks, (block) ->
                bl = new InlineEditor(block)
                return
            return
        return

    return {initialize: initialize}