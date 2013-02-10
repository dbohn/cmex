
(function(jQuery, undefined) {
    'use strict';

    jQuery.widget('Create.ValueEditor', {
        options: {
            disabled: false,
            vie: null
        },

        enable: function()
        {
            console.log('Editor enabled');
        },

        disable: function()
        {
            console.log('Editor disabled');
        },

        _create: function()
        {
            this._registerWidget();
            this._initialize();

            if (_.isFunction(this.options.decorate) && _.isFunction(this.options.decorateParams)) {
                // TRICKY: we can't use this.options.decorateParams()'s 'propertyName'
                // parameter just yet, because it will only be available after this
                // object has been created, but we're currently in the constructor!
                // Hence we have to duplicate part of its logic here.
                this.options.decorate(this.options.decorateParams(null, {
                propertyName: this.options.property,
                propertyEditor: this,
                propertyElement: this.element,
                // Deprecated.
                editor: this,
                predicate: this.options.property,
                element: this.element
                }));
            }
        },

        _init: function()
        {
            if(this.options.disabled) {
                this.disable();
                return;
            }
            this.enable();
        },

        _initialize: function()
        {
            var self = this;
            this.element.on('focus', function() {
                if(self.options.disabled) {
                    return;
                }
                self.options.activated();
            });

            this.element.on('blur', function() {
                if(self.options.disabled) {
                    return;
                }
                self.options.deactivated();
            });
        },
        // used to register the property editor widget name with the DOM element
        _registerWidget: function () {
            this.element.data("createWidgetName", this.widgetName);
        }
    })
})