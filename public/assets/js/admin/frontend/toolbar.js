// Generated by CoffeeScript 1.6.2
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['jquery', 'underscore', 'backbone', 'text!templates/toolbar.html'], function($, _, Backbone, toolbartemplate) {
    var ToolbarView, _ref;

    return ToolbarView = (function(_super) {
      __extends(ToolbarView, _super);

      function ToolbarView() {
        _ref = ToolbarView.__super__.constructor.apply(this, arguments);
        return _ref;
      }

      ToolbarView.prototype.tagName = 'div';

      ToolbarView.prototype.id = 'cmex-admin-toolbar-container';

      ToolbarView.prototype.events = {
        'click a.cmex-admin-toolbar-toggle': 'toggle',
        'click .cmex-admin-pagebar>p>a': 'togglePageMan'
      };

      ToolbarView.prototype.render = function() {
        var data;

        data = {
          name: 'Benutzer',
          title: this.options.page.title
        };
        return this.$el.append(_.template(toolbartemplate, data));
      };

      ToolbarView.prototype.toggle = function(event) {
        if (this.$el.hasClass('cmex-admin-toolbar-hidden')) {
          this.trigger('clickToolbarShow', event);
          this.$el.removeClass('cmex-admin-toolbar-hidden');
        } else {
          this.trigger('clickToolbarHide', event);
          this.$el.addClass('cmex-admin-toolbar-hidden');
        }
        return event.preventDefault();
      };

      ToolbarView.prototype.togglePageMan = function(event) {
        this.trigger('clickToolbarPageButton', event);
        return event.preventDefault();
      };

      return ToolbarView;

    })(Backbone.View);
  });

}).call(this);