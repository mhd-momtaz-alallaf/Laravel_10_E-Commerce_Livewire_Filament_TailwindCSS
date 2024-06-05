/** @type {import('tailwindcss').Config} */
export default {
  content: [ // Configure the template paths.
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    'node_modules/preline/dist/*.js', // configuring preline framework for tailwind css.
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('preline/plugin'), // configuring preline framework for tailwind css.
  ],
}

