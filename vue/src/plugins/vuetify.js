// import colors from "vuetify/lib/util/colors";
import "@fortawesome/fontawesome-free/css/all.css"; // Ensure you are using css-loader
import "~/assets/base.sass";
import customColors  from "~/assets/template/exports/colors.module.scss";
// import "@mdi/font/css/materialdesignicons.css";
// import { md1 } from 'vuetify/blueprints'
import "vuetify/styles";
import { createVuetify } from "vuetify";
import { aliases, fa } from "vuetify/iconsets/fa";

const myCustomLightTheme = {
  dark: false,
  colors: {
    background: customColors.background,
    surface: customColors.surface,
    surfaceLighten: customColors.surfaceLighten,
    primary: customColors.primary,
    secondary: customColors.secondary,
    error: customColors.error,
    info: customColors.info,
    success: customColors.success,
    warning: customColors.warning,
    accent: customColors.accent,
    textDark: customColors.textDark,
  },
};

export default createVuetify({
  blueprint: {
    defaults: {
      VCombobox: {
        variant: 'underlined',
      },
      VSelect: {
        variant: 'underlined',
        color: 'textDark',
      },
      VTextarea: {
        variant: 'underlined',
        color: 'textDark',
      },
      VTextField: {
        variant: 'underlined',
        density: 'compact',
        color: 'textDark',
      },
      VTabs: {
        density: 'compact',
      },
      VTable: {
        density: 'compact',
      },
    },
  },
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
