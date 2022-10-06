// Styles
// https://mycolor.space/?hex=%23D0EA59&sub=1
// import colors from "vuetify/lib/util/colors";
import "@fortawesome/fontawesome-free/css/all.css"; // Ensure you are using css-loader
import "~/assets/base.sass";
// import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import { aliases, fa } from "vuetify/iconsets/fa";

/**
 * main
 * #050505
 * #30303a
 * #d0ea59
 *      #D9F752
 *      #9AAD42
 * #b189fa
 */

const myCustomLightTheme = {
  dark: true,
  colors: {
    background: "#252e42",
    surface: "#2f3b52",
    primary: "#d0ea59", //"#b189fa",
    secondary: "#b189fa",
    error: "#e06457",
    info: "#6C9FE0",
    success: "#d0ea59",
    warning: "#EDD64E",
    color: "#d0ea59",
    accent: "#9DB924",
  },
};

export default createVuetify({
  // theme: {
  //     defaultTheme: 'dark'
  // }
  icons: {
    defaultSet: "fa",
    aliases,
    sets: {
      fa,
    },
  },
  theme: {
    defaultTheme: "myCustomLightTheme",
    themes: {
      myCustomLightTheme,
      options: {
        customProperties: true,
      },
    },
  },
  // https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
});
