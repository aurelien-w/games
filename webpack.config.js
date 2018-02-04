var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/main.js and public/build/main.css
    .addEntry('app', './assets/js/app.js')

    // this creates a 'vendor.js' file with jquery and the bootstrap JS module
    // these modules will *not* be included in page1.js or page2.js anymore
    .createSharedEntry('vendor', [
        'jquery',
        'bootstrap',
        'bootstrap/scss/bootstrap.scss'
    ])

    // allow sass/scss files to be processed
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()
;

module.exports = Encore.getWebpackConfig();
