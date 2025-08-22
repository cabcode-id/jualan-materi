import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/livewire/**/*.blade.php',      // komponen Livewire
    './storage/framework/views/*.php',

    './resources/views/**/*.blade.php',      // Blade
    './resources/**/*.php',                  // Volt / komponen .php
    './resources/**/*.js',                   // JS modules
    './resources/**/*.vue',                  // Vue SFC
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [forms],
}
