import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Ubah dari `false` ke 'class' atau 'media' jika butuh dark mode
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue", // Tambahkan jika menggunakan Vue
    "./storage/framework/views/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    forms(),
    // Tambahkan plugin lain jika diperlukan
    // require('@tailwindcss/typography'),
    // require('@tailwindcss/aspect-ratio'),
  ],
  corePlugins: {
    preflight: true, // Pastikan true untuk reset CSS
  }
}