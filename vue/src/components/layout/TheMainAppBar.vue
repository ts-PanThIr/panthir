<script setup>
import { useAuthStore } from "~/stores";
const authStore = useAuthStore();
</script>
<template>
  <v-app-bar>
    <router-link to="/" class="nav-item nav-link">Home</router-link>
    <router-link to="/users" class="nav-item nav-link">Users</router-link>
    <v-spacer></v-spacer>
    <v-btn class="fas fa-sign-out" icon @click="authStore.logout()" title="Logout"></v-btn>
  </v-app-bar>
</template>

<script>
export default {
  name: "TheMainAppBar",
};
</script>
