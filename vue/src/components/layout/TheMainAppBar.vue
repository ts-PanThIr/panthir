<template>
  <v-app-bar>
    <router-link to="/" class="nav-item nav-link">Home</router-link>
    <router-link to="/users" class="nav-item nav-link">Users</router-link>
    <button class="btn btn-link nav-item nav-link" @click="authStore.logout()">
      Logout
    </button>
  </v-app-bar>
</template>

<script>
export default {
  name: "TheMainAppBar",
};
</script>
