<script setup>
import { storeToRefs } from "pinia";

import { useAuthStore } from "~/stores";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>

<template>
  <v-card>
    <v-card-title>
      <h1>Hi {{ user.firstName }}!</h1>
    </v-card-title>
    <v-card-text>
      <p>You're logged in with Vue 3 + Pinia & JWT!!</p>
      <p>
        <router-link to="/users">
          Manage Users
        </router-link>
      </p>
    </v-card-text>
  </v-card>
</template>
