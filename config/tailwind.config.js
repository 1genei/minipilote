const colors = require('tailwindcss/colors')
/** @type {import('tailwindcss').Config} */

module.exports = {
    darkMode: 'class',
    content: [
        // ....
        './app/Http/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],
    
    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js"),
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    // optional
    theme: {
        extend: {
            colors: {
                "pg-primary": colors.gray,
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms")({
          strategy: 'class',
        }),
      ]
}