require.config {
    paths:
        'jquery': 'dependencies/jquery-1.9.1.min'
        'underscore': 'dependencies/underscore-amd-min'
        'backbone': 'dependencies/backbone-amd-min'

    shim:
        'backbone':
            deps: ['underscore', 'jquery']
        'toolbar':
            deps: ['backbone']
}

require ['app'], (App) ->
    App.initialize()