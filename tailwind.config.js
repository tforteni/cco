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
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
                schoolbook: ['New Century Schoolbook', 'TeX Gyre Schola', 'serif'],
                garamond: ['"Cormorant Garamond"', 'serif']
            },
            fontSize: {
                '2xl': '1rem',
                '4xl': '4rem',
                '6xl': '6rem', // Custom font size '6xl' set to 6 rems
                '7xl': '8rem', // Custom font size '7xl' set to 8 rems
                '8xl': '10rem',
                '9xl': '12rem',
            },
            colors: {
                'navy': '#172336',
                'light-navy': '#25344d',
                'light': '#99b7e8',
                'navy-highlight': '#50678c',
                'tahini': '#f7ebcb',
                'dark-tahini': '#ccbb8b',
            },
            
        },
    },

    darkMode: 'class', //this disables darkmode support

    plugins: [forms],
};