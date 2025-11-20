/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./app/Livewire/**/*.php",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: "#f0f7ff",
          100: "#e0efff",
          200: "#c7e0ff",
          300: "#a8ceff",
          400: "#7fb3ff",
          500: "#5b93ff",
          600: "#3564f5",
          700: "#234fd8",
          800: "#1a3ab8",
          900: "#172f6a",
        },
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ]
}
