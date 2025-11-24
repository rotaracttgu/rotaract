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
            // Breakpoints personalizados para mejor control responsive
            screens: {
                'xs': '475px',
                ...defaultTheme.screens,
            },
            // Espaciado adicional para componentes responsive
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '100': '25rem',
                '112': '28rem',
                '128': '32rem',
            },
            // Animaciones suaves para transiciones responsive
            transitionProperty: {
                'width': 'width',
                'spacing': 'margin, padding',
            },
        },
    },

    plugins: [forms],
};
