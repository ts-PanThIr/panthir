<template>
  <v-app-bar class="bg-secondary-gradient">
    <img
      :width="150"
      :src="imgUrl"
    />
    <v-btn
      class="fa fa-bars"
      icon
      title="Switch menu"
      @click.stop="switchMenu()"
    />
    <v-spacer />
    <v-btn
      class="fa fa-sign-out"
      icon
      title="Logout"
      @click="authStore.logout()"
    />
  </v-app-bar>
</template>

<script lang="ts">
import { useInterfaceStore } from '~/stores';
import { useAuthStore } from '~/stores';

export default {
  name: 'TheMainAppBar',
  setup() {
    const imgUrl = new URL('~/assets/logo.svg', import.meta.url).href
    const authStore = useAuthStore();
    const switchMenu = useInterfaceStore().switchMenu;
    return { switchMenu, authStore, imgUrl };
  },
};
</script>
