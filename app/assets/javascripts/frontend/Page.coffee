define ['underscore', 'backbone'], (_, Backbone) ->
    class TemplateModel extends Backbone.Model
        toString: ->
            return @get('name')

    class TemplateCollection extends Backbone.Collection
        url: 'admin/frontend/template-list'
        model: TemplateModel

    class Page extends Backbone.Model
        urlRoot: 'admin/frontend/page',
        schema:
            title: {type: 'Text', title: 'Seitentitel'}
            identifier: 'Text'
            template: {type: 'Select', options: new TemplateCollection()}