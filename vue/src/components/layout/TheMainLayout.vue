<script setup>
import { TheMainAppBar, TheMainFooter, TheMainMenu, TheNotifications } from "~/components";
</script>

<template>
  <TheMainAppBar />

  <TheMainMenu />

  <v-main>
    <v-container fluid>
      <suspense>
        <template #default>
          <router-view />
        </template>
        <template #fallback>
          <div>Loading...</div>
        </template>
      </suspense>
      <suspense>
        <the-notifications />
      </suspense>
    </v-container>
  </v-main>

  <TheMainFooter />
</template>

<script>
export default {
  name: "TheMainLayout",
};
</script>
