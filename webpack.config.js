var Encore = require('@symfony/webpack-encore');

Encore
    // IO
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // EntryPoint
    .addEntry('main', './assets/css/main.css')
    .addEntry('app', './assets/js/app.js')
    .copyFiles({
        from: './assets/images'
    })

    // Config
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()

;

module.exports = Encore.getWebpackConfig();
