const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').js('resources/js/js/ckeditor.js','public/js/ckeditor')
    .js('resources/js/js/tiny.js','public/js/tiny').sass('resources/sass/css/tinymce.scss','public/css/tiny')
   .sass('resources/sass/app.scss', 'public/css').version();
