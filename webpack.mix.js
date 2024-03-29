let mix = require('laravel-mix')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application.
 |
 */

/*
 * npm i jquery --save or yarn add jquery
 * commentout below code to enable juery autoloading
 * this allows you to use $() in all files.
 */

// mix.autoload({
//     jquery: ['$', 'window.jQuery', 'jQuery']
// });

//====set alias for isotope
mix.webpackConfig({
    resolve: {
        alias: {
            'masonry': 'masonry-layout',
            'isotope': 'isotope-layout',
            // custom aliases for easy reference
            'src': path.resolve(__dirname, 'resources/'),
            'resources': path.resolve(__dirname, 'resources/'),
            'components': path.resolve(__dirname, 'resources/components/'),
            'pages': path.resolve(__dirname, 'resources/components/pages/'),
            'img': path.resolve(__dirname, 'resources/img/'),
        }
    },
    // https://github.com/JeffreyWay/laravel-mix/issues/936#issuecomment-331418769
    output: {
    publicPath:'./',
        chunkFilename: mix.inProduction() ? 'js/[name].[chunkhash].js' : 'js/[name].js'
    },
    
    //Added by JR
    // module: {
    //     rules: [
    //         {
    //             test: /\.s[a|c]ss$/,
    //             loader: 'sass-loader'
    //         }
    //     ]
    // }

});

// Setup Autoprefixer
mix.options({
    postCss: [
        require('autoprefixer')(),
        /**
         * Automatically create rtl css
         * applies styles based on the 'dir' attribute on <html></html>
         * eg: <html dir="ltr"></html>
         * experimental, broken
         */
        // require('postcss-rtl')()
    ]
})

// ===public path
// mix.setPublicPath('public/')


// ===compile our main.js file
mix.js('resources/main.js', 'public/')
    // Add any additional vendor modules that need to be cached
    // remove any unused libraries in the array as they will be included in the vendor bundle
    .extract(['vue', 'bootstrap-vue', 'animejs', 'axios', 'vue-echarts-v3/src/full.js','vue2-dropzone'])


//
// mix.sass('resources/sass/bootstrap/bootstrap.scss', 'public/css');

// mix.js('resources/js/app.js', 'public/js');


// We strongly recommend running vuejs projects on a domain or sub-domain but if you really need to run it in a sub-folder, please change below path
// mix.setResourceRoot('/')

// Disable all OS notifications
// mix.disableNotifications()


// Disable all Success notifications
// mix.disableSuccessNotifications()
