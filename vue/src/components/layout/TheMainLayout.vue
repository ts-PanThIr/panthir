<script setup>
import { TheMainAppBar, TheMainFooter, TheMainMenu } from "~/components";
</script>

<template>
  <TheMainAppBar></TheMainAppBar>

  <TheMainMenu></TheMainMenu>

  <v-main>
    <v-container fluid>
      <router-view />
    </v-container>
  </v-main>

  <TheMainFooter></TheMainFooter>
</template>

<script>
export default {
  name: "TheMainLayout",
};
</script>
