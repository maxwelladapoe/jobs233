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
mix.disableSuccessNotifications();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');




// mix.js('resources/js/app.js', 'public/js')
//     .extract([
//         'vue',
//         'axios',
//         'bootstrap-vue',
//         'vue-infinite-loading',
//         'vee-validate',
//         'pusher-js',
//         'laravel-echo',
//         'vue-timeago',
//         'vue-router',
//         'vue-meta',
//         'vuex',
//         'vuex-persistedstate',
//         'vue-i18n',
//         'vue-pluralize',
//         'lodash',
//     ])
//     .sass('resources/sass/vendor.scss', './public/css/vendor.css')
//     .sass('resources/sass/app.scss', 'public/css')
//     .version();
// ;

