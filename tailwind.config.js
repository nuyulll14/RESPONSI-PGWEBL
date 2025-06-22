/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
    ],
    theme: {
      extend: {
        fontFamily: {
          // Tambahkan font yang akan kita gunakan
          sans: ['Inter', 'sans-serif'],
          display: ['Poppins', 'sans-serif'],
        },
        colors: {
          // Definisikan palet warna custom kita
          primary: '#F1F5F9', // slate-100
          secondary: '#1E293B', // slate-800
          accent: {
            DEFAULT: '#F59E0B', // amber-500
            hover: '#D97706'  // amber-600
          }
        }
      },
    },
    plugins: [
      require('@tailwindcss/forms'), // Plugin untuk styling form yang lebih baik
    ],
  }
