import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                main: "#b8c1ec",
                bg: "#d4d8f0",
                headline: "#232946",
                cardbg: "##fffffe",
                testiary: "#eebbc3",
            },
        },
    },

    plugins: [forms],
};
