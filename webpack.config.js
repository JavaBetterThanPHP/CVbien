var Encore = require('@symfony/webpack-encore');

Encore
    // IO
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // EntryPoint
    .addEntry('main', './assets/css/main.css')

    // Config
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()

;

module.exports = Encore.getWebpackConfig();
