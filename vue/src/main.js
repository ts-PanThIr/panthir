import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import { router } from "./router";
import vuetify from "./plugins/vuetify";
import { loadFonts } from "./plugins/webfontloader";

// setup fake backend
import { fakeBackend } from "./helpers";
fakeBackend();

loadFonts();

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(vuetify);
app.mount("#app");
