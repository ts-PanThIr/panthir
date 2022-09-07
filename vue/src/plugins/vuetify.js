// Styles

import colors from 'vuetify/lib/util/colors'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'

const myCustomLightTheme = {
    dark: true,
    colors: {
        background: '#161d31',
        surface: '#283046',
        primary: '#ff0000',
        secondary: '#03DAC6',
        error: colors.red.lighten3,
        info: '#2196F3',
        success: colors.green.darken1,
        warning: '#FB8C00',
        color: '#ff0000'
    },
}

export default createVuetify({
    // theme: {
    //     defaultTheme: 'dark'
    // }
    theme: {
        defaultTheme: 'myCustomLightTheme',
        themes: {
            myCustomLightTheme,
        },
    },
    // https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
})
