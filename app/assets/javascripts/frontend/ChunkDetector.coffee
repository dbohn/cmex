define ['jquery', 'underscore', 'backbone'], ($, _, Backbone) ->
    class ChunkDetector
        # This is the query used to detect the chunks in the DOM
        chunkQuery: '[data-cmex-type]',
        detect: ->
            chunks = $ @chunkQuery
            textBlocks = chunks.filter '[typeof="text.html"]'

            require ['editors/InlineEditor'], (InlineEditor) ->
                _.each textBlocks, (block) ->
                    bl = new InlineEditor(block)
                    return
                return
            true