const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |  mix.js('resources/assets/js/app-landing.js', 'public/js/app-landing.js')

 */
   mix.js('resources/assets/js/app.js', 'public/js')
	.js('resources/assets/js/app-landing.js', 'public/js/app-landing.js')
   .sourceMaps()
   .combine([
       'resources/assets/css/bootstrap.min.css',
       'resources/assets/css/font-awesome.min.css',
       'resources/assets/css/ionicons.min.css',
       'node_modules/admin-lte/dist/css/AdminLTE.min.css',
       'node_modules/admin-lte/dist/css/skins/_all-skins.css',
       'node_modules/icheck/skins/square/blue.css'
   ], 'public/css/all.css')
   .combine([
       'resources/assets/css/bootstrap.min.css',
       'resources/assets/css/pratt_landing.min.css'
   ], 'public/css/all-landing.css')
   // PACKAGE (ADMINLTE-LARAVEL) RESOURCES
   .copy('resources/assets/css/expedientes.css','public/css/expedientes.css')
   .copy('resources/assets/css/login.css','public/css/login.css')
   .copy('resources/assets/img/*.*','public/img/')
   .copy('resources/assets/css/buttons.bootstrap.min.css', 'public/css/buttons.bootstrap.min.css')
   .copy('resources/assets/css/buttons.dataTables.min.css', 'public/css/buttons.dataTables.min.css')
   .copy('resources/assets/js/jquery.dataTables.min.js', 'public/js/jquery.dataTables.min.js')
   .copy('resources/assets/js/dataTables.buttons.min.js', 'public/js/dataTables.buttons.min.js')
   .copy('resources/assets/js/buttons.print.js', 'public/js/buttons.print.js')
   .copy('resources/assets/js/buttons.flash.min.js', 'public/js/buttons.flash.min.js')
   .copy('resources/assets/js/jszip.min.js', 'public/js/jszip.min.js')
   .copy('resources/assets/js/pdfmake.min.js', 'public/js/pdfmake.min.js')
   .copy('resources/assets/js/vfs_fonts.js', 'public/js/vfs_fonts.js')
   .copy('resources/assets/js/buttons.html5.min.js', 'public/js/buttons.html5.min.js')

   //VENDOR RESOURCES
   .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
   .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
   .copy('node_modules/bootstrap/fonts/*.*','public/fonts/')
   .copy('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
   .copy('node_modules/admin-lte/dist/img','public/img')
   .copy('node_modules/admin-lte/plugins','public/plugins')
   .copy('node_modules/icheck/skins/square/blue.png','public/css')
   .copy('node_modules/icheck/skins/square/blue@2x.png','public/css');

if (mix.config.inProduction) {
  mix.version();
  mix.minify();
}
