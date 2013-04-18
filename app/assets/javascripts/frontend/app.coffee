define ['jquery', 'underscore', 'backbone', 'toolbar', 'pageman', 'ChunkDetector'], ($, _, Backbone, ToolbarView, PageMan, ChunkDetector) ->
    initialize = ->
        $ ->
            tools = new ToolbarView {page: cmexPage}
            tools.render()

            $('body').append tools.el

            pageman = new PageMan {toolbar: tools, page: cmexPage}

            # Load chunk detector, which scans the page for
            # existing chunks and loads the corresponding editors
            chunkdetector = new ChunkDetector()
            chunkdetector.detect()
            return
        return

    return {initialize: initialize}