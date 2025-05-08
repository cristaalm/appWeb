const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')
const { parseColor } = require('tailwindcss/lib/util/color')

/** Convierte HEX a RGB */
const toRGB = value => {
  return parseColor(value).color.join(' ')
}

/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    './resources/js/**/*.{vue,js,ts,jsx,tsx}',
    './src/**/*.{vue,js,jsx,ts}',
  ],
  darkMode: 'class',
  theme: {
    container: {
      screens: {
        '2xl': '1320px',
      },
      center: true,
    },
    extend: {
      animation: {
        'scale-in': 'scale-in 0.7s cubic-bezier(0.4,0,0.2,1) both',
        wave: 'wave 1.5s infinite',
        scaleDown: 'scaleDown .5s forwards',
        scaleUp: 'scaleUp 1s forwards',
      },
      keyframes: {
        'scale-in': {
          '0%': { transform: 'scale(3.5)' },
          '100%': { transform: 'scale(1)' },
        },
        wave: {
          '0%, 100%': { transform: 'rotate(-10deg)' },
          '50%': { transform: 'rotate(10deg)' },
        },
        scaleDown: {
          '0%': { transform: 'scale(1)' },
          '100%': { transform: 'scale(0)', display: 'none' },
        },
        scaleUp: {
          '0%': { transform: 'scale(0)' },
          '49%': { transform: 'scale(0)', display: 'none' },
          '50%': { transform: 'scale(0)', display: 'block' },
          '100%': { transform: 'scale(1)' },
        },
      },
      screens: {
        '3xl': '1600px',
      },
      colors: {
        theme: {
          1: 'rgb(var(--color-theme-1) / <alpha-value>)',
          2: 'rgb(var(--color-theme-2) / <alpha-value>)',
        },
        primary: 'rgb(var(--color-primary) / <alpha-value>)',
        secondary: 'rgb(var(--color-secondary) / <alpha-value>)',
        success: 'rgb(var(--color-success) / <alpha-value>)',
        info: 'rgb(var(--color-info) / <alpha-value>)',
        warning: 'rgb(var(--color-warning) / <alpha-value>)',
        pending: 'rgb(var(--color-pending) / <alpha-value>)',
        danger: 'rgb(var(--color-danger) / <alpha-value>)',
        light: 'rgb(var(--color-light) / <alpha-value>)',
        dark: 'rgb(var(--color-dark) / <alpha-value>)',
        darkmode: {
          50: 'rgb(var(--color-darkmode-50) / <alpha-value>)',
          100: 'rgb(var(--color-darkmode-100) / <alpha-value>)',
          200: 'rgb(var(--color-darkmode-200) / <alpha-value>)',
          300: 'rgb(var(--color-darkmode-300) / <alpha-value>)',
          400: 'rgb(var(--color-darkmode-400) / <alpha-value>)',
          500: 'rgb(var(--color-darkmode-500) / <alpha-value>)',
          600: 'rgb(var(--color-darkmode-600) / <alpha-value>)',
          700: 'rgb(var(--color-darkmode-700) / <alpha-value>)',
          800: 'rgb(var(--color-darkmode-800) / <alpha-value>)',
          900: 'rgb(var(--color-darkmode-900) / <alpha-value>)',
        },
        footerColor: '#F6F6EB',
      },
      fontFamily: {
        'public-sans': ['Public Sans'],
        'dm-sans': ['DM Sans'],
      },
    },
  },
  plugins: [
    plugin(function({ addUtilities }) {
      addUtilities({
        '.scrollbar-aqua': {
          'scrollbar-color': '#4ca4a5 #21797a',
          'scrollbar-width': 'thin',
        },
        '.scrollbar-aqua::-webkit-scrollbar': {
          'width': '8px',
          'background': '#21797a',
        },
        '.scrollbar-aqua::-webkit-scrollbar-thumb': {
          'background': '#4ca4a5',
          'border-radius': '8px',
        },
      });
    }),
    // require('@tailwindcss/forms'),
    plugin(function ({ addBase, matchUtilities }) {
      addBase({
        // Default colors
        ':root': {
          '--color-theme-1': toRGB('#21797a'),
          '--color-theme-2': toRGB('#4ca4a5'),
          '--color-theme-3': toRGB('#81c784'),
          '--v-theme-primary': toRGB('#03045e'),
          '--v-theme-secondary': toRGB(colors.slate['200']),
          '--v-theme-success': toRGB(colors.teal['600']),
          '--v-theme-info': toRGB(colors.cyan['600']),
          '--v-theme-warning': toRGB(colors.yellow['600']),
          '--v-theme-pending': toRGB(colors.orange['700']),
          '--v-theme-danger': toRGB(colors.red['700']),
          '--color-light': toRGB(colors.slate['100']),
          '--color-dark': toRGB(colors.slate['800']), 
        },

        // Default dark-mode colors
        '.dark': {
          '--color-primary': toRGB('#23263a'), // Fondo principal
          '--color-darkmode-50': '224 230 237', // Texto principal (gris muy claro)
          '--color-darkmode-100': '180 190 210', // Texto secundario
          '--color-darkmode-200': '120 130 160', // Bordes/acento
          '--color-darkmode-300': '60 68 100', // Tarjetas
          '--color-darkmode-400': '41 45 66', // Navbar, sidebar
          '--color-darkmode-500': '36 39 63', // Fondo de tarjetas
          '--color-darkmode-600': '33 36 58', // Fondo navbar/sidebar
          '--color-darkmode-700': '29 32 52', // Fondo modal
          '--color-darkmode-800': '22 24 38', // Fondo profundo
          '--color-darkmode-900': '15 17 28', // Fondo más oscuro
        },
      })
    }),
  ],
}

