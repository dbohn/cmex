var File = Backbone.Model.extend({
    defaults: {
        filename: "New File",
        type: "file",
        
    }
});

var Directory = Backbone.Collection.extend({model: File});

var Thumbnail = Backbone.View.extend({
    tagName: "li",

    className: "span2",

    initialize: function() {
        this.listenTo(this.model, "change", this.render);
    },

    render: function() {
        var tmplate = _.template($("#thumbnail_template").html);

        this.$el.html(tmplate({filename: this.model.filename}));
    }
});