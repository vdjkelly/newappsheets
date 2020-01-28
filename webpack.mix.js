const mix = require('laravel-mix');
mix.webpackConfig({ node: { fs: 'empty' }})
require('dotenv').config(); 


let webpack = require('webpack')

let dotenvplugin = new webpack.DefinePlugin({
    'process.env': {
        APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
        NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development'),
        API_KEY_GOOGLE: JSON.stringify(process.env.API_KEY_GOOGLE || ''),
        CLIENT_ID: JSON.stringify(process.env.CLIENT_ID || ''),
        SCOPE_GOOGLE: JSON.stringify(process.env.SCOPE_GOOGLE || ''),

    }
})

mix.webpackConfig({
    plugins: [
        dotenvplugin,
    ]
})
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
    .sass('resources/sass/app.scss', 'public/css');
    
