/** @type {import('tailwindcss').Config} */
export default {
  content: [ // Configure the template paths.
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    'node_modules/preline/dist/*.js', // Configuring preline framework for tailwind css.
  ],
  darkMode: 'class', // Turning the dark mode off.
  theme: {
    extend: {},
  },
  plugins: [
    require('preline/plugin'), // Configuring preline framework for tailwind css.
  ],
}