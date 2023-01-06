<script setup>
import { TheMainAppBar, TheMainFooter, TheMainMenu } from "~/components";
</script>

<template>
  <TheMainAppBar />

  <TheMainMenu />

  <v-main>
    <v-container fluid>
      <Suspense>
        <template #default>
          <router-view />
        </template>
        <template #fallback>
          <div>Loading...</div>
        </template>
      </Suspense>
    </v-container>
  </v-main>

  <TheMainFooter />
</template>

<script>
export default {
  name: "TheMainLayout",
};
</script>
