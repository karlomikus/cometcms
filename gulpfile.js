var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap')
        .copy('node_modules/bootstrap-sass/assets/stylesheets', 'resources/assets/sass/admin/bootstrap')
        .sass(['admin/app-admin.scss'], 'public/css/admin/main.css')
        .scripts([
            'jquery/dist/jquery.js',
            'moment/moment.js',
            'jquery-validation/dist/jquery.validate.js',
            'knockout/build/output/knockout-latest.debug.js',
            'bootstrap-sass/assets/javascripts/bootstrap.js'
        ], 'public/js/admin/dependencies.js', 'node_modules')
        .scripts([
            'admin.js'
        ], 'public/js/admin/main.js');
});