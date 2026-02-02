module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#4F46E5",
                    600: "#4F46E5",
                    700: "#4338CA",
                },
                bg: "#f9fafb",
            },
            boxShadow: {
                soft: "0 6px 18px rgba(15,23,42,0.06)",
            },
            borderRadius: {
                lg: "0.5rem",
            },
        },
    },
    plugins: [],
};
