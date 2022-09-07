<script setup>
import { Alert, TheMainAppBar, TheMainFooter, TheMainMenu } from '~/components';
</script>

<template>
  <TheMainAppBar></TheMainAppBar>

  <TheMainMenu></TheMainMenu>

  <v-main>
    <v-container fluid>
      <Alert />
      <router-view />
    </v-container>
  </v-main>

  <TheMainFooter></TheMainFooter>

</template>

<script>
export default {
  name: "TheMainLayout"
}
</script>