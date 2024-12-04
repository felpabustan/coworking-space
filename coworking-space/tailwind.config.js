/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [  //CONFIGURE CORRECTLY
    // './**/**/*.php',
    './**/*.{php,js}',    
    './*.php',
  ],
  darkMode: 'class', // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'golden-grass': {
          '50': '#fcf9ea',
          '100': '#f8f1c9',
          '200': '#f2e196',
          '300': '#eac95a',
          '400': '#e1ad21',
          '500': '#d39a1f',
          '600': '#b67818',
          '700': '#915617',
          '800': '#79451a',
          '900': '#673b1c',
          '950': '#3c1e0c',
        },
      },
    },
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
        sm: '2rem',
        lg: '4rem',
        xl: '5rem',
      },
    },
    fontFamily: {
      display: ['Commissioner', 'sans-serif'],
      body:  ['PT Serif', 'serif'],
      sans: ['Commissioner', 'sans-serif'],
      serif: ['PT Serif', 'serif'],
    },
  },
  variants: {
  },
  plugins: [
    // require('@tailwindcss/line-clamp'),
    require('@tailwindcss/typography'),
  ],
}