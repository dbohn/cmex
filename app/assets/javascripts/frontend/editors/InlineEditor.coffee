define ['jquery', 'underscore', 'backbone'], ($, _, Backbone) ->
    CKEDITOR.disableAutoInline = true;
    class InlineEditor
        constructor: (@chunkElement) ->
            chunk = $ chunkElement
            chunk.attr 'contenteditable', 'true'
            CKEDITOR.inline chunkElement