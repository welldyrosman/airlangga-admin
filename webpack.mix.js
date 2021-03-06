const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.browserSync('127.0.0.1:9000');
mix.js('resources/js/app.js', 'public/js')
.js('resources/js/app/template.js', 'public/js/app')
.js('resources/js/app/newbooktravelEvent.js', 'public/js/app')
.js('resources/js/app/actionNewbook.js', 'public/js/app')
.postCss('resources/css/app.css', 'public/css', [
        //
])
