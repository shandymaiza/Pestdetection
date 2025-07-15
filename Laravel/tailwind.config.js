/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Warna tema hijau baru
        'hijau1': '#004225',
        'hijau2': '#4CAF50',
        'hijau3': '#8BC34A',
        'hijau4': '#C8E6C9',
      
        // Pertahankan warna lama sebagai fallback
        'color-coklat1': '#6D4C41',
        'color-coklat2': '#8D6E63',
        'color-biru1': '#38B9FA',
        'color-biru2': '#F6F9FF',
        'color-abu1': '#E9E8E8',
      }
    },
  },
  plugins: [
    require('daisyui'),
  ],
}