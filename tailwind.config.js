/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {},
  },
  // plugins: [],
  plugins: [require("daisyui")],
};

