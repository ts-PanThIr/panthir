<template>
  <v-card>
    <v-card-title>
      <h1>Hi {{ user.firstName }}!</h1>
    </v-card-title>
    <v-card-text>
      <p>You're logged in with Vue 3 + Pinia & JWT!!</p>
      <p>
        <router-link to="/users"> Manage Users </router-link>
      </p>
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import { useAuthStore } from '~/stores';

import { defineComponent } from 'vue';

export default defineComponent({
  name: 'AuthHomeView',
  setup() {
    const authStore = useAuthStore();
    const { user } = authStore;
    return { user };
  },
});
</script>
