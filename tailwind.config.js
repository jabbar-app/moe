import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js", // Pastikan ini mencakup file JavaScript Anda
    ],

    darkMode: "class", // Ini penting untuk mengaktifkan mode gelap berdasarkan kelas

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito Sans", ...defaultTheme.fontFamily.sans],
                rubik: ["Rubik", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
