let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/style.green.scss', 'public/css')
   .scripts([
   		'resources/assets/js/validations/addLoan.js',
   		'resources/assets/js/validations/addBorrower.js',
   		'resources/assets/js/validations/addCompany.js'
   	], 'public/js/all.js');

// Versioning will only run in Production Mode
if (mix.inProduction()) {
    mix.version();
}
