define([
    'jquery', 
    'underscore', 
    'backbone', // Pull in the Collection module from above 
    //'collections/Directory',
    'views/FileView'
    ], 
    function($, _, Backbone, FileView){ 
        var DirectoryView = Backbone.View.extend({ 
            el: $(".thumbnails"), 

            fileviews: [],

            initialize: function(){ 
                // this.collection = new Directory(); 
                //this.collection.add({ name: “Testdatei”}); 
                // Compile the template using Underscores micro-templating
                //console.log(this.collection);
                _.each(this.collection.models, function(model) {
                    var fview = new FileView({el: this.$el, model: model});
                    fview.parentView = this;
                    fview.render();
                    this.fileviews.push(fview);
                }, this);
                //console.log(this.fileviews);
            }
        });

        return DirectoryView; 
    });