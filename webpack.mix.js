const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        hmrOptions: {
            host: 'localhost',
            port: 5176
        }
    });

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
