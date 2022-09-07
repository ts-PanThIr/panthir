<script setup>
import { Alert } from '~/components';
import { useAuthStore } from '~/stores';

const authStore = useAuthStore();
</script>

<template>
  <v-main>
    <router-view />
  </v-main>
</template>

<script>
export default {
  name: "TheEmptyLayout"
}
</script>