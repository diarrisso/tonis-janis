/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './assets/src/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'kiwi-green': '#8BC34A',
        'kiwi-dark': '#689F38',
        'kiwi-light': '#AED581',
        'kiwi-accent': '#9CCC65',
        'earth-brown': '#5D4037',
        'sand-beige': '#E8E0D5',
        'cream': '#FAF8F5',
        'charcoal': '#2D2D2D',
      },
      fontFamily: {
        heading: ['Playfair Display', 'Georgia', 'serif'],
        body: ['Source Sans 3', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
      },
      borderRadius: {
        'xl': '1rem',
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease forwards',
        'slide-up': 'slideUp 0.6s ease forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
};
