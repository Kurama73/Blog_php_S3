/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/*.php"],
  theme: {
    extend: {
      fontFamily: {
        ubuntu: ['"Ubuntu Sans"', "sans-serif"],
      },

      colors: {
        'primary': {
          '50': '#f3f5fb',
          '100': '#e3eaf6',
          '200': '#cddbf0',
          '300': '#abc2e5',
          '400': '#83a3d7',
          '500': '#6685cb',
          '600': '#4e69bc',
          '700': '#485bad',
          '800': '#3f4d8e',
          '900': '#374271',
          '950': '#252b46',
        },
      }
    },
  },
  plugins: [],
}

