<template>
  <v-card class="overflow-visible">
    <the-card-title
      text="Hi this is home!"
      icon="fa fa-person"
      bg-color="bg-secondary-gradient"
      text-color="white"
    >
    </the-card-title>
    <v-card-text>
      Hi this is home!
    </v-card-text>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { TheCardTitle } from '~/components';

export default defineComponent({
  name: 'HomeView',
  components: {TheCardTitle}
});
</script>
