/* eslint-env node */
module.exports = {
    "root": true,
    "extends": [
        'plugin:vue/vue3-recommended',
        // "plugin:vue/vue3-essential",
        "eslint:recommended",
        "plugin:prettier/recommended",
    ],
    "env": {
        "vue/setup-compiler-macros": true,
        "vue/multi-word-component-names": true
    },
    rules: {
        "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
        "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
    },
}
