/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './site/**/*.php',
    './site/**/*.js',
    './content/**/*.txt'
  ],
  theme: {
    extend: {
      colors: {
        // Custom colors for dark mode if needed
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

