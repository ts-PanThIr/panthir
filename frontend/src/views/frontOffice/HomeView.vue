<template>
  <v-container fluid>
    <v-card class="pa-2">
      <v-card-title>
        <h3 class="text-center">Hi this is home!</h3>
      </v-card-title>
      <v-card-text>
        <base-map></base-map>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {BaseMap} from '~/components'

export default defineComponent({
  name: 'HomeView',
  components: {BaseMap},

});
</script>
