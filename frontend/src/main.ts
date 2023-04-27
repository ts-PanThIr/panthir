import { createApp, markRaw } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import { router } from './router';
import vuetify from './plugins/vuetify';
import axios from 'axios';
import { setupInterceptorsTo } from '~/plugins/axios';
import { TheSpinner } from '~/components';

setupInterceptorsTo(axios);
const app = createApp(App);
app.config.globalProperties.configVars = {
  $locale: 'pt-PT',
  $currency: 'EUR',
  $apiUrl: import.meta.env.VITE_API_URL,
};
app.provide('configVars', app.config.globalProperties.configVars);

const pinia = createPinia();
pinia.use(({ store }) => {
  store.$router = markRaw(router);
  store.$http = markRaw(axios);
  store.$apiUrl = import.meta.env.VITE_API_URL;
});

app.component('TheSpinner', TheSpinner);

app.use(pinia);
app.use(router);
app.use(vuetify);
app.mount('#app');

export default app;
