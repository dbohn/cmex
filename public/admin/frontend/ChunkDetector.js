// Generated by CoffeeScript 1.6.2
(function() {
  define(['jquery', 'underscore', 'backbone'], function($, _, Backbone) {
    var ChunkDetector;

    return ChunkDetector = (function() {
      function ChunkDetector() {}

      ChunkDetector.prototype.chunkQuery = '[data-cmex-type]';

      ChunkDetector.prototype.detect = function() {
        var chunks, textBlocks;

        chunks = $(this.chunkQuery);
        textBlocks = chunks.filter('[typeof="text.html"]');
        require(['editors/InlineEditor'], function(InlineEditor) {
          _.each(textBlocks, function(block) {
            var bl;

            bl = new InlineEditor(block);
          });
        });
        return true;
      };

      return ChunkDetector;

    })();
  });

}).call(this);
