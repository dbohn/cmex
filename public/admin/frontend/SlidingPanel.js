// Generated by CoffeeScript 1.6.2
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['jquery', 'underscore', 'backbone'], function($, _, Backbone) {
    var SlidingPanel, _ref;

    return SlidingPanel = (function(_super) {
      __extends(SlidingPanel, _super);

      function SlidingPanel() {
        _ref = SlidingPanel.__super__.constructor.apply(this, arguments);
        return _ref;
      }

      SlidingPanel.prototype.tagName = 'div';

      SlidingPanel.prototype.className = 'cmex-admin-sliding-panel';

      SlidingPanel.prototype.toolbar = null;

      SlidingPanel.prototype.created = false;

      SlidingPanel.prototype.visible = false;

      SlidingPanel.prototype.initialize = function(options) {
        if (options.toolbar != null) {
          this.listenTo(options.toolbar, 'clickToolbarShow', this.toolbarshow);
          return this.listenTo(options.toolbar, 'clickToolbarHide', this.toolbarhide);
        }
      };

      SlidingPanel.prototype.buildUI = function() {
        return this.$el.html('Sliding Panel');
      };

      SlidingPanel.prototype.render = function() {
        if (this.created === false) {
          this.buildUI();
          if ($.type(this.$el.parent().prop('tagName')) === "undefined") {
            $('body').append(this.$el);
          }
          this.created = true;
          return this.visible = true;
        } else {
          this.visible = !this.visible;
          return this.$el.toggleClass('cmex-admin-sliding-panel-hidden');
        }
      };

      SlidingPanel.prototype.toolbarshow = function() {
        if (this.visible) {
          return this.$el.removeClass('cmex-admin-sliding-panel-hidden');
        }
      };

      SlidingPanel.prototype.toolbarhide = function() {
        if (this.visible) {
          return this.$el.addClass('cmex-admin-sliding-panel-hidden');
        }
      };

      return SlidingPanel;

    })(Backbone.View);
  });

}).call(this);