define ['underscore', 'backbone', 'Page'], (_, Backbone, Page) ->
    class PageCollection extends Backbone.Collection
        url: 'admin/frontend/pages'
        model: Page