/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
  ],
  theme: {
    extend: {
      colors: {
        'nav-black': '#1a1c23',
        'dropdown-black': '#24262d'
      }
    },
  },
  darkMode: 'class',
  plugins: [],
}

