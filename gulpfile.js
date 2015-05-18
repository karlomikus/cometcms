var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('app-admin.scss');
});

elixir(function(mix) {
    mix.scripts([
        'knockout/build/output/knockout-latest.debug.js',
        'bootstrap/dist/js/bootstrap.js'
    ],
        'public/js/dependencies.js',
        'node_modules'
    )
    .scripts([
        'main.js'
    ],
        'public/js/main.js',
        'resources/js/'
    );

    mix.styles([
        'bootstrap/dist/css/bootstrap.css'
    ],
        'public/css/dependencies.css',
        'node_modules'
    );
});