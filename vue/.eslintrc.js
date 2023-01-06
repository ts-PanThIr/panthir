/* eslint-env node */
module.exports = {
  root: true,
  extends: [
    "plugin:vue/vue3-recommended",
    // "plugin:vue/vue3-essential",
    "eslint:recommended",
    // "plugin:prettier/recommended",
  ],
  env: {
    "vue/setup-compiler-macros": true,
    // "vue/multi-word-component-names": true
  },
  rules: {
    "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
    "vue/require-default-prop": 0,
    "vue/require-prop-types": 0,
    "vue/no-mutating-props": 0,
    "linebreak-style": ["error", "unix"],
    "implicit-arrow-linebreak": 0,
    indent: ["error", 2],
    "comma-dangle": [
      "error",
      {
        arrays: "always-multiline",
        objects: "always-multiline",
        functions: "never",
      },
    ],
    "max-len": ["error", 120],
    "wrap-iife": 0,
    "func-names": 0,
    "operator-linebreak": 0,
    "no-param-reassign": [2, { props: false }],
    "no-plusplus": 0,
    "no-restricted-syntax": 0,
    "no-underscore-dangle": 0,
    "no-new": process.env.NODE_ENV === "production" ? 1 : 0,
    "no-console": process.env.NODE_ENV === "production" ? 1 : 0,
    "no-alert": process.env.NODE_ENV === "production" ? 1 : 0,
  },
};
