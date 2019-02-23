var Encore = require('@symfony/webpack-encore');

Encore
// IO
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // EntryPoint
    .addEntry('app', './assets/js/app.js') // Muuri drag enabled
    .addEntry('app_offline', './assets/js/app_offline.js') // Muuri drag disabled
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
    .autoProvidejQuery()

;

module.exports = Encore.getWebpackConfig();
