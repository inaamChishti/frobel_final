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

mix.js('resources/js/app.js', 'public/js')
    // .sass('resources/sass/app.scss', 'public/css')

    mix.styles([
        'resources/assets/css/bootstrap.css',
        'resources/assets/css/appwork.css',
        'resources/assets/css/theme-corporate.css',
        'resources/assets/css/colors.css',
        'resources/assets/css/uikit.css',
        'resources/assets/css/demo.css',
        'resources/assets/css/perfect-scrollbar.css'

    ], 'public/css/admin.css')


    mix.scripts([
        'resources/assets/js/bootstrap.js',
        'resources/assets/js/pace.js',
        'resources/assets/js/material-ripple.js',
        'resources/assets/js/layout-helpers.js',
        'resources/assets/js/polyfills.js',
        'resources/assets/js/popper.js',
        'resources/assets/js/sidenav.js',
        // 'resources/assets/js/perfect-scrollbar.js',,
        'resources/assets/js/demo.js',

    ], 'public/js/admin.js')

    // .sourceMaps();
