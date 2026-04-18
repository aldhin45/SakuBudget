import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // --- Tambahan untuk SakuBudget ---
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            },
            animation: {
                'fade-in': 'fadeIn 0.4s ease-out forwards',
            },
            // ----------------------------------
            
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans], // Ganti font agar lebih modern
            },
            colors: {
                'sakubudget-blue-dark': '#0c4d7c',
                'sakubudget-teal': '#2b95b1',
                'sakubudget-oranye': '#ff9f43',
                'sakubudget-form-bg': '#2b95b1', // Warna teal solid untuk panel formulir
            },
            backgroundImage: {
                'sakubudget-gradient': "linear-gradient(to right, #0c4d7c, #2b95b1)", // Gradien latar belakang
            },
            // ---------------------------------
        },
    },

    plugins: [forms],
};