require.config({
    paths: {
        'jquery': '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min',
        'underscore': 'dependencies/underscore-amd-min',
        'backbone': 'dependencies/backbone-amd-min'
    },

    shim: {
        'backbone': {
            deps: ['underscore', 'jquery']
        }
    }
});

require(['app'], function(App) {
    App.initialize();
});