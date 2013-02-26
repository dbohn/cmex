define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/thumbnail_template.html'],
    function($, _, Backbone, thumbTemplate)
    {
        var FileView = Backbone.View.extend({

            events: {
                "click .thumbnail": "showPreview"
            },

            render: function() {
                var data = {filename: this.model.get('filename')};
                var compiledTemplate = _.template(thumbTemplate, data);

                this.$el.append(compiledTemplate);
            },

            showPreview: function(event) {
                if($(event.currentTarget).attr('rel') == this.model.get('filename')) {
                    console.log(this.model.get('filename'));
                }
            }
        });

        return FileView;
    });