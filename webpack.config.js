var Encore = require('@symfony/webpack-encore');

Encore
// IO
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // EntryPoint
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
    .autoProvidejQuery()

;

module.exports = Encore.getWebpackConfig();
