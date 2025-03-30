module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      // tailwind.config.js
      colors: {
        'film-red': '#E50914',
        'film-gray': '#141414',
        'film-accent': '#E50914'
      }
    

    },
  },
  plugins: [],
}