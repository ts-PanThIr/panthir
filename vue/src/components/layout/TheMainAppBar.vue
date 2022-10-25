<template>
  <v-app-bar>
    <v-btn
      class="fa fa-bars"
      icon
      title="Switch menu"
      @click.stop="switchMenu()"
    ></v-btn>
    <v-spacer></v-spacer>
    <v-btn
      class="fa fa-sign-out"
      icon
      title="Logout"
      @click="authStore.logout()"
    ></v-btn>
  </v-app-bar>
</template>

<script>
import { useInterfaceStore } from "~/stores";
import { useAuthStore } from "~/stores";

export default {
  name: "TheMainAppBar",
  setup() {
    const authStore = useAuthStore();
    const switchMenu = useInterfaceStore().switchMenu;
    return { switchMenu, authStore };
  },
};
</script>
