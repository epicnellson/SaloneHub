/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1E3A8A',
        accent: '#F59E0B',
        'accent-light': '#FBBF24',
      },
      backdropBlur: {
        xs: '2px',
      },
    },
  },
  plugins: [],
}

