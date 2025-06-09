import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
         "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#47cc04',
                'secondary': '#64748b',
                'accent': '#fbbf24',
                'neutral': '#374151',
                'base-100': '#ffffff',
                'info': '#3abff8',
                'success': '#36d399',
                'warning': '#fbbd23',
                'error': '#f87272',
                'Gray-300': '#D1D5DB',
                'Gray-200': '#E5E7EB',
                'creme': '#FFF8DE',

            },
        },
    },

    plugins: [forms,
        require('flowbite/plugin'),
    ],
};
