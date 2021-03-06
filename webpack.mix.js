const { mix } = require('laravel-mix');

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

mix.sass('resources/assets/sass/all.scss', 'public/assets/css')
   .sass('resources/assets/sass/issue.scss', 'public/assets/css')
   .options({
      processCssUrls: false
   })
   .copy('resources/assets/images/', 'public/assets/images/', false); // Don't flatten!
