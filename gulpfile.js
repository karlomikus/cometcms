var elixir = require('laravel-elixir');

elixir.config.js.browserify.watchify = {
    enabled: true,
    options: {
        poll: true
    }
}

elixir(function (mix) {
    //mix
        // .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap')
        // .copy('node_modules/bootstrap-sass/assets/stylesheets', 'resources/assets/sass/admin/bootstrap')
        // .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js/admin/lib')
        // .copy('node_modules/Select2/dist/js/select2.full.min.js', 'public/js/admin/lib')

        // Compile SASS
        //.sass(['admin/app-admin.scss'], 'public/css/admin/main.css')

        // Global admin dependencies
        // .scripts([
        //     'jquery/dist/jquery.js',
        //     'moment/moment.js',
        //     'jquery-validation/dist/jquery.validate.js',
        //     'bootstrap-sass/assets/javascripts/bootstrap.js'
        // ], 'public/js/admin/dependencies.js', 'node_modules')

        // Global admin scripts
        // .scripts([
        //     'admin.js'
        // ], 'public/js/admin/main.js')

        // Admin modules
        // .browserify('matches.js', 'public/js/admin/modules/matches.js', 'resources/assets/js/modules')
        // .browserify('games.js', 'public/js/admin/modules/games.js', 'resources/assets/js/modules')
        // .browserify('teams.js', 'public/js/admin/modules/teams.js', 'resources/assets/js/modules')
        // .browserify('dashboard.js', 'public/js/admin/modules/dashboard.js', 'resources/assets/js/modules')
        // .browserify('posts.js', 'public/js/admin/modules/posts.js', 'resources/assets/js/modules');
    mix

        // Include bootstrap fonts
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap')
        // Include bootstrap for sass compiling
        .copy('node_modules/bootstrap-sass/assets/stylesheets', 'resources/assets/sass/admin/bootstrap')
        // Include simplemde
        .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js/admin/lib')
        // Include select 2 dropdowns
        .copy('node_modules/Select2/dist/js/select2.full.min.js', 'public/js/admin/lib')

        // Compile administration SASS sytylesheet
        .sass(['admin/app-admin.scss'], 'public/css/admin/main.css')

        // Combine admin scripts
        .scripts([
            'jquery/dist/jquery.js',
            'jquery-validation/dist/jquery.validate.js',
            'bootstrap-sass/assets/javascripts/bootstrap.js'
        ], 'public/js/admin/dependencies.js', 'node_modules')

        // Compile admin modules
        .browserify('teams.js', 'public/js/admin/modules/teams.js', 'resources/assets/js/modules');
});