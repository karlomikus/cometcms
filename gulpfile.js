var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.less('app.less');
});

elixir(function(mix) {
    mix.scripts([
        'angular/angular.min.js'
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
});