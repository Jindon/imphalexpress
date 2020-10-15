const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
        defaultLineHeights: true,
        standardFontWeights: true
    },
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Overpass', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-focus', 'group-hover'],
    },

    plugins: [
        require('@tailwindcss/custom-forms'),
        // function ({ addComponents }) {
        //     addComponents({
        //         '.container': {
        //             width: '100%',
        //             '@screen sm': {
        //                 maxWidth: '600px',
        //             },
        //             '@screen md': {
        //                 maxWidth: '960px',
        //             },
        //             '@screen lg': {
        //                 maxWidth: '1080px',
        //             },
        //             '@screen xl': {
        //                 maxWidth: '1080px',
        //             },
        //         }
        //     })
        // }
    ],
};
