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

mix.js('resources/js/jquery.js', 'public/js')
    .js('node_modules/admin-lte/dist/js/adminlte.js', 'public/js')
    .postCss('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css')
    .postCss('node_modules/admin-lte/dist/css/adminlte.min.css', 'public/css')
    .postCss('resources/css/dashboard_css/Dashboard.css', 'public/css')
    .postCss('resources/css/login_css/Login.css', 'public/css')
    .postCss('resources/css/pages_css/Pages.css', 'public/css')
    .postCss('node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css', 'public/css/admin-lte-free')
