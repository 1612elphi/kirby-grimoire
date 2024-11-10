/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './site/**/*.php',
    './site/**/*.js',
    './content/**/*.txt'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

