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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
                'glow-pulse': 'glow-pulse 2s ease-in-out infinite',
                'card-hover': 'card-hover 0.3s ease-out forwards',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
                'glow-pulse': {
                    '0%, 100%': { boxShadow: '0 0 5px rgba(251,191,36,0.3)' },
                    '50%': { boxShadow: '0 0 20px rgba(251,191,36,0.8)' },
                },
                'card-hover': {
                    '0%': { transform: 'translateY(0) rotateX(0) rotateY(0)' },
                    '100%': { transform: 'translateY(-8px) rotateX(5deg) rotateY(5deg)' },
                },
            },
            perspective: {
                '1000': '1000px',
            },
        },
    },

    plugins: [forms],
};
