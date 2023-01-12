import { fileURLToPath, URL } from "url";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vite-plugin
import vuetify from "vite-plugin-vuetify";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), vuetify({ autoImport: true })],
  resolve: {
    alias: {
      "~": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  // css: {
  //   loaderOptions: {
  //     scss: {
  //       // Here we can specify the older indent syntax formatted SASS
  //       // Note that there is *not* a semicolon at the end of the below line
  //       data: `@import "./src/assets/template/variables/colors.scss"`,
  //     },
  //     // scss: {
  //     //   // Here we can use the newer SCSS flavor of Sass.
  //     //   // Note that there *is* a semicolon at the end of the below line
  //     //   data: `@import "@/styles/_variables.scss";`,
  //     // },
  //   },
  // },
});
