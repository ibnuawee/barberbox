const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Tambahkan baris ini jika menggunakan Vue.js
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps();

if (mix.inProduction()) {
   mix.version();
  }