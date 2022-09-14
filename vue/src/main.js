import { createApp, provide, markRaw } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import { router } from "./router";
import vuetify from "./plugins/vuetify";
// import { loadFonts } from "./plugins/webfontloader";
import axios from "axios";
import "~/plugins/axios";
import { piniaPlugins } from "~/stores/plugins";

const app = createApp(App);
// app.config.globalProperties.$http = axios
// app.config.globalProperties.$apiUrl = import.meta.env.VITE_API_URL

const pinia = createPinia();
piniaPlugins.setContext(pinia)
piniaPlugins.setAxios(axios)
piniaPlugins.setRouter(router)
piniaPlugins.setApiUrl(import.meta.env.VITE_API_URL)

app.use(piniaPlugins.getContext());
app.use(router);
app.use(vuetify);
app.mount("#app");
